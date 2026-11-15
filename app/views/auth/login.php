<?php
$error = $error ?? '';
$title = $title ?? 'Login - Stockify';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8FAFC;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
        }

        .login-container {
            width: 100%;
            max-width: 1050px;
            min-height: 620px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #FFFFFF;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        .login-banner {
            background: #111827;
            padding: 55px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .brand {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .brand span {
            color: #818CF8;
        }

        .banner-content {
            position: relative;
            z-index: 2;
        }

        .banner-content h1 {
            font-size: 36px;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .banner-content p {
            color: #CBD5E1;
            font-size: 14px;
            line-height: 1.8;
            max-width: 350px;
        }

        .banner-decoration {
            position: absolute;
            width: 350px;
            height: 350px;
            border: 1px solid rgba(129, 140, 248, 0.2);
            border-radius: 50%;
            right: -130px;
            bottom: -100px;
        }

        .banner-decoration::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border: 1px solid rgba(129, 140, 248, 0.2);
            border-radius: 50%;
            top: 45px;
            left: 45px;
        }

        .banner-footer {
            color: #94A3B8;
            font-size: 11px;
            position: relative;
            z-index: 2;
        }

        .login-form-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 55px;
        }

        .login-form {
            width: 100%;
            max-width: 360px;
        }

        .login-heading {
            margin-bottom: 35px;
        }

        .login-heading h2 {
            font-size: 28px;
            color: #1E293B;
            margin-bottom: 10px;
        }

        .login-heading p {
            color: #64748B;
            font-size: 13px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            height: 48px;
            padding: 0 15px;
            border: 1px solid #E2E8F0;
            border-radius: 9px;
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #6366F1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .btn-login {
            width: 100%;
            height: 49px;
            border: none;
            border-radius: 9px;
            background: #6366F1;
            color: white;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: #4F46E5;
            transform: translateY(-1px);
        }

        .error-message {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
            border-radius: 8px;
            padding: 12px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .login-note {
            text-align: center;
            color: #94A3B8;
            font-size: 11px;
            margin-top: 25px;
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-banner {
                display: none;
            }

            .login-form-section {
                padding: 40px 25px;
                min-height: 550px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">

        <!-- LEFT BANNER -->
        <section class="login-banner">

            <div class="brand">
                STOCK<span>IFY.</span>
            </div>

            <div class="banner-content">

                <h1>
                    Manage Your<br>
                    Inventory Smarter.
                </h1>

                <p>
                    Take control of your inventory with a simple,
                    organized, and efficient management system.
                </p>

            </div>

            <div class="banner-footer">
                © <?= date('Y') ?> STOCKIFY. All rights reserved.
            </div>

            <div class="banner-decoration"></div>

        </section>


        <!-- RIGHT LOGIN FORM -->
        <section class="login-form-section">

            <div class="login-form">

                <div class="login-heading">

                    <h2>Welcome Back!</h2>

                    <p>
                        Please enter your account details
                        to access your dashboard.
                    </p>

                </div>


                <!-- ERROR MESSAGE -->
                <?php if (!empty($error)): ?>

                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>

                <?php endif; ?>


                <!-- LOGIN FORM -->
                <form
                    action="index.php?url=auth/authenticate"
                    method="POST"
                >

                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            autocomplete="username"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                    </div>


                    <button type="submit" class="btn-login">
                        Sign In
                    </button>

                </form>


                <div class="login-note">
                    STOCKIFY Inventory Management System
                </div>

            </div>

        </section>

    </div>

</body>
</html>