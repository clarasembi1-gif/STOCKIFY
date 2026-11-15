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

        <!-- MAIN MENU -->
        <p class="menu-label">Main Menu</p>

        <ul class="nav-menu">

            <li>
                <a href="index.php" class="active">
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


        <!-- INVENTORY -->
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
                <a href="index.php?url=stockmovements/history">
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
                <h1>Dashboard Overview</h1>

                <p>
                    Welcome back! Here's what's happening with your inventory.
                </p>
            </div>
<div class="user-profile">

    <div class="avatar">A</div>

    <div>
        <strong>
            <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Administrator') ?>
        </strong>

        <p style="font-size:11px;color:#64748B;">
            <?= htmlspecialchars(ucfirst($_SESSION['user']['role'] ?? 'Admin')) ?>
        </p>
    </div>

    <a href="index.php?url=auth/logout"
       style="
           margin-left:20px;
           padding:10px 16px;
           background:#FEE2E2;
           color:#DC2626;
           border-radius:8px;
           text-decoration:none;
           font-size:12px;
           font-weight:600;
       ">
        Logout
    </a>

</div>

        </header>


        <!-- STATISTICS -->
        <section class="stats-grid">

            <!-- TOTAL PRODUCTS -->
            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        Total Products
                    </span>

                    <span class="stat-icon">📦</span>

                </div>

                <div class="stat-number">
                    <?= htmlspecialchars((string) $stats['total_products']) ?>
                </div>

                <p class="stat-description">
                    Registered products
                </p>

            </div>


            <!-- TOTAL STOCK -->
            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        Total Stock
                    </span>

                    <span class="stat-icon">▣</span>

                </div>

                <div class="stat-number">
                    <?= htmlspecialchars((string) $stats['total_stock']) ?>
                </div>

                <p class="stat-description">
                    Available inventory units
                </p>

            </div>


            <!-- LOW STOCK -->
            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        Low Stock Products
                    </span>

                    <span class="stat-icon">⚠️</span>

                </div>

                <div class="stat-number">
                    <?= htmlspecialchars((string) $stats['low_stock']) ?>
                </div>

                <p class="stat-description">
                    Products need restocking
                </p>

            </div>

        </section>


        <!-- CONTENT -->
        <section class="content-grid">


            <!-- RECENT PRODUCTS -->
            <div class="panel">

                <div class="panel-header">

                    <h3>Recent Products</h3>

                    <a
                        href="index.php?url=products/index"
                        style="text-decoration:none;color:var(--primary);font-size:12px;"
                    >
                        View All →
                    </a>

                </div>


                <table>

                    <thead>

                        <tr>
                            <th>PRODUCT</th>
                            <th>SKU</th>
                            <th>STOCK</th>
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

                                        <span class="stock-badge">
                                            <?= htmlspecialchars((string) $product['stock_quantity']) ?>
                                        </span>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="3">
                                    Belum ada produk.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <!-- LOW STOCK ALERT -->
            <div class="panel">

                <div class="panel-header">

                    <h3>Low Stock Alert</h3>

                    <span>Attention</span>

                </div>


                <?php if (!empty($lowStocks)): ?>

                    <?php foreach ($lowStocks as $item): ?>

                        <div class="low-stock-item">

                            <div>

                                <h4>
                                    <?= htmlspecialchars($item['name']) ?>
                                </h4>

                                <p>
                                    SKU: <?= htmlspecialchars($item['sku']) ?>
                                </p>

                            </div>

                            <span class="stock-warning">

                                <?= htmlspecialchars((string) $item['stock_quantity']) ?>
                                Left

                            </span>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>
                        Tidak ada produk dengan stok rendah.
                    </p>

                <?php endif; ?>

            </div>

        </section>

    </main>

</div>

</body>
</html>