<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профил - TU Estates</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <div class="main_wrapper">
        <header>
            <div class="logo">
                <a class="logo_group" href="index.php?action=homepage">
                    <picture>
                        <img class="icon_box theme_light_img" src="images/broker_logo_light.png" alt="TU Brokers Logo">
                        <img class="icon_box theme_dark_img" src="images/broker_logo_dark.png" alt="TU Brokers Logo">
                    </picture>
                    <h1 class="heading_primary">TU Estates</h1>
                </a>
            </div>

            <div class="desktop_search_container">
                <div class="relative_container">
                    <div class="input_icon_wrapper">
                        <img src="images/search_icon.png" alt="Search Icon">
                    </div>
                    <input class="input_field" placeholder="Адрес, град или квартал..." type="text">
                </div>
            </div>

            <div class="nav_wrapper">
                <button class="menu_toggle" id="menuToggle">
                    <span></span><span></span><span></span>
                </button>
                <div class="nav_container">
                    <nav class="nav_links">
                        <a class="nav_link" href="index.php?action=buy_rent">Купи/Наеми</a>
                        <a class="nav_link" href="index.php?action=sell">Продай</a>
                        <a class="nav_link" href="index.php?action=agent">Брокери</a>
                    </nav>

                    <div class="sing_in_btns">
                        <button id="theme-toggle" class="btn_secondary" style="padding: 0; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; background: transparent;">
                            🌙
                        </button>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="index.php?action=profile" class="btn_primary">Профил</a>
                            <a href="index.php?action=logout" class="btn_secondary">Изход</a>
                        <?php else: ?>
                            <a href="index.php?action=register" class="btn_primary">Регистрация</a>
                            <a href="index.php?action=login" class="btn_secondary">Вход</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <main class="profile_wrapper">
            <div class="profile_card">
                <h2 class="profile_title">Профил</h2>
                <?php
                $user = \App\Controllers\UserController::getUserById($_SESSION['user_id']);
                ?>
                <form action="index.php?action=profile_update" method="POST" class="profile_form">
                    <div class="form_group">
                        <label for="username">Потребителско име</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername() ?? '') ?>" placeholder="Вашето име" required>
                    </div>

                    <div class="form_group">
                        <label for="email">Имейл</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail() ?? '') ?>" placeholder="name@example.com" required>
                    </div>

                    <div class="form_group">
                        <label for="phone">Телефон</label>
                        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user->getPhone() ?? '') ?>" placeholder="+359 89 1231231">
                    </div>

                    <div class="form_group">
                        <label for="password">Нова парола <span style="font-weight: 300; font-size: 0.8em; opacity: 0.7;">(по желание)</span></label>
                        <input type="password" id="password" name="password" placeholder="••••••••••">
                    </div>

                    <div class="profile_actions">
                        <button type="submit" class="btn_primary">Запази промените</button>
                        <a href="index.php?action=homepage" class="btn_secondary" style="text-decoration: none;">Отказ</a>
                    </div>

                    <?php
                    if (isset($_SESSION['error_message'])) {
                        echo '<div class="error_message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
                    }
                    ?>
                </form>
            </div>
        </main>
    </div>
</body>

</html>