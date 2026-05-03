<?php
// Ensure session is started at the very top of your main index/router file
// session_start(); 

/**
 * 1. FILTER PERSISTENCE LOGIC
 * Syncs URL parameters with the Session so filters stay "sticky"
 */
$filterKeys = ['category', 'type', 'region', 'city', 'neighborhood', 'price', 'listing_type'];

$defaults = [
    'category'     => ['key' => 'any', 'value' => 'Категория'],
    'type'         => ['key' => 'any', 'value' => 'Вид имот'],
    'region'       => ['key' => 'any', 'value' => 'Област'],
    'city'         => ['key' => 'any', 'value' => 'Град'],
    'neighborhood' => ['key' => 'any', 'value' => 'Квартал'],
    'price'        => ['key' => 'any', 'value' => 'Цена'],
    'listing_type' => ['key' => 'any', 'value' => 'Вид обява'],
];

if (!isset($_SESSION['filters'])) {
    $_SESSION['filters'] = $defaults;
}

foreach ($filterKeys as $key) {
    if (isset($_GET[$key])) {
        $val = $_GET[$key];
        $_SESSION['filters'][$key]['key'] = $val;

        if ($val === 'any') {
            $_SESSION['filters'][$key]['value'] = $defaults[$key]['value'];
        } else {
            // Превръщаме техническата стойност в красив текст според типа на филтъра
            switch ($key) {
                case 'price':
    // Взимаме избрания тип обява от GET (ако сега се праща) или от сесията
    $currentLT = $_GET['listing_type'] ?? ($_SESSION['filters']['listing_type']['key'] ?? 'any');
    
    foreach (App\Controllers\PriceRangeController::getAllPriceRanges() as $r) {
        // Проверяваме дали името съвпада И дали принадлежи на избрания тип обява
        // Приемаме, че имате метод getListingTypeId() в обекта на цената
        if ($r->getRangeName() === $val) {
            if ($currentLT === 'any' || $r->getListingType() == $currentLT) {
                $_SESSION['filters'][$key]['value'] = $r->getRangeValue();
                break; 
            }
        }
    }
    break;

                case 'category':
                    foreach (App\Controllers\EstateCategoryController::getAllEstateCategories() as $c) {
                        if ($c->getId() == $val) { $_SESSION['filters'][$key]['value'] = $c->getCategoryName(); break; }
                    }
                    break;

                case 'listing_type':
                    foreach (App\Controllers\ListingTypeController::getAllListingTypes() as $lt) {
                        if ($lt->getId() == $val) { $_SESSION['filters'][$key]['value'] = $lt->getTypeName(); break; }
                    }
                    break;

                case 'region':
                    foreach (App\Controllers\RegionController::getAllRegions() as $reg) {
                        if ($reg->getId() == $val) { $_SESSION['filters'][$key]['value'] = $reg->getRegionNameBG(); break; }
                    }
                    break;

                case 'city':
                    foreach (App\Controllers\CityController::getAllCities() as $city) {
                        if ($city->getId() == $val) { $_SESSION['filters'][$key]['value'] = $city->getCityNameBG(); break; }
                    }
                    break;

                case 'neighborhood':
                    foreach (App\Controllers\NeighborhoodController::getAllNeighborhoods() as $n) {
                        if ($n->getId() == $val) { $_SESSION['filters'][$key]['value'] = $n->getNeighborhoodNameBG(); break; }
                    }
                    break;
                
                case 'type':
                    $_SESSION['filters'][$key]['value'] = $val; 
                    break;

                default:
                    $_SESSION['filters'][$key]['value'] = $val;
                    break;
            }
        }
    }
}

// Clear Filters Logic
if (isset($_GET['clear_filters'])) {
    $_SESSION['filters'] = $defaults;
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
        <form class="filter_bar">
            <div class="dropdown_wrapper" id="priceDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-name="<?= $f['price']['key'] ?>" data-selected-value="<?= $f['price']['value'] ?>" <?= activeStyle($f['price']['key']) ?>>
                    <span class="filter_label" id="label_data"><?= activeLabel($f['price']['value'], 'Цена') ?></span>
                    <span class="arrow_container">
                        <div class="css_arrow"></div>
                    </span>
                </button>
                <div class="dropdown_content">
                    <div class="dropdown_option" data-value="any">Цена</div>
                    <?php

                    use App\Controllers\PriceRangeController;

                    foreach (PriceRangeController::getAllPriceRanges() as $range): ?>
                        <div class="dropdown_option" data-value="<?= htmlspecialchars($range->getRangeName()) ?>" data-value-data="<?= htmlspecialchars($range->getRangeValue()) ?>" data-listing-type="<?= htmlspecialchars($range->getListingType()) ?>"><?= htmlspecialchars($range->getRangeValue()) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown_wrapper" id="categoryDropdown">
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['category']['key'] ?>" data-selected-value="<?= $f['category']['value'] ?>" <?= activeStyle($f['category']['key']) ?>>
                    <span class="filter_label"><?= activeLabel($f['category']['value'], 'Категории') ?></span>
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
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['listing_type']['key'] ?>" data-selected-value="<?= $f['listing_type']['value'] ?>" <?= activeStyle($f['listing_type']['key']) ?>>
                    <span class="filter_label"><?= activeLabel($f['listing_type']['value'], 'Тип обява') ?></span>
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
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['type']['key'] ?>" data-selected-value="<?= $f['type']['value'] ?>" <?= activeStyle($f['type']['key']) ?>>
                    <span class="filter_label"><?= activeLabel($f['type']['value'], 'Вид имот') ?></span>
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
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['region']['key'] ?>" data-selected-value="<?= $f['region']['value'] ?>" <?= activeStyle($f['region']['key']) ?>>
                    <span class="filter_label"><?= activeLabel($f['region']['value'], 'Област') ?></span>
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
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['city']['key'] ?>" data-selected-value="<?= $f['city']['value'] ?>" <?= activeStyle($f['city']['key']) ?>>
                    <span class="filter_label"><?= activeLabel($f['city']['value'], 'Населено място') ?></span>
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
                <button class="filter_pill dropdown_toggle" type="button" data-selected-id="<?= $f['neighborhood']['key'] ?>" data-selected-value="<?= $f['neighborhood']['value'] ?>" <?= activeStyle($f['neighborhood']['key']) ?>>
                    <span class="filter_label"><?= activeLabel($f['neighborhood']['value'], 'Квартал') ?></span>
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

            <button type="button" id="searchBtn" class="btn_primary" style="border-radius: 100px; outline: none; border: none; cursor: pointer; padding: 0 25px; height: 40px; font-size: 1rem;">Търси</button>
            <a href="index.php?action=buy_rent&clear_filters=1" class="btn_secondary" style="height: 40px; display: flex; align-items: center; text-decoration: none; padding: 0 15px; border-radius: 20px;">Изчисти</a>
        </form>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const searchBtn = document.getElementById('searchBtn');

                if (searchBtn) {
                    searchBtn.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Взимаме стойностите от data-атрибутите на бутоните за всяко меню
                        const filters = {
                            price:
                             {  
                                key: document.querySelector('#priceDropdown .dropdown_toggle').getAttribute('data-selected-name'),
                                value: document.querySelector('#priceDropdown .dropdown_toggle').getAttribute('data-selected-value')
                             },
                            category:
                            {
                                key: document.querySelector('#categoryDropdown .dropdown_toggle').getAttribute('data-selected-id'),
                                value: document.querySelector('#categoryDropdown .dropdown_toggle').getAttribute('data-selected-value')
                            } ,
                            listing_type: 
                            {
                                    key: document.querySelector('#listingTypeDropdown .dropdown_toggle').getAttribute('data-selected-id'),
                                    value: document.querySelector('#listingTypeDropdown .dropdown_toggle').getAttribute('data-selected-value')
                            },
                            type:
                            {
                                key: document.querySelector('#typeDropdown .dropdown_toggle').getAttribute('data-selected-id'),
                                value: document.querySelector('#typeDropdown .dropdown_toggle').getAttribute('data-selected-value')
                            },
                            region:
                            {
                                key: document.querySelector('#regionDropdown .dropdown_toggle').getAttribute('data-selected-id'),
                                value: document.querySelector('#regionDropdown .dropdown_toggle').getAttribute('data-selected-value')
                            },
                            city: {
                                key: document.querySelector('#locationDropdown .dropdown_toggle').getAttribute('data-selected-id'),
                                value: document.querySelector('#locationDropdown .dropdown_toggle').getAttribute('data-selected-value')
                            },
                            neighborhood: {
                                key: document.querySelector('#neighborhoodDropdown .dropdown_toggle').getAttribute('data-selected-id'),
                                value: document.querySelector('#neighborhoodDropdown .dropdown_toggle').getAttribute('data-selected-value')
                            }
                        };

                        // Базовият URL
                        let url = 'index.php?action=buy_rent';

                        for(const [key, value] of Object.entries(filters)) {
                            if(value.key && value.key !== 'any') {
                                url += `&${key}=${encodeURIComponent(value.key)}`;
                            }
                        }
                        window.location.href = url;
                    });
                }
            });
        </script>

        <div class="split_container">
            <div id="map-container"></div>

            <?php
            $is_mobile = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));

            // Взимаме масива с филтри от сесията
            $current_filters = $_SESSION['filters'] ?? [];

            $filter_data = [];
            foreach ($current_filters as $key => $data) {
                    $filter_data[$key] = $data['key'] ?? 'any';
            }

            // Извикваме новата функция, която връща само филтрираните резултати
            $all_estates = App\Controllers\EstateController::getFilteredEstates($filter_data);
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
                    <h2 class="section_title">Налични имоти</h2>
                    <div class="properties_grid">
                        <?php
                        if (empty($estates)) {
                            echo '<p style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary);">No properties found matching your criteria.</p>';
                        }
                        
                         foreach ($estates as $estate): ?>
                            <article class="estate_card">
    <!-- Добавяме основен линк, който обгръща цялото съдържание -->
    <a href="index.php?action=estate_details&id=<?= $estate->id ?>" class="estate_card_link">
        
        <div class="estate_image_wrapper">
            <img src="uploads/estate_placeholder.jpg" alt="Modern Apartment" class="estate_image">
            <div class="estate_status_tag"><?php echo htmlspecialchars($estate->status_name) ?></div>
        </div>

        <div class="estate_content">
            <div class="estate_header">
                <h3 class="estate_price">€<?= number_format($estate->price, 2) ?></h3>
                <p class="estate_address"><?= htmlspecialchars($estate->city_name) ?>, <?= htmlspecialchars($estate->neighborhood_name) ?></p>
            </div>
            
            <div class="estate_features">
                <div class="feature_item">
                    <img class="theme_light_img" src="images/area_icon.png" alt="Area Icon" style="width:20px; height:20px; margin-right:5px;">
                    <img class="theme_dark_img" src="images/area_icon_dark.png" alt="Area Icon" style="width:20px; height:20px; margin-right:5px;">
                    <span><?= htmlspecialchars(number_format($estate->area, 2)) ?> m²</span>
                </div>
                <div class="feature_item">
                    <img class="theme_light_img" src="images/room.png" alt="Bedroom Icon" style="width:20px; height:20px; margin-right:5px;">
                    <img class="theme_dark_img" src="images/room_dark.png" alt="Bedroom Icon" style="width:20px; height:20px; margin-right:5px;">
                    <span><?= htmlspecialchars($estate->rooms) ?></span>
                </div>
                <div class="feature_item">
                    <img class="theme_light_img" src="images/floor.png" alt="Floor Icon" style="width:20px; height:20px; margin-right:5px;">
                    <img class="theme_dark_img" src="images/floor_dark.png" alt="Floor Icon" style="width:20px; height:20px; margin-right:5px;">
                    <span> <?= htmlspecialchars($estate->floor) ?></span>
                </div>
            </div>

            <!-- Бутонът остава за визуален ориентир, но вече е част от общия линк -->
            <div class="btn_view">Преглед</div>
        </div>
    </a>
</article>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    // 1. Prepare the base parameters from the session filters
                    $queryParams = $filter_data; // This should be the same data structure you used to generate the filters, but flattened to key => value pairs
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