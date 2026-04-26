<?php
// Ensure session is started at the very top of your main index/router file
// session_start(); 

/**
 * 1. FILTER PERSISTENCE LOGIC
 * Syncs URL parameters with the Session so filters stay "sticky"
 */
$filterKeys = ['category', 'type', 'region', 'city', 'neighborhood', 'price', 'listing_type'];

if (!isset($_SESSION['filters'])) {
    $_SESSION['filters'] = array_fill_keys($filterKeys, 'any');
}

foreach ($filterKeys as $key) {
    if (isset($_GET[$key])) {
        $_SESSION['filters'][$key] = $_GET[$key];
    }
}

// Clear Filters Logic
if (isset($_GET['clear_filters'])) {
    $_SESSION['filters'] = array_fill_keys($filterKeys, 'any');
    header("Location: index.php?action=buy_rent");
    exit();
}

$f = $_SESSION['filters'];

/**
 * 2. HELPER FUNCTIONS
 * These ensure the HTML renders with the correct "Remembered" state
 */
function activeLabel($currentVal, $defaultLabel)
{
    return ($currentVal !== 'any' && !empty($currentVal)) ? htmlspecialchars($currentVal) : $defaultLabel;
}

function activeStyle($currentVal)
{
    return ($currentVal !== 'any' && !empty($currentVal)) ? 'style="border-color: var(--tu_blue_primary);"' : '';
}
?>
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
                    <input class="input_field" placeholder="Address, City, Zip, or Neighborhood" type="text">
                </div>
            </div>
            <div class="nav_wrapper">
                <button class="menu_toggle" id="menuToggle">
                    <span></span><span></span><span></span>
                </button>
                <div class="nav_container">
                    <nav class="nav_links">
                        <a class="nav_link" href="index.php?action=buy_rent">Buy/Rent</a>
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
            <div class="dropdown_wrapper" id="priceDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-name="<?= $f['price'] ?>" <?= activeStyle($f['price']) ?>>
                    <span class="filter_label"><?= activeLabel($f['price'], 'Цена') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Цена</div>
                    <?php

                    use App\Controllers\PriceRangeController;

                    foreach (PriceRangeController::getAllPriceRanges() as $range): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($range->getRangeName()) ?>"><?= htmlspecialchars($range->getRangeValue()) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown_wrapper" id="categoryDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['category'] ?>" <?= activeStyle($f['category']) ?>>
                    <span class="filter_label"><?= activeLabel($f['category'], 'Категории') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Категории</div>
                    <?php

                    use App\Controllers\EstateCategoryController;

                    foreach (EstateCategoryController::getAllEstateCategories() as $category): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($category->getId()) ?>"><?= htmlspecialchars($category->getCategoryName()) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown_wrapper" id="listingTypeDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['listing_type'] ?>" <?= activeStyle($f['listing_type']) ?>>
                    <span class="filter_label"><?= activeLabel($f['listing_type'], 'Тип обява') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Тип обява</div>
                    <?php
                    use App\Controllers\ListingTypeController;
                    foreach (ListingTypeController::getAllListingTypes() as $listingType): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($listingType->getId()) ?>">
                            <?= htmlspecialchars($listingType->getTypeName()) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown_wrapper" id="typeDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-name="<?= $f['type'] ?>" <?= activeStyle($f['type']) ?>>
                    <span class="filter_label"><?= activeLabel($f['type'], 'Вид имот') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Вид имот</div>
                    <?php

                    use App\Controllers\EstateTypeController;

                    foreach (EstateTypeController::getAllEstateTypes() as $type): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($type->getTypeName()) ?>" data-region="<?= htmlspecialchars($type->getCategoryId()) ?>"><?= htmlspecialchars($type->getTypeName()) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown_wrapper" id="regionDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['region'] ?>" <?= activeStyle($f['region']) ?>>
                    <span class="filter_label"><?= activeLabel($f['region'], 'Област') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Област</div>
                    <?php

                    use App\Controllers\RegionController;

                    foreach (RegionController::getAllRegions() as $region): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($region->getId()) ?>" data-name="<?= htmlspecialchars($region->getRegionNameEN()) ?>"><?= htmlspecialchars($region->getRegionNameBG()) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown_wrapper" id="locationDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['city'] ?>" <?= activeStyle($f['city']) ?>>
                    <span class="filter_label"><?= activeLabel($f['city'], 'Населено място') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Населено място</div>
                    <?php

                    use App\Controllers\CityController;

                    foreach (CityController::getAllCities() as $city): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($city->getId()) ?>" data-region="<?= htmlspecialchars($city->getRegionId()) ?>" data-name="<?= htmlspecialchars($city->getCityNameEN()) ?>"><?= htmlspecialchars($city->getCityNameBG()) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown_wrapper" id="neighborhoodDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['neighborhood'] ?>" <?= activeStyle($f['neighborhood']) ?>>
                    <span class="filter_label"><?= activeLabel($f['neighborhood'], 'Квартал') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any" data-region="any">Квартал</div>
                    <?php

                    use App\Controllers\NeighborhoodController;

                    foreach (NeighborhoodController::getAllNeighborhoods() as $neighborhood): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($neighborhood->getId()) ?>" data-region="<?= htmlspecialchars($neighborhood->getCityId()) ?>"><?= htmlspecialchars($neighborhood->getNeighborhoodNameBG()) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <a href="index.php?action=buy_rent&" class="btn_primary" style="border-radius: 100px; text-decoration: none;">Търси</a>
            <a href="index.php?action=buy_rent&clear_filters=1" class="btn_secondary" style="height: 40px; display: flex; align-items: center; text-decoration: none; padding: 0 15px; border-radius: 20px;">Изчисти</a>
        </form>

        <div class="split_container">
            <div id="map-container"></div>

            <?php
            $is_mobile = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));

            $all_estates = App\Controllers\EstateController::getAllEstates();
            $total_items = count($all_estates);

            if ($is_mobile) {
                $items_per_page = $total_items > 0 ? $total_items : 1;
                $current_page = 1;
            } else {
                $items_per_page = 3;
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            }

            $offset = ($current_page - 1) * $items_per_page;
            $total_pages = ceil($total_items / $items_per_page);
            $estates = array_slice($all_estates, $offset, $items_per_page);
            ?>

            <div class="listings_side">
                <div class="container_center">
                    <h2 class="section_title">Available Estates</h2>
                    <div class="properties_grid">
                        <?php foreach ($estates as $estate): ?>
                            <article class="estate_card">
                                <div class="estate_image_wrapper">
                                    <img src="uploads/estate_placeholder.jpg" alt="Modern Apartment in Sofia" class="estate_image">
                                    <div class="estate_status_tag"><?php echo htmlspecialchars($estate->status_name) ?></div>
                                </div>

                                <div class="estate_content">
                                    <div class="estate_header">
                                        <h3 class="estate_price">€<?= number_format($estate->price, 2) ?></h3>
                                        <p class="estate_address"><?= htmlspecialchars($estate->city_name) ?>, <?= htmlspecialchars($estate->neighborhood_name) ?></p>
                                    </div>
                                    <div class="estate_features">
                                        <div class="feature_item">
                                            <image src="images/area_icon.png" alt="Area Icon" style="width:20px; height:20px; margin-right:5px;">
                                            <span><?= htmlspecialchars(number_format($estate->area, 2)) ?> m²</span>
                                        </div>
                                        <div class="feature_item">
                                            <image src="images/room.png" alt="Bedroom Icon" style="width:20px; height:20px; margin-right:5px;"></image>
                                            <span><?= htmlspecialchars($estate->rooms) ?></span>
                                        </div>
                                        <div class="feature_item">
                                            <image src="images/floor.png" alt="Floor Icon" style="width:20px; height:20px; margin-right:5px;"></image>
                                            <span> <?= htmlspecialchars($estate->floor) ?></span>
                                        </div>
                                    </div>
                                    <a href="index.php?action=estate_details&id=<?= $estate->id ?>" class="btn_view" style="text-decoration: none;">View Details</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    // 1. Prepare the base parameters from the session filters
                    $queryParams = $_SESSION['filters'];
                    $current_action = $_GET['action'] ?? 'buy_rent';
                    $queryParams['action'] = $current_action;

                    // 2. Helper function to build the URL including ALL filters
                    if (!function_exists('getPaginationUrl')) {
                        function getPaginationUrl($page, $params)
                        {
                            $params['page'] = $page;
                            // Clean up 'any' values so the URL stays neat
                            foreach ($params as $key => $value) {
                                if ($value === 'any' || empty($value)) unset($params[$key]);
                            }
                            return "index.php?" . http_build_query($params);
                        }
                    }
                    ?>

                    <div class="pagination_container">
                        <?php if ($current_page > 1): ?>
                            <div class="page_numbers">
                                <a href="<?= getPaginationUrl($current_page - 1, $queryParams) ?>" class="page_link">
                                    &laquo;
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="page_numbers">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="<?= getPaginationUrl($i, $queryParams) ?>"
                                    class="page_link <?= ($i == $current_page) ? 'active' : ''; ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>

                        <?php if ($current_page < $total_pages): ?>
                            <div class="page_numbers">
                                <a href="<?= getPaginationUrl($current_page + 1, $queryParams) ?>" class="page_link">»</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>