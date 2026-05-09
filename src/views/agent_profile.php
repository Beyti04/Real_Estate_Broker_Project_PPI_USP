<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($agent->getUsername()); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/agent_profile.css">
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
                    <div class="sing_in_btns">
                        <button id="theme-toggle" class="btn_secondary" style="padding: 0; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-light); cursor: pointer; background: transparent;">
                            🌙
                        </button>
                        <a href="index.php?action=agents" class="btn_primary">Обратно към агентите</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="content_section">
            <div class="agent-profile-page">
                <div class="agent-profile-card">

                    <div class="agent-profile-image">
                        <img
                            src="<?= $agent->getImage() !== "-" && !empty($agent->getImage()) ? htmlspecialchars($agent->getImage()) : 'images/base_broker.png'; ?>"
                            alt="<?= htmlspecialchars($agent->getUsername()); ?>">
                    </div>

                    <div class="agent-profile-content">

                        <h2><?= htmlspecialchars($agent->getUsername()); ?></h2>

                        <p style="display:flex; gap:10px; align-items:center;">
                            <picture>
                                <img class="footer_icon theme_light_img" src="images/email.png">
                                <img class="footer_icon theme_dark_img" src="images/email_dark.png">
                            </picture>

                            <?= htmlspecialchars($agent->getEmail()); ?>
                        </p>

                        <p style="display:flex; gap:10px; align-items:center;">
                            <picture>
                                <img class="footer_icon theme_light_img" src="images/phone.png">
                                <img class="footer_icon theme_dark_img" src="images/phone_dark.png">
                            </picture>

                            <?= htmlspecialchars($agent->getPhone() ?? 'Не е наличен'); ?>
                        </p>

                        <p><strong>За агента:</strong></p>

                        <p>
                            <?= nl2br(htmlspecialchars($agent->getDescription() ?? 'Няма описание.')); ?>
                        </p>

                    </div>

                </div>
            </div>
        </section>
    </div>
</body>

</html>