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

<body style="overflow: hidden;">
    <div class=" main_wrapper" ">
        <header>
            <div class=" logo">
        <a class="logo_group" href="index.php?action=homepage">
            <picture>
                <source srcset="images/broker_logo_dark.png" media="(prefers-color-scheme: dark)">
                <img class="icon_box" src="images/broker_logo_light.png" alt="TU Brokers Logo">
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
                <button class="btn_primary">Sign Up</button>
                <button class="btn_secondary">Log In</button>
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
                        data-region="<?= htmlspecialchars($neighborhood->getLocationId()) ?>"><?= htmlspecialchars($neighborhood->getNeighborhoodName()) ?></div>
                <?php }; ?>
            </div>
        </div>
    </form>
    <div class="split_container">
        <div id="map-container"></div>

        <div class="listings_side">
            <div class="container_center">
                <h2 class="section_title">Available Estates</h2>
                <div class="properties_grid">
                    <?php /* foreach ($estates as $estate) { ... } */ ?>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

</html>