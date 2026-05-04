<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($agent->getUsername()); ?></title>
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
            <div class="container_center">
                <div class="property_card" style="display:flex; gap:2rem; align-items:flex-start; padding:2rem;">
                    <div style="flex:0 0 320px;">
                        <img
                            src="<?= !empty($agent->getImage()) ? htmlspecialchars($agent->getImage()) : 'uploads/default-agent.jpg'; ?>"
                            alt="<?= htmlspecialchars($agent->getUsername()); ?>"
                            style="width:100%; height:400px; object-fit:cover; border-radius:12px;">
                    </div>

                    <div style="flex:1;">
                        <h2 class="section_title"><?= htmlspecialchars($agent->getUsername()); ?></h2>
                        <p style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem;"> 
                            <picture>
                                <img class="footer_icon theme_light_img" src="images/email.png" alt="TU Brokers Logo">
                                <img class="footer_icon theme_dark_img" src="images/email_dark.png" alt="TU Brokers Logo">
                            </picture>
                            <span><?= htmlspecialchars($agent->getEmail()); ?></span>
                        </p>
                        <p style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem;">
                            <picture>
                                <img class="footer_icon theme_light_img" src="images/phone.png" alt="TU Brokers Logo">
                                <img class="footer_icon theme_dark_img" src="images/phone_dark.png" alt="TU Brokers Logo">
                            </picture>
                            <span><?= htmlspecialchars($agent->getPhone() ?? 'Not provided'); ?></span>
                        </p>
                        <p><strong>About the agent:</strong></p>
                        <p><?= nl2br(htmlspecialchars($agent->getDescription() ?? 'No description available.')); ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>