<?php

class StockMovementsController extends Controller
{
    private $movement;

    public function __construct()
    {
        $this->movement = $this->model('StockMovement');
    }

    // Halaman Stock In
    public function stockIn()
    {
        $data = [
            'title' => 'Stock In - Stockify',
            'products' => $this->movement->getProducts(),
            'type' => 'in'
        ];

        $this->view('stock/in', $data);
    }

    // Halaman Stock Out
    public function stockOut()
    {
        $data = [
            'title' => 'Stock Out - Stockify',
            'products' => $this->movement->getProducts(),
            'type' => 'out'
        ];

        $this->view('stock/out', $data);
    }

    // Menyimpan Stock In
    public function storeIn()
    {
        $this->processMovement('in');
    }

    // Menyimpan Stock Out
    public function storeOut()
    {
        $this->processMovement('out');
    }

    // Memproses transaksi
    private function processMovement($type)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $productId = filter_input(
            INPUT_POST,
            'product_id',
            FILTER_VALIDATE_INT
        );

        $quantity = filter_input(
            INPUT_POST,
            'quantity',
            FILTER_VALIDATE_INT
        );

        $notes = trim($_POST['notes'] ?? '');

        // Validasi
        if (
            !$productId ||
            !$quantity ||
            $quantity <= 0
        ) {
            exit('Data transaksi tidak valid.');
        }

        try {

            // Simpan transaksi
            $this->movement->createMovement(
                $productId,
                $type,
                $quantity,
                $notes
            );

            // Redirect
            $page = ($type === 'in')
                ? 'stockIn'
                : 'stockOut';

            header(
                'Location: index.php?url=stockmovements/' .
                $page . '&success=1'
            );

            exit;

        } catch (Throwable $e) {

            exit(
                'Transaksi gagal: ' .
                htmlspecialchars($e->getMessage())
            );
        }
    }

    // Riwayat transaksi
    public function history()
{
    // Ambil filter dari URL
    $search = trim($_GET['search'] ?? '');
    $type = $_GET['type'] ?? '';
    $dateFrom = $_GET['date_from'] ?? '';
    $dateTo = $_GET['date_to'] ?? '';

    // Validasi jenis transaksi
    if (!in_array($type, ['', 'in', 'out'], true)) {
        $type = '';
    }

    // Validasi format tanggal
    $dateFrom = $this->validateDate($dateFrom);
    $dateTo = $this->validateDate($dateTo);

    // Pastikan tanggal awal tidak melebihi tanggal akhir
    if ($dateFrom && $dateTo && $dateFrom > $dateTo) {
        $dateFrom = '';
        $dateTo = '';
    }

    // Kirim filter ke Model
    $filters = [
        'search' => $search,
        'type' => $type,
        'date_from' => $dateFrom,
        'date_to' => $dateTo
    ];

    $data = [
        'title' => 'Stock History - Stockify',
        'movements' => $this->movement->getAll($filters),
        'filters' => $filters
    ];

    $this->view('stock/history', $data);
}


// Validasi tanggal YYYY-MM-DD
private function validateDate($date)
{
    if (empty($date)) {
        return '';
    }

    $parsedDate = DateTime::createFromFormat('!Y-m-d', $date);

    if ($parsedDate && $parsedDate->format('Y-m-d') === $date) {
        return $date;
    }

    return '';
}
public function exportExcel()
{
    $search = trim($_GET['search'] ?? '');
    $type = $_GET['type'] ?? '';
    $dateFrom = $this->validateDate($_GET['date_from'] ?? '');
    $dateTo = $this->validateDate($_GET['date_to'] ?? '');

    if (!in_array($type, ['', 'in', 'out'], true)) {
        $type = '';
    }

    if ($dateFrom && $dateTo && $dateFrom > $dateTo) {
        exit('Rentang tanggal tidak valid.');
    }

    $filters = [
        'search' => $search,
        'type' => $type,
        'date_from' => $dateFrom,
        'date_to' => $dateTo
    ];

    $movements = $this->movement->getAll($filters);

    // Download CSV yang dapat dibuka di Microsoft Excel
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="stockify-report-' . date('Y-m-d') . '.csv"');

    // UTF-8 BOM agar karakter terbaca dengan benar di Excel
    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');

    fputcsv($output, [
        'No',
        'Product',
        'SKU',
        'Transaction Type',
        'Quantity',
        'Unit',
        'Notes',
        'Date'
    ], ';');

    $no = 1;

    foreach ($movements as $movement) {
        fputcsv($output, [
            $no++,
            $movement['product_name'],
            $movement['sku'],
            strtoupper($movement['type']),
            $movement['quantity'],
            $movement['unit'],
            $movement['notes'] ?? '-',
            $movement['created_at']
        ], ';');
    }

    fclose($output);
    exit;
}
public function exportPDF()
{
    require_once __DIR__ . '/../../vendor/autoload.php';

    $search = trim($_GET['search'] ?? '');
    $type = $_GET['type'] ?? '';
    $dateFrom = $this->validateDate($_GET['date_from'] ?? '');
    $dateTo = $this->validateDate($_GET['date_to'] ?? '');

    if (!in_array($type, ['', 'in', 'out'], true)) {
        $type = '';
    }

    if ($dateFrom && $dateTo && $dateFrom > $dateTo) {
        exit('Rentang tanggal tidak valid.');
    }

    $filters = [
        'search' => $search,
        'type' => $type,
        'date_from' => $dateFrom,
        'date_to' => $dateTo
    ];

    $movements = $this->movement->getAll($filters);

    $totalIn = 0;
    $totalOut = 0;

    foreach ($movements as $movement) {
        if ($movement['type'] === 'in') {
            $totalIn += (int) $movement['quantity'];
        } elseif ($movement['type'] === 'out') {
            $totalOut += (int) $movement['quantity'];
        }
    }

    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">

        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 10px;
                color: #1E293B;
            }

            h1 {
                text-align: center;
                color: #4F46E5;
                margin-bottom: 5px;
            }

            .subtitle {
                text-align: center;
                color: #64748B;
                margin-bottom: 25px;
            }

            .summary {
                width: 100%;
                margin-bottom: 20px;
            }

            .summary td {
                padding: 12px;
                border: 1px solid #E2E8F0;
                text-align: center;
            }

            .summary strong {
                display: block;
                font-size: 16px;
                margin-top: 5px;
            }

            table.report {
                width: 100%;
                border-collapse: collapse;
            }

            table.report th {
                background: #312E81;
                color: white;
                padding: 9px 5px;
            }

            table.report td {
                border: 1px solid #E2E8F0;
                padding: 8px 5px;
            }

            .in {
                color: #15803D;
                font-weight: bold;
            }

            .out {
                color: #DC2626;
                font-weight: bold;
            }

            .footer {
                margin-top: 25px;
                text-align: right;
                color: #64748B;
            }
        </style>
    </head>

    <body>

        <h1>STOCKIFY</h1>

        <div class="subtitle">
            INVENTORY TRANSACTION REPORT
        </div>

        <p>
            <strong>Generated:</strong> ' . date('d-m-Y H:i:s') . '
        </p>

        <table class="summary">
            <tr>
                <td>
                    TOTAL STOCK IN
                    <strong style="color:#15803D;">' . $totalIn . '</strong>
                </td>

                <td>
                    TOTAL STOCK OUT
                    <strong style="color:#DC2626;">' . $totalOut . '</strong>
                </td>

                <td>
                    TOTAL TRANSACTIONS
                    <strong>' . count($movements) . '</strong>
                </td>
            </tr>
        </table>

        <table class="report">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Notes</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>';

    if (!empty($movements)) {
        $no = 1;

        foreach ($movements as $movement) {

            $typeLabel = strtoupper($movement['type']);
            $typeClass = $movement['type'] === 'in' ? 'in' : 'out';

            $html .= '
                <tr>
                    <td>' . $no++ . '</td>

                    <td>' . htmlspecialchars($movement['product_name']) . '</td>

                    <td>' . htmlspecialchars($movement['sku']) . '</td>

                    <td class="' . $typeClass . '">' . $typeLabel . '</td>

                    <td>' . (int) $movement['quantity'] . ' ' .
                        htmlspecialchars($movement['unit']) . '</td>

                    <td>' . htmlspecialchars($movement['notes'] ?? '-') . '</td>

                    <td>' . date(
                        'd-m-Y H:i',
                        strtotime($movement['created_at'])
                    ) . '</td>
                </tr>';
        }

    } else {

        $html .= '
            <tr>
                <td colspan="7" style="text-align:center;">
                    No transaction records found.
                </td>
            </tr>';
    }

    $html .= '
            </tbody>
        </table>

        <div class="footer">
            STOCKIFY Inventory Management System
        </div>

    </body>
    </html>';

    $dompdf = new \Dompdf\Dompdf();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $dompdf->stream(
        'stockify-report-' . date('Y-m-d') . '.pdf',
        ['Attachment' => true]
    );

    exit;
}
}