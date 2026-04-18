<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детайли за имота | TU Estates</title>
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
                <div class="nav_container" style="display: flex;">
                    <div class="sing_in_btns">
                        <button id="theme-toggle" class="btn_secondary" style="padding: 0; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-light); cursor: pointer; background: transparent;">
                            🌙
                        </button>
                        <a href="index.php?action=buy_rent" class="btn_primary">Обратно към обявите</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="container_center details_page_wrapper">
            
            <div class="details_header">
                <div class="title_box">
                    <h1 class="estate_title"><?php echo htmlspecialchars($estateDetails->getEstateAddress()); ?></h1>
                    <p class="estate_subtitle">Обява #<?php echo htmlspecialchars($estateDetails->getId()); ?></p>
                </div>
                <div class="price_box">
                    <h2 class="details_price">€<?php echo htmlspecialchars(number_format($estateDetails->getPrice(), 2)); ?></h2>
                </div>
            </div>

            <div class="details_gallery">
                <div class="gallery_main">
                    <img src="uploads/estate_placeholder.jpg" alt="Main Photo" class="gallery_img">
                    <div class="estate_status_tag">Обява</div> </div>
                
                <div class="gallery_thumbnails">
                    <div class="thumb_wrapper"><img src="uploads/estate_placeholder.jpg" alt="Thumb 1" class="gallery_img"></div>
                    <div class="thumb_wrapper"><img src="uploads/estate_placeholder.jpg" alt="Thumb 2" class="gallery_img"></div>
                    <div class="thumb_wrapper"><img src="uploads/estate_placeholder.jpg" alt="Thumb 3" class="gallery_img"></div>
                    <div class="thumb_wrapper more_photos">
                        <img src="uploads/estate_placeholder.jpg" alt="Thumb 4" class="gallery_img">
                        <div class="more_overlay">+ Още снимки</div>
                    </div>
                </div>
            </div>

            <div class="details_content_split">
                
                <div class="details_left">
                    <div class="details_card">
                        <h3 class="card_heading">Описание на имота</h3>
                        <div class="description_text">
                            <p><?php echo nl2br(htmlspecialchars($estateDetails->getDescription())); ?></p>
                        </div>
                    </div>
                </div>

                <div class="details_right">
                    <div class="details_card features_card">
                        <h3 class="card_heading">Характеристики</h3>
                        <ul class="features_list">
                            <li>
                                <span class="feature_label">Площ:</span>
                                <span class="feature_val"><?php echo htmlspecialchars($estateDetails->getArea()); ?> m²</span>
                            </li>
                            <li>
                                <span class="feature_label">Брой стаи:</span>
                                <span class="feature_val"><?php echo htmlspecialchars($estateDetails->getRooms()); ?></span>
                            </li>
                            <li>
                                <span class="feature_label">Етаж:</span>
                                <span class="feature_val"><?php echo htmlspecialchars($estateDetails->getFloor()); ?></span>
                            </li>
                            <li>
                                <span class="feature_label">Изложение:</span>
                                <span class="feature_val">
                                    <?php 
                                        $exposure = $estateDetails->getExposureType();
                                        echo htmlspecialchars(is_object($exposure) ? $exposure->value : $exposure); 
                                    ?>
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="details_card action_card">
                        <h3 class="card_heading">Заинтересовани сте?</h3>
                        <p style="color: var(--par-light); font-size: 0.9rem; margin-bottom: 1.5rem;">Свържете се с отговорния брокер за тази обява.</p>
                        <button class="btn_primary" style="width: 100%; margin-bottom: 0.5rem;">Свържи се с брокер</button>
                        <button class="btn_secondary" style="width: 100%;">Запази в любими</button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>