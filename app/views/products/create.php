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
                <a href="index.php?url=products/index" class="active">
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
                <a href="#">
                    <span>↓</span>
                    <span class="nav-text">Stock In</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span>↑</span>
                    <span class="nav-text">Stock Out</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span>▧</span>
                    <span class="nav-text">Reports</span>
                </a>
            </li>
        </ul>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content">

        <header class="topbar">

            <div class="page-heading">
                <h1>Add New Product</h1>
                <p>Add a new product to your inventory.</p>
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


        <!-- FORM PANEL -->
        <div class="panel">

            <div class="panel-header">
                <h3>Product Information</h3>
            </div>

            <form
                action="index.php?url=products/store"
                method="POST"
            >

                <div class="form-grid">

                    <!-- PRODUCT NAME -->
                    <div class="form-group">
                        <label>Product Name *</label>

                        <input
                            type="text"
                            name="name"
                            placeholder="Enter product name"
                            required
                        >
                    </div>


                    <!-- SKU -->
                    <div class="form-group">
                        <label>SKU *</label>

                        <input
                            type="text"
                            name="sku"
                            placeholder="Example: STK-009"
                            required
                        >
                    </div>


                    <!-- CATEGORY -->
                    <div class="form-group">
                        <label>Category *</label>

                        <select name="category_id" required>

                            <option value="">Select Category</option>

                            <?php foreach ($categories as $category): ?>

                                <option value="<?= (int) $category['id'] ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>


                    <!-- SUPPLIER -->
                    <div class="form-group">
                        <label>Supplier</label>

                        <select name="supplier_id">

                            <option value="">Select Supplier</option>

                            <?php foreach ($suppliers as $supplier): ?>

                                <option value="<?= (int) $supplier['id'] ?>">
                                    <?= htmlspecialchars($supplier['name']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>


                    <!-- PURCHASE PRICE -->
                    <div class="form-group">
                        <label>Purchase Price *</label>

                        <input
                            type="number"
                            name="purchase_price"
                            min="0"
                            step="0.01"
                            placeholder="0"
                            required
                        >
                    </div>


                    <!-- SELLING PRICE -->
                    <div class="form-group">
                        <label>Selling Price *</label>

                        <input
                            type="number"
                            name="selling_price"
                            min="0"
                            step="0.01"
                            placeholder="0"
                            required
                        >
                    </div>


                    <!-- STOCK -->
                    <div class="form-group">
                        <label>Stock Quantity *</label>

                        <input
                            type="number"
                            name="stock_quantity"
                            min="0"
                            step="1"
                            value="0"
                            required
                        >
                    </div>


                    <!-- MINIMUM STOCK -->
                    <div class="form-group">
                        <label>Minimum Stock *</label>

                        <input
                            type="number"
                            name="minimum_stock"
                            min="0"
                            step="1"
                            value="5"
                            required
                        >
                    </div>


                    <!-- UNIT -->
                    <div class="form-group">
                        <label>Unit *</label>

                        <input
                            type="text"
                            name="unit"
                            placeholder="Example: pcs, box, unit"
                            required
                        >
                    </div>


                    <!-- DESCRIPTION -->
                    <div class="form-group full-width">
                        <label>Description</label>

                        <textarea
                            name="description"
                            rows="4"
                            placeholder="Enter product description..."
                        ></textarea>
                    </div>

                </div>


                <!-- BUTTONS -->
                <div class="form-actions">

                    <a
                        href="index.php?url=products/index"
                        class="btn-cancel"
                    >
                        Cancel
                    </a>

                    <button type="submit" class="btn-primary">
                        Save Product
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>