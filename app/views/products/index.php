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
                <h1>Product Management</h1>
                <p>Manage and monitor all your inventory products.</p>
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


        <!-- PRODUCT PANEL -->
        <div class="panel">

            <div class="panel-header">

                <div>
                    <h3>All Products</h3>

                    <p style="font-size:12px;color:#64748B;margin-top:7px;">
                        Total: <?= count($products) ?> products
                    </p>
                </div>

                <a href="index.php?url=products/create"
                   class="btn-primary">
                    + Add New Product
                </a>

            </div>


            <!-- SEARCH -->
            <form method="GET" action="index.php" class="search-form">

                <input type="hidden" name="url" value="products/index">

                <input
                    type="text"
                    name="search"
                    placeholder="Search product name or SKU..."
                    value="<?= htmlspecialchars($keyword) ?>"
                >

                <button type="submit" class="btn-search">
                    Search
                </button>

            </form>


            <!-- TABLE -->
            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>SKU</th>
                            <th>CATEGORY</th>
                            <th>SUPPLIER</th>
                            <th>PRICE</th>
                            <th>STOCK</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($products)): ?>

                        <?php foreach ($products as $product): ?>

                        <tr>

                            <td class="product-name">
                                <?= htmlspecialchars($product['name']) ?>
                            </td>

                            <td class="sku">
                                <?= htmlspecialchars($product['sku']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($product['category_name'] ?? '-') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($product['supplier_name'] ?? '-') ?>
                            </td>

                            <td>
                                Rp <?= number_format((float) $product['selling_price'], 0, ',', '.') ?>
                            </td>

                            <td>
                                <span class="<?= $product['stock_quantity'] <= $product['minimum_stock'] ? 'stock-warning' : 'stock-badge' ?>">
                                    <?= htmlspecialchars((string) $product['stock_quantity']) ?>
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a
                                        href="index.php?url=products/edit&id=<?= (int) $product['id'] ?>"
                                        class="btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="index.php?url=products/delete"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $product['id'] ?>"
                                        >

                                        <button type="submit" class="btn-delete">
                                            Delete
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7" style="text-align:center;padding:30px;">
                                No products found.
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