<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title) ?></title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="app-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            STOCK<span>IFY.</span>
        </div>

        <p class="menu-label">Main Menu</p>

        <ul class="nav-menu">

            <li>
                <a href="index.php">
                    <span>▦</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=products/index">
                    <span>▤</span>
                    <span class="nav-text">Products</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=categories/index">
                    <span>▧</span>
                    <span class="nav-text">Categories</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=suppliers/index">
                    <span>♧</span>
                    <span class="nav-text">Suppliers</span>
                </a>
            </li>

        </ul>

        <p class="menu-label">Inventory</p>

        <ul class="nav-menu">

            <li>
                <a href="index.php?url=stockmovements/stockIn">
                    <span>↓</span>
                    <span class="nav-text">Stock In</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=stockmovements/stockOut">
                    <span>↑</span>
                    <span class="nav-text">Stock Out</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=stockmovements/history" class="active">
                    <span>▧</span>
                    <span class="nav-text">Stock History</span>
                </a>
            </li>

        </ul>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="page-heading">
                <h1>Stock Reports</h1>

                <p>
                    Monitor and analyze your inventory transactions.
                </p>
            </div>

            <div class="user-profile">

                <div class="avatar">A</div>

                <div>
                    <strong>Administrator</strong>

                    <p style="font-size:11px;color:#64748B;">
                        System Admin
                    </p>
                </div>

            </div>

        </header>


        <!-- FILTER PANEL -->
        <div class="panel">

            <div class="panel-header">
                <h3>Filter Transactions</h3>
            </div>

            <form method="GET" action="index.php" class="report-filter">

                <input
                    type="hidden"
                    name="url"
                    value="stockmovements/history"
                >

                <!-- SEARCH -->
                <div class="form-group">

                    <label for="search">Search Product</label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Product name or SKU"
                        value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                    >

                </div>


                <!-- TRANSACTION TYPE -->
                <div class="form-group">

                    <label for="type">Transaction Type</label>

                    <select name="type" id="type" class="form-control">

                        <option value="">All Transactions</option>

                        <option
                            value="in"
                            <?= (($filters['type'] ?? '') === 'in') ? 'selected' : '' ?>
                        >
                            Stock In
                        </option>

                        <option
                            value="out"
                            <?= (($filters['type'] ?? '') === 'out') ? 'selected' : '' ?>
                        >
                            Stock Out
                        </option>

                    </select>

                </div>


                <!-- START DATE -->
                <div class="form-group">

                    <label for="date_from">Start Date</label>

                    <input
                        type="date"
                        name="date_from"
                        id="date_from"
                        class="form-control"
                        value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>"
                    >

                </div>


                <!-- END DATE -->
                <div class="form-group">

                    <label for="date_to">End Date</label>

                    <input
                        type="date"
                        name="date_to"
                        id="date_to"
                        class="form-control"
                        value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>"
                    >

                </div>


                <!-- FILTER BUTTONS -->
                <div class="report-actions">

                    <button type="submit" class="btn-primary">
                        Search & Filter
                    </button>

                    <a
                        href="index.php?url=stockmovements/history"
                        class="btn-cancel"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>


        <!-- TRANSACTION HISTORY -->
        <div class="panel" style="margin-top:25px;">

            <div class="panel-header">

                <div>
                    <h3>Transaction History</h3>

                    <p style="font-size:12px;color:#64748B;margin-top:7px;">
                        Showing inventory transaction records.
                    </p>
                </div>


                <!-- EXPORT BUTTONS -->
                <div style="display:flex;gap:10px;flex-wrap:wrap;">

                    <!-- EXPORT EXCEL -->
                    <a
                        href="index.php?url=stockmovements/exportExcel&<?= htmlspecialchars(http_build_query($filters ?? []), ENT_QUOTES, 'UTF-8') ?>"
                        class="btn-primary"
                        style="background:#10B981;"
                    >
                        ↓ Export Excel
                    </a>

                    <!-- EXPORT PDF -->
                    <a
                        href="index.php?url=stockmovements/exportPDF&<?= htmlspecialchars(http_build_query($filters ?? []), ENT_QUOTES, 'UTF-8') ?>"
                        class="btn-primary"
                        style="background:#DC2626;"
                    >
                        ↓ Export PDF
                    </a>

                    <!-- STOCK IN -->
                    <a
                        href="index.php?url=stockmovements/stockIn"
                        class="btn-primary"
                    >
                        + Stock In
                    </a>

                </div>

            </div>


            <!-- TABLE -->
            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>PRODUCT</th>
                            <th>SKU</th>
                            <th>TYPE</th>
                            <th>QUANTITY</th>
                            <th>NOTES</th>
                            <th>DATE</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($movements)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($movements as $movement): ?>

                                <tr>

                                    <td>
                                        <?= $no++ ?>
                                    </td>

                                    <td class="product-name">
                                        <?= htmlspecialchars($movement['product_name']) ?>
                                    </td>

                                    <td class="sku">
                                        <?= htmlspecialchars($movement['sku']) ?>
                                    </td>

                                    <td>

                                        <?php if ($movement['type'] === 'in'): ?>

                                            <span class="movement-badge movement-in">
                                                ↓ Stock In
                                            </span>

                                        <?php elseif ($movement['type'] === 'out'): ?>

                                            <span class="movement-badge movement-out">
                                                ↑ Stock Out
                                            </span>

                                        <?php else: ?>

                                            <span class="movement-badge movement-adjustment">
                                                Adjustment
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>
                                        <?= number_format((int) $movement['quantity']) ?>
                                        <?= htmlspecialchars($movement['unit']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($movement['notes'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            date(
                                                'd-m-Y H:i',
                                                strtotime($movement['created_at'])
                                            )
                                        ) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="7" style="text-align:center;padding:30px;">
                                    No transaction history found.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>