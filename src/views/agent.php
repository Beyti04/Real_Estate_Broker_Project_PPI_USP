<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Агенти</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="agent.css">
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
                    <nav class="nav_links">
                        <a class="nav_link" href="index.php?action=buy_rent">Buy/Rent</a>
                        <a class="nav_link" href="#">Sell</a>
                        <a class="nav_link" href="index.php?action=agents">Agents</a>
                    </nav>

                    <div class="sing_in_btns">
                        <button id="theme-toggle" class="btn_secondary" style="padding: 0; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-light); cursor: pointer; background: transparent;">
                            🌙
                        </button>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo '<a href="index.php?action=logout" class="btn_secondary">Log Out</a>';
                        } else {
                            echo '<a href="index.php?action=register" class="btn_primary">Sign Up</a>';
                            echo '<a href="index.php?action=login" class="btn_secondary">Log In</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </header>

        <section class="content_section">
            <div class="container_center">
                <div style="text-align:center; margin-bottom: 2rem;margin-top: -80px;">
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
                 <?php
            $is_mobile = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));

// 2. Вземи всички имоти първо
$all_estates = App\Controllers\EstateController::getAllEstates();
$total_items = count($all_estates);

if ($is_mobile) {
    // На мобилен показваме всичко наведнъж
    $items_per_page = $total_items > 0 ? $total_items : 1; 
    $current_page = 1;
} else {
    // На десктоп използваме странициране
    $items_per_page = 3; 
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
}

$offset = ($current_page - 1) * $items_per_page;
$total_pages = ceil($total_items / $items_per_page);

// 3. Отрежи имотите спрямо страницата
$estates = array_slice($all_estates, $offset, $items_per_page);
            ?>

                <div class="page_numbers">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="index.php?action=<?php echo $current_action; ?>&page=<?php echo $i; ?>"
                                    class="page_link <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                        </div>

                        <?php if ($current_page < $total_pages): ?>
                            <div class="page_numbers">
                                <a href="index.php?action=<?php echo $current_action; ?>&page=<?php echo $current_page + 1; ?>" class="page_link">></a>
                            </div>
                        <?php endif; ?>
            </div>
        </section>
    </div>
</body>