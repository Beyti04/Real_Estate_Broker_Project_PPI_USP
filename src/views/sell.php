<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Property</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/sell.css">
    <script src="script.js"></script>
</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Съществуващ код за превю на снимки ---
        const input = document.getElementById('estate-images-input');
        const previewContainer = document.getElementById('image-preview-container');

        if (input && previewContainer) {
            input.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                const files = Array.from(this.files);
                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.classList.add('preview-item');
                        previewItem.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                        previewContainer.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                });
            });
        }

        // --- НОВ КОД: Логика за Градове и Квартали ---
        const citySelect = document.getElementById('city-select');
        const neighborhoodSelect = document.getElementById('neighborhood-select');

        if (citySelect && neighborhoodSelect) {
            // Запазваме всички оригинални опции за кварталите в масив
            const originalNeighborhoodOptions = Array.from(neighborhoodSelect.querySelectorAll('option'));

            citySelect.addEventListener('change', function() {
                const selectedCityId = this.value;

                // Изчистваме текущите квартали в падащото меню
                neighborhoodSelect.innerHTML = '';

                // Винаги връщаме първата опция "Избор"
                neighborhoodSelect.appendChild(originalNeighborhoodOptions[0]);
                neighborhoodSelect.value = ""; // Ресетваме стойността

                if (selectedCityId) {
                    // Разрешаваме избора на квартал
                    neighborhoodSelect.disabled = false;

                    // Филтрираме и добавяме само тези квартали, които отговарят на избрания град
                    originalNeighborhoodOptions.forEach(option => {
                        if (option.getAttribute('data-city-id') === selectedCityId) {
                            neighborhoodSelect.appendChild(option);
                        }
                    });
                } else {
                    // Ако градът е върнат на "Избор", отново заключваме кварталите
                    neighborhoodSelect.disabled = true;
                }
            });

            // Стартираме евента веднъж при зареждане на страницата, 
            // за да се изчистят кварталите първоначално
            citySelect.dispatchEvent(new Event('change'));
        }
    });
</script>

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
                    <nav class="nav_links">
                        <nav class="nav_links">
                            <a class="nav_link" href="index.php?action=buy_rent">Обяви</a>
                            <a class="nav_link" href="index.php?action=sell">Продай</a>
                            <a class="nav_link" href="index.php?action=agents">Агенти</a>
                            <a class="nav_link" href="index.php?action=my_estates">Моите обяви</a>
                        </nav>
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

        <section class="content_section_sell">
            <div class="create-estate-page">
                <h2 class="section_title_sell">Създай обява</h2>

                <form action="index.php?action=create_estate_process" method="POST" enctype="multipart/form-data" class="create-estate-form">

                    <div class="estate-column">
                        <h3>Детайли за имота</h3>

                        <label>Адрес</label>
                        <input type="text" name="estate_address" class="input_field_sell" required>

                        <label>Тип на обява</label>
                        <select name="listing_type_id" class="input_field_sell" required>
                            <option value="">Избор</option>
                            <?php
                            $listingTypes = \App\Controllers\ListingTypeController::getAllListingTypes();
                            foreach ($listingTypes as $lt) {
                                echo '<option value="' . $lt->getId() . '">' . htmlspecialchars($lt->getTypeName()) . '</option>';
                            }
                            ?>
                        </select>

                        <label>Тип на имота</label>
                        <select name="estate_type_id" class="input_field_sell" required>
                            <option value="">Избор</option>
                            <?php
                            $estateTypes = \App\Controllers\EstateTypeController::getAllEstateTypes();
                            foreach ($estateTypes as $et) {
                                echo '<option value="' . $et->getId() . '">' . htmlspecialchars($et->getTypeName()) . '</option>';
                            }
                            ?>
                        </select>
                        <!--
                        <label>Област</label>
                        <select name="region_id" class="input_field_sell" required>
                            <option value="">Избор</option>
                            
                            <?php
                            /*
                            $regions = \App\Controllers\RegionController::getAllRegions();
                            foreach ($regions as $region) {
                                echo '<option value="'.$region->getId().'">'.htmlspecialchars($region->getRegionNameBG()).'</option>';
                            }
                                */

                            ?>
                            
                        </select>
-->
                        <label>Град</label>
                        <select name="city_id" id="city-select" class="input_field_sell" required>
                            <option value="">Избор</option>
                            <?php
                            $cities = \App\Controllers\CityController::getAllCities();
                            foreach ($cities as $city) {
                                echo '<option value="' . $city->getId() . '">' . htmlspecialchars($city->getCityNameBG()) . '</option>';
                            }
                            ?>
                        </select>

                        <label>Квартал</label>
                        <select name="neighborhood_id" id="neighborhood-select" class="input_field_sell" required>
                            <option value="">Избор</option>
                            <?php
                            $neighborhoods = \App\Controllers\NeighborhoodController::getAllNeighborhoods();
                            foreach ($neighborhoods as $neighborhood) {
                                $cityId = $neighborhood->getCityId();
                                echo '<option value="' . $neighborhood->getId() . '" data-city-id="' . $cityId . '">' . htmlspecialchars($neighborhood->getNeighborhoodNameBG()) . '</option>';
                            }
                            ?>
                        </select>

                        <label>Изложение</label>
                        <select name="exposure_type" class="input_field_sell" required>
                            <option value="">Избор</option>
                            <?php
                            foreach (\App\Models\ExposureType::getOptions() as $option) {
                                echo '<option value="' . $option . '">' . htmlspecialchars($option) . '</option>';
                            }
                            ?>
                        </select>

                        <label>Стаи</label>
                        <input type="number" name="rooms" class="input_field_sell" min="1" required>

                        <label>Етаж</label>
                        <input type="number" name="floor" class="input_field_sell" required>

                        <label>Площ (m²)</label>
                        <input type="number" step="0.01" name="area" class="input_field_sell" required>

                        <label>Цена (€)</label>
                        <input type="number" step="0.01" name="price" class="input_field_sell" required>
                    </div>

                    <div class="estate-column">
                        <h3>Снимки</h3>
                        <label>Качване на снимки</label>
                        <input type="file" name="images[]" class="input_field_sell" accept="image/*" multiple required>

                        <div class="upload-note">
                            Поне една снимка е задължителна. Обявата не може да бъде публикувана без снимки.
                            <h3>Описание на имота</h3>
                        </div>
                        <textarea name="description" class="input_field_sell estate-textarea" required placeholder="Напишете подрбно описание за имота тук..."></textarea>



                        <button type="submit" class="btn_primary upload-estate-btn">Създай обява</button>
                    </div>

                </form>
            </div>
        </section>
    </div>
</body>

</html>