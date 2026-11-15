<?php
// Data ditampilkan berdasarkan hasil query database.
?>

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
                <a href="index.php?url=suppliers/index" class="active">
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
                <h1>Supplier Management</h1>
                <p>Manage and monitor your business suppliers.</p>
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


        <!-- SUPPLIER PANEL -->
        <div class="panel">

            <div class="panel-header">

                <div>
                    <h3>All Suppliers</h3>

                    <p style="font-size:12px;color:#64748B;margin-top:7px;">
                        Total: <?= count($suppliers) ?> suppliers
                    </p>
                </div>

                <a href="index.php?url=suppliers/create"
                   class="btn-primary">
                    + Add New Supplier
                </a>

            </div>


            <!-- SEARCH -->
            <form method="GET" action="index.php" class="search-form">

                <input type="hidden" name="url" value="suppliers/index">

                <input
                    type="text"
                    name="search"
                    placeholder="Search supplier name, contact or email..."
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
                            <th>SUPPLIER</th>
                            <th>CONTACT PERSON</th>
                            <th>PHONE</th>
                            <th>EMAIL</th>
                            <th>ADDRESS</th>
                            <th>PRODUCTS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($suppliers)): ?>

                        <?php foreach ($suppliers as $supplier): ?>

                        <tr>

                            <td class="product-name">
                                <?= htmlspecialchars($supplier['name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($supplier['contact_person']) ?>
                            </td>

                            <td class="sku">
                                <?= htmlspecialchars($supplier['phone']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($supplier['email']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($supplier['address']) ?>
                            </td>

                            <td>
                                <span class="stock-badge">
                                    <?= (int) $supplier['total_products'] ?> Products
                                </span>
                            </td>

                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="index.php?url=suppliers/edit&id=<?= (int) $supplier['id'] ?>"
                                        class="btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="index.php?url=suppliers/delete"
                                        onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $supplier['id'] ?>"
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
                                No suppliers found.
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