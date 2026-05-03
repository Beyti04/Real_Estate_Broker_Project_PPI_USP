<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TU Brokers</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>

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
            <div class="nav_wrapper">
                <button class="menu_toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="nav_container">
                    <nav class="nav_links">
                        <a class="nav_link" href="index.php?action=buy_rent">Обяви</a>
                        <a class="nav_link" href="index.php?action=sell">Продай</a>
                        <a class="nav_link" href="index.php?action=agents">Агенти</a>
                    </nav>

                    <div class="sing_in_btns">
                        <button id="theme-toggle" class="btn_secondary" style="padding: 0; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-light); cursor: pointer; background: transparent;">
                            🌙
                        </button>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo '<a href="index.php?action=profile" class="btn_primary">Профил</a>';
                            echo '<a href="index.php?action=logout" class="btn_secondary">Изход</a>';
                        } else {
                            echo '<a href="index.php?action=register" class="btn_primary">Регистрация</a>';
                            echo '<a href="index.php?action=login" class="btn_secondary">Вход</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </header>
        <div class="relative_container">
            <div class="background_overlay">
                <img src="images/home_hero.png" class="media_fill">
                <div class="hero_gradient_overlay"></div>
            </div>
            <div class="hero_content_container">
                <h1 class="hero_title">Намерете вашето мечтано кътче спокойствие</h1>
                <p class="hero_subtitle">Изключителни имоти, експертно обслужване. Открийте най-добрите предложения в най-ексклузивните райони.</p>
            </div>
        </div>
        <section class="content_section">
            <div class="container_center">
                <div style="text-align:center">
                    <h2 class="section_title">Защо да изберета TU Estates</h2>
                    <p class="section_description">Осигуряваме безпроблемен процес при сделките с имоти, основан на доверие, експертен опит и лично отношение.</p>
                </div>
                <div class="properties_grid">
                    <div class="property_card">
                        <picture>
                            <img class="icon_box theme_light_img" src="images/verified.png" alt="Verified Icon">
                            <img class="icon_box theme_dark_img" src="images/verified_dark.png" alt="Verified Icon">
                        </picture>

                        <h3>Доказана експертност</h3>
                        <p class="card_description">Нашите консултанти са доказани професионалисти с дълбоки познания за пазара и солидна история от успешни сделки.</p>
                    </div>
                    <div class="property_card">
                        <picture>
                            <img class="icon_box theme_light_img" src="images/globe.png" alt="Globe Icon">
                            <img class="icon_box theme_dark_img" src="images/globe_dark.png" alt="Globe Icon">
                        </picture>

                        <h3>Национален обхват</h3>
                        <p class="card_description">Нашите консултанти са водещи професионалисти с задълбочени познания за българския пазар и доказана история от успешни сделки в най-престижните локации.</p>
                    </div>
                    <div class="property_card">
                        <picture>
                            <img class="icon_box theme_light_img" src="images/sup.png" alt="Support Icon">
                            <img class="icon_box theme_dark_img" src="images/sup_dark.png" alt="Support Icon">
                        </picture>

                        <h3>Индивидуален подход</h3>
                        <p class="card_description">Вярваме, че всяка сделка е уникална, затова поставяме Вашите индивидуални нужди в центъра на нашата работа. Нашите експерти предлагат персонални решения и внимателно отношение</p>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer_container">
            <div class="footer_grid">
                <div class="flex_column_gap">
                    <div class="flex_center_row">
                        <picture>
                        <img class="icon_box theme_light_img" src="images/broker_logo_light.png" alt="TU Brokers Logo">
                        <img class="icon_box theme_dark_img" src="images/broker_logo_dark.png" alt="TU Brokers Logo">
                    </picture>
                        <h3 class="footer_primary">TU Estates</h3>
                    </div>
                    <p class="footer_bio">Предоставяме несравними услуги в сферата на недвижимите имоти за най-взискателните клиенти. Вашият мечтан дом Ви очаква.</p>
                </div>

                <div>
                    <h3 class="footer_label">Контакт</h3>
                    <ul class="contact_list">
                        <li class="contact_item align_start">
                            <picture>
                                <source srcset="images/location_dark.png" media="(prefers-color-scheme: dark)">
                                <img class="footer_icon" src="images/location.png" alt="TU Brokers Logo">
                            </picture>
                            <span>ТУ Варна<br>гр. Варна, 9000</span>
                        </li>
                        <li class="contact_item align_center">
                            <picture>
                                <source srcset="images/phone_dark.png" media="(prefers-color-scheme: dark)">
                                <img class="footer_icon" src="images/phone.png" alt="TU Brokers Logo">
                            </picture>
                            <span>+359 89 *** ****</span>
                        </li>
                        <li class="contact_item align_center">
                            <picture>
                                <source srcset="images/email_dark.png" media="(prefers-color-scheme: dark)">
                                <img class="footer_icon" src="images/email.png" alt="TU Brokers Logo">
                            </picture>
                            <span>TU.Estates@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>