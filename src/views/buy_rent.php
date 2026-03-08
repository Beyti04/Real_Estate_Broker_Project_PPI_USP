<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TU Brokers</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body>
    <div class="main_wrapper">
        <header>
            <div class=" logo">
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
                    <input class="input_field" placeholder="Address, City, Zip, or Neighborhood"
                        type="text">
                </div>
            </div>
            <div class="nav_wrapper">
                <button class="menu_toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="nav_container">
                    <nav class="nav_links">
                        <a class="nav_link" href="#">Buy/Rent</a>
                        <a class="nav_link" href="#">Sell</a>
                        <a class="nav_link" href="#">Agents</a>
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
        <form class="filter_bar">
            <div class="dropdown_wrapper">
                <button class="filter_pill dropdown_toggle" type="button">
                    <span class="filter_label">Цена</span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Цена</div>

                    <?php

                    use App\Controllers\PriceRangeController;

                    $priceRanges = PriceRangeController::getAllPriceRanges();

                    foreach ($priceRanges as $range) {
                    ?>
                        <div class="dropdown_option" data-value="<?php echo htmlspecialchars($range->getRangeName()) ?>"><?php echo htmlspecialchars($range->getRangeValue()) ?></div>

                    <?php
                    }
                    ?>

                </div>
            </div>

            <div class="dropdown_wrapper" id="categoryDropdown">
                <button class="filter_pill dropdown_toggle" type="button">
                    <span class="filter_label">Категории</span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Категории</div>

                    <?php

                    use App\Controllers\EstateCategoryController;

                    $estateCategories = EstateCategoryController::getAllEstateCategories();

                    foreach ($estateCategories as $category) {
                    ?>
                        <div class="dropdown_option" data-value="<?php echo htmlspecialchars($category->getId()) ?>"><?php echo htmlspecialchars($category->getCategoryName()) ?></div>
                    <?php
                    }
                    ?>

                </div>
            </div>

            <div class="dropdown_wrapper" id="typeDropdown">
                <button class="filter_pill dropdown_toggle" type="button">
                    <span class="filter_label">Вид имот</span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Вид имот</div>

                    <?php

                    use App\Controllers\EstateTypeController;

                    $estateTypes = EstateTypeController::getAllEstateTypes();

                    foreach ($estateTypes as $type) {
                    ?>
                        <div class="dropdown_option" data-value="<?php echo htmlspecialchars($type->getTypeName()) ?>" data-region="<?php echo htmlspecialchars($type->getCategoryId()) ?>"><?php echo htmlspecialchars($type->getTypeName()) ?></div>
                    <?php
                    }
                    ?>

                </div>
            </div>

            <div class="dropdown_wrapper">
                <button class="filter_pill dropdown_toggle" type="button">
                    <span class="filter_label">Вид обява</span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Вид обява</div>

                    <?php

                    use App\Controllers\ListingTypeController;

                    $listingTypes = ListingTypeController::getAllListingTypes();

                    foreach ($listingTypes as $type) {
                    ?>
                        <div class="dropdown_option" data-value="<?php echo htmlspecialchars($type->getTypeName()) ?>"><?php echo htmlspecialchars($type->getTypeName()) ?></div>
                    <?php
                    }
                    ?>

                </div>
            </div>

            <div class="dropdown_wrapper" id="regionDropdown">
                <button class="filter_pill dropdown_toggle" type="button">
                    <span class="filter_label">Област</span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Област</div>

                    <?php

                    use App\Controllers\RegionController;

                    $regions = RegionController::getAllRegions();

                    foreach ($regions as $region) {
                    ?>
                        <div class="dropdown_option" data-value="<?php echo htmlspecialchars($region->getId()) ?>" data-name="<?php echo htmlspecialchars($region->getRegionNameEN()) ?>"><?php echo htmlspecialchars($region->getRegionNameBG()) ?></div>
                    <?php
                    }
                    ?>

                </div>
            </div>

            <div class="dropdown_wrapper" id="locationDropdown">
                <button class="filter_pill dropdown_toggle" type="button">
                    <span class="filter_label">Населено място</span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Населено място</div>

                    <?php

                    use App\Controllers\CityController;

                    $cities = CityController::getAllCities();

                    foreach ($cities as $city) {
                    ?>
                        <div class="dropdown_option" data-value="<?php echo htmlspecialchars($city->getId()) ?>" data-region="<?php echo htmlspecialchars($city->getRegionId()) ?>" data-name="<?php echo htmlspecialchars($city->getCityNameEN()) ?>"><?php echo htmlspecialchars($city->getCityNameBG()) ?></div>
                    <?php
                    }
                    ?>

                </div>
            </div>

            <div class="dropdown_wrapper" id="neighborhoodDropdown">
                <button class="filter_pill dropdown_toggle" type="button">
                    <span class="filter_label">Квартал</span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any" data-region="any">Квартал</div>

                    <?php

                    use App\Controllers\NeighborhoodController;

                    $neighborhoods = NeighborhoodController::getAllNeighborhoods();

                    foreach ($neighborhoods as $neighborhood) { ?>
                        <div class="dropdown_option"
                            data-value="<?= htmlspecialchars($neighborhood->getId()) ?>"
                            data-region="<?= htmlspecialchars($neighborhood->getCityId()) ?>"><?= htmlspecialchars($neighborhood->getNeighborhoodNameBG()) ?></div>
                    <?php }; ?>
                </div>
            </div>
        </form>
        <div class="split_container">
            <div id="map-container"></div>

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

            <div class="listings_side">
                <div class="container_center">
                    <h2 class="section_title">Available Estates</h2>
                    <div class="properties_grid">
                        <?php
                        foreach ($estates as $estate) {
                        ?>
                            <article class="estate_card">
                                <div class="estate_image_wrapper">
                                    <img src="uploads/estate_placeholder.jpg" alt="Modern Apartment in Sofia" class="estate_image">
                                    <div class="estate_status_tag"><?php echo htmlspecialchars($estate->status_name) ?></div>
                                </div>

                                <div class="estate_content">
                                    <div class="estate_header">
                                        <h3 class="estate_price">€<?php echo htmlspecialchars(number_format($estate->price, 2)) ?></h3>
                                        <p class="estate_address"><?php echo htmlspecialchars($estate->city_name) ?>, <?php echo htmlspecialchars($estate->neighborhood_name) ?></p>
                                    </div>

                                    <div class="estate_features">
                                        <div class="feature_item">
                                            <picture>
                                                <img class="theme_light_img" src="images/area_icon.png" alt="TU Brokers Logo">
                                                <img class="theme_dark_img" src="images/area_icon_dark.png" alt="TU Brokers Logo">
                                            </picture>
                                            <span><?php echo htmlspecialchars(number_format($estate->area, 2)) ?> m²</span>
                                        </div>
                                        <div class="feature_item">
                                            <picture>
                                                <img class="theme_light_img" src="images/room.png" alt="TU Brokers Logo">
                                                <img class="theme_dark_img" src="images/room_dark.png" alt="TU Brokers Logo">
                                            </picture>
                                            <span><?php echo htmlspecialchars($estate->rooms) ?></span>
                                        </div>
                                        <div class="feature_item">
                                            <picture>
                                                <img class="theme_light_img" src="images/floor.png" alt="TU Brokers Logo">
                                                <img class="theme_dark_img" src="images/floor_dark.png" alt="TU Brokers Logo">
                                            </picture>
                                            <span><?php echo htmlspecialchars($estate->floor) ?></span>
                                        </div>
                                    </div>

                                    <a href="estate_details.php?id=1" class="btn_view" style="text-decoration: none;">View Details</a>
                                </div>
                            </article>
                        <?php
                        }
                        // Вземаме текущия екшън от URL-а, за да не го губим при смяна на страницата
                        $current_action = isset($_GET['action']) ? $_GET['action'] : 'buy_rent';
                        ?>
                    </div>
                    <div class="pagination_container">
                        <?php if ($current_page > 1): ?>
                            <div class="page_numbers">
                                <a href="index.php?action=<?php echo $current_action; ?>&page=<?php echo $current_page - 1; ?>" class="page_link">
                                    <</a>
                            </div>
                        <?php endif; ?>

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
                </div>
            </div>

        </div>
</body>

</html>