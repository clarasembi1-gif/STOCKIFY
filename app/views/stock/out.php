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
                <a href="index.php?url=stockmovements/stockOut"
                   class="active">
                    <span>↑</span>
                    <span class="nav-text">Stock Out</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=stockmovements/history">
                    <span>▧</span>
                    <span class="nav-text">Stock History</span>
                </a>
            </li>

        </ul>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content">

        <header class="topbar">

            <div class="page-heading">
                <h1>Stock Out</h1>
                <p>Record outgoing products from your inventory.</p>
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


        <!-- SUCCESS MESSAGE -->
        <?php if (isset($_GET['success'])): ?>

            <div class="success-message">
                Stock Out successfully recorded!
            </div>

        <?php endif; ?>


        <!-- STOCK OUT FORM -->
        <div class="panel">

            <div class="panel-header">

                <div>
                    <h3>Outgoing Stock Information</h3>

                    <p style="font-size:12px;color:#64748B;margin-top:7px;">
                        Fill in the details to record outgoing stock.
                    </p>
                </div>

            </div>


            <?php if (!empty($products)): ?>

                <form
                    method="POST"
                    action="index.php?url=stockmovements/storeOut"
                    class="stock-form"
                >

                    <!-- PRODUCT -->
                    <div class="form-group">

                        <label for="product_id">
                            Select Product *
                        </label>

                        <select
                            name="product_id"
                            id="product_id"
                            class="form-control"
                            required
                        >

                            <option value="">
                                Select Product
                            </option>

                            <?php foreach ($products as $product): ?>

                                <option
                                    value="<?= (int) $product['id'] ?>"
                                    data-stock="<?= (int) $product['stock_quantity'] ?>"
                                    data-unit="<?= htmlspecialchars($product['unit']) ?>"
                                >
                                    <?= htmlspecialchars($product['name']) ?>
                                    (<?= htmlspecialchars($product['sku']) ?>)
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- AVAILABLE STOCK -->
                    <div class="form-group">

                        <label for="current_stock">
                            Available Stock
                        </label>

                        <input
                            type="text"
                            id="current_stock"
                            class="form-control"
                            value="Select a product first"
                            readonly
                        >

                    </div>


                    <!-- QUANTITY -->
                    <div class="form-group">

                        <label for="quantity">
                            Outgoing Quantity *
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            class="form-control"
                            min="1"
                            placeholder="Enter outgoing quantity"
                            required
                        >

                    </div>


                    <!-- NOTES -->
                    <div class="form-group full-width">

                        <label for="notes">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            class="form-control"
                            rows="4"
                            placeholder="Enter transaction notes (optional)"
                        ></textarea>

                    </div>


                    <!-- BUTTONS -->
                    <div class="form-actions">

                        <a
                            href="index.php"
                            class="btn-cancel"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn-primary"
                        >
                            ↑ Record Stock Out
                        </button>

                    </div>

                </form>

            <?php else: ?>

                <p>
                    No products available. Please add a product first.
                </p>

            <?php endif; ?>

        </div>

    </main>

</div>


<!-- JAVASCRIPT -->
<script>

const productSelect = document.getElementById('product_id');
const currentStock = document.getElementById('current_stock');
const quantityInput = document.getElementById('quantity');

if (productSelect && currentStock && quantityInput) {

    productSelect.addEventListener('change', function () {

        const selected = this.options[this.selectedIndex];

        if (selected.value !== '') {

            const stock = parseInt(selected.dataset.stock);
            const unit = selected.dataset.unit;

            currentStock.value = stock + ' ' + unit;

            quantityInput.max = stock;

        } else {

            currentStock.value = 'Select a product first';

            quantityInput.removeAttribute('max');

        }

    });

}

</script>

</body>
</html>