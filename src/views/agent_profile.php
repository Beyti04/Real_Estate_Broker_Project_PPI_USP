<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($agent->getUsername()); ?></title>
    <link rel="stylesheet" href="style.css">
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
                    <nav class="nav_links">
                        <a class="nav_link" href="index.php?action=buy_rent">Buy/Rent</a>
                        <a class="nav_link" href="#">Sell</a>
                        <a class="nav_link" href="index.php?action=agents">Agents</a>
                    </nav>
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
                            style="width:100%; height:400px; object-fit:cover; border-radius:12px;"
                        >
                    </div>

                    <div style="flex:1;">
                        <h2 class="section_title"><?= htmlspecialchars($agent->getUsername()); ?></h2>
                        <p><strong>Email:</strong> <?= htmlspecialchars($agent->getEmail()); ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($agent->getPhone() ?? 'Not provided'); ?></p>
                        <p><strong>About the agent:</strong></p>
                        <p><?= nl2br(htmlspecialchars($agent->getDescription() ?? 'No description available.')); ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>