<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Агенти</title>
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
                <div style="text-align:center; margin-bottom: 2rem;">
                    <h2 class="section_title">Our Agents</h2>
                    <p class="section_description">Meet our professional real estate brokers.</p>
                </div>

                <div class="properties_grid">
                    <?php foreach ($agents as $agent): ?>
                        <div class="property_card" style="text-align:center;">
                            <a href="index.php?action=agent_profile&id=<?= $agent->getId(); ?>" style="text-decoration:none; color:inherit;">
                                <img
                                    src="<?= !empty($agent->getImage()) ? htmlspecialchars($agent->getImage()) : 'uploads/default-agent.jpg'; ?>"
                                    alt="<?= htmlspecialchars($agent->getUsername()); ?>"
                                    style="width:100%; height:320px; object-fit:cover; border-radius:12px; margin-bottom:1rem;"
                                >
                                <h3><?= htmlspecialchars($agent->getUsername()); ?></h3>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>
</body>