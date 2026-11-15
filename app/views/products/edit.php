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


    <main class="main-content">

        <header class="topbar">

            <div class="page-heading">
                <h1>Edit Product</h1>
                <p>Update your product information.</p>
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


        <div class="panel">

            <div class="panel-header">
                <h3>Product Information</h3>
            </div>

            <form action="index.php?url=products/update" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $product['id'] ?>"
                >

                <div class="form-grid">

                    <div class="form-group">
                        <label>Product Name *</label>

                        <input
                            type="text"
                            name="name"
                            value="<?= htmlspecialchars($product['name']) ?>"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label>SKU *</label>

                        <input
                            type="text"
                            name="sku"
                            value="<?= htmlspecialchars($product['sku']) ?>"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label>Category *</label>

                        <select name="category_id" required>

                            <?php foreach ($categories as $category): ?>

                                <option
                                    value="<?= (int) $category['id'] ?>"
                                    <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>
                                >
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label>Supplier</label>

                        <select name="supplier_id">

                            <option value="">Select Supplier</option>

                            <?php foreach ($suppliers as $supplier): ?>

                                <option
                                    value="<?= (int) $supplier['id'] ?>"
                                    <?= $product['supplier_id'] == $supplier['id'] ? 'selected' : '' ?>
                                >
                                    <?= htmlspecialchars($supplier['name']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label>Purchase Price *</label>

                        <input
                            type="number"
                            name="purchase_price"
                            min="0"
                            step="0.01"
                            value="<?= htmlspecialchars((string) $product['purchase_price']) ?>"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label>Selling Price *</label>

                        <input
                            type="number"
                            name="selling_price"
                            min="0"
                            step="0.01"
                            value="<?= htmlspecialchars((string) $product['selling_price']) ?>"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label>Stock Quantity *</label>

                        <input
                            type="number"
                            name="stock_quantity"
                            min="0"
                            value="<?= htmlspecialchars((string) $product['stock_quantity']) ?>"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label>Minimum Stock *</label>

                        <input
                            type="number"
                            name="minimum_stock"
                            min="0"
                            value="<?= htmlspecialchars((string) $product['minimum_stock']) ?>"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label>Unit *</label>

                        <input
                            type="text"
                            name="unit"
                            value="<?= htmlspecialchars($product['unit']) ?>"
                            required
                        >
                    </div>


                    <div class="form-group full-width">
                        <label>Description</label>

                        <textarea
                            name="description"
                            rows="4"
                        ><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>

                </div>


                <div class="form-actions">

                    <a
                        href="index.php?url=products/index"
                        class="btn-cancel"
                    >
                        Cancel
                    </a>

                    <button type="submit" class="btn-primary">
                        Update Product
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>