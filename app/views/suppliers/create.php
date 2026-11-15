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

        <div class="brand">STOCK<span>IFY.</span></div>

        <p class="menu-label">Main Menu</p>

        <ul class="nav-menu">
            <li><a href="index.php"><span>▦</span><span class="nav-text">Dashboard</span></a></li>
            <li><a href="index.php?url=products/index"><span>▤</span><span class="nav-text">Products</span></a></li>
            <li><a href="index.php?url=categories/index"><span>▧</span><span class="nav-text">Categories</span></a></li>
            <li><a href="index.php?url=suppliers/index" class="active"><span>♧</span><span class="nav-text">Suppliers</span></a></li>
        </ul>

        <p class="menu-label">Inventory</p>

        <ul class="nav-menu">
            <li><a href="#"><span>↓</span><span class="nav-text">Stock In</span></a></li>
            <li><a href="#"><span>↑</span><span class="nav-text">Stock Out</span></a></li>
            <li><a href="#"><span>▧</span><span class="nav-text">Reports</span></a></li>
        </ul>

    </aside>


    <main class="main-content">

        <header class="topbar">

            <div class="page-heading">
                <h1>Add New Supplier</h1>
                <p>Add a new business supplier to your inventory.</p>
            </div>

            <div class="user-profile">
                <div class="avatar">A</div>
                <div>
                    <strong>Administrator</strong>
                    <p style="font-size:11px;color:#64748B;">System Admin</p>
                </div>
            </div>

        </header>


        <div class="panel">

            <div class="panel-header">
                <h3>Supplier Information</h3>
            </div>

            <form action="index.php?url=suppliers/store" method="POST">

                <div class="form-grid">

                    <div class="form-group">
                        <label>Supplier Name *</label>

                        <input
                            type="text"
                            name="name"
                            placeholder="Enter supplier name"
                            maxlength="100"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label>Contact Person</label>

                        <input
                            type="text"
                            name="contact_person"
                            placeholder="Enter contact person"
                        >
                    </div>


                    <div class="form-group">
                        <label>Phone Number</label>

                        <input
                            type="text"
                            name="phone"
                            placeholder="Example: 081234567890"
                        >
                    </div>


                    <div class="form-group">
                        <label>Email Address</label>

                        <input
                            type="email"
                            name="email"
                            placeholder="Example: supplier@email.com"
                        >
                    </div>


                    <div class="form-group full-width">
                        <label>Address</label>

                        <textarea
                            name="address"
                            rows="4"
                            placeholder="Enter supplier address"
                        ></textarea>
                    </div>

                </div>


                <div class="form-actions">

                    <a
                        href="index.php?url=suppliers/index"
                        class="btn-cancel"
                    >
                        Cancel
                    </a>

                    <button type="submit" class="btn-primary">
                        Save Supplier
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>