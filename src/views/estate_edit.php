<?php
// Примерно извличане на имота (адаптирай според твоя контролер)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$estateToEdit = \App\Controllers\EstateController::getEstateById($id);

if (!$estateToEdit) {
    // Ако обявата не съществува, връщаме потребителя към списъка
    header('Location: index.php?action=my_estates');
    exit;
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редакция на обява #<?= $estateToEdit->getId() ?> - TU Estates</title>
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
                <button class="menu_toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="nav_container">

                    <div class="sing_in_btns">
                        <button id="theme-toggle" class="btn_secondary" style="padding: 0; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-light); cursor: pointer; background: transparent;">
                            🌙
                        </button>
                        <a href="index.php?action=my_estates" class="btn_primary">Моите обяви</a>
                        <a href="index.php?action=logout" class="btn_secondary">Изход</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="content_section" style="padding: 1.5rem 0; flex: 1;">
            <div class="container_center">
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 class="section_title">Редакция на обява #<?= $estateToEdit->getId() ?></h2>
                        <p class="section_description">Актуализирайте информацията за избрания имот.</p>
                    </div>
                </div>

                <form action="index.php?action=estate_update" method="POST" enctype="multipart/form-data" class="edit_estate_form">
                    <input type="hidden" name="id" value="<?= $estateToEdit->getId() ?>">

                    <div class="estate_column">
                        <h3>Локация</h3>
                        
                        <div class="input_group">
                            <label class="auth_label">Регион</label>
                            <select class="input_field auth_input" name="region_id" id="regionSelect" required>
                                <option value="">-- Избери Регион --</option>
                                <?php 
                                $regions = \App\Controllers\RegionController::getAllRegions();
                                foreach($regions as $region) {
                                    $selected = ($estateToEdit->getRegionId() == $region->getId()) ? 'selected' : '';
                                    echo '<option value="'.$region->getId().'" '.$selected.'>'.htmlspecialchars($region->getRegionNameBG()).'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input_group">
                            <label class="auth_label">Град</label>
                            <select class="input_field auth_input" name="city_id" id="citySelect" required>
                                <option value="">-- Първо избери регион --</option>
                                <?php 
                                $cities = \App\Controllers\CityController::getAllCities();
                                foreach($cities as $city) {
                                    $selected = ($estateToEdit->getCityId() == $city->getId()) ? 'selected' : '';
                                    // ДОБАВЕНО: data-region атрибут за JS филтрирането
                                    echo '<option value="'.$city->getId().'" data-region="'.$city->getRegionId().'" '.$selected.'>'.htmlspecialchars($city->getCityNameBG()).'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input_group">
                            <label class="auth_label">Квартал</label>
                            <select class="input_field auth_input" name="neighborhood_id" id="neighborhoodSelect" required>
                                <option value="">-- Първо избери град --</option>
                                <?php 
                                $neighborhoods = \App\Controllers\NeighborhoodController::getAllNeighborhoods();
                                foreach($neighborhoods as $nh) {
                                    $selected = ($estateToEdit->getNeighborhoodId() == $nh->getId()) ? 'selected' : '';
                                    echo '<option value="'.$nh->getId().'" data-city="'.$nh->getCityId().'" '.$selected.'>'.htmlspecialchars($nh->getNeighborhoodNameBG()).'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input_group">
                            <label class="auth_label">Точен адрес</label>
                            <input type="text" class="input_field auth_input" name="estate_address" required 
                                   value="<?= htmlspecialchars($estateToEdit->getEstateAddress()) ?>">
                        </div>
                    </div>

                    <div class="estate_column">
                        <h3>Характеристики</h3>

                        <div class="input_group">
                            <label class="auth_label">Вид имот</label>
                            <select class="input_field auth_input" name="estate_type_id" required>
                                <?php 
                                $estateTypes = \App\Controllers\EstateTypeController::getAllEstateTypes();
                                foreach($estateTypes as $et) {
                                    $selected = ($estateToEdit->getEstateTypeId() == $et->getId()) ? 'selected' : '';
                                    echo '<option value="'.$et->getId().'" '.$selected.'>'.htmlspecialchars($et->getTypeName()).'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input_group">
                            <label class="auth_label">Изложение</label>
                            <select class="input_field auth_input" name="exposure_type" required>
                                <?php
                                $exposureOptions = \App\Models\ExposureType::getOptions();
                                foreach($exposureOptions as $option) {
                                    $selected = ($estateToEdit->getExposureType()->value == $option) ? 'selected' : '';
                                    echo '<option value="'.$option.'" '.$selected.'>'.htmlspecialchars($option).'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="input_group">
                                <label class="auth_label">Стаи</label>
                                <input type="number" class="input_field auth_input" name="rooms" required min="1" 
                                       value="<?= $estateToEdit->getRooms() ?>">
                            </div>
                            <div class="input_group">
                                <label class="auth_label">Етаж</label>
                                <input type="number" class="input_field auth_input" name="floor" required 
                                       value="<?= $estateToEdit->getFloor() ?>">
                            </div>
                        </div>

                        <div class="input_group">
                            <label class="auth_label">Площ (m²)</label>
                            <input type="number" step="0.01" class="input_field auth_input" name="area" required 
                                   value="<?= $estateToEdit->getArea() ?>"> 
                        </div>
                    </div>

                    <div class="estate_column">
                        <h3>Детайли и Статус</h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="input_group">
                                <label class="auth_label">Тип обява</label>
                                <select class="input_field auth_input" name="listing_type_id" required>
                                    <?php 
                                    $listingTypes = \App\Controllers\ListingTypeController::getAllListingTypes();
                                    foreach($listingTypes as $lt) {
                                        $selected = ($estateToEdit->getListingTypeId() == $lt->getId()) ? 'selected' : '';
                                        echo '<option value="'.$lt->getId().'" '.$selected.'>'.htmlspecialchars($lt->getTypeName()).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input_group">
                                <label class="auth_label">Статус</label>
                                <select class="input_field auth_input" name="status_id" required>
                                    <option value="1" <?= ($estateToEdit->getStatusId() == 1) ? 'selected' : '' ?>>Активна</option>
                                    <option value="2" <?= ($estateToEdit->getStatusId() == 2) ? 'selected' : '' ?>>Капарирана</option>
                                    <option value="3" <?= ($estateToEdit->getStatusId() == 3) ? 'selected' : '' ?>>Архивирана</option>
                                    <option value="4" <?= ($estateToEdit->getStatusId() == 4) ? 'selected' : '' ?>>Изтекла</option>
                                </select>
                            </div>
                        </div>

                        <div class="input_group">
                            <label class="auth_label">Цена (€)</label>
                            <input type="number" step="0.01" class="input_field auth_input" name="price" required 
                                   value="<?= $estateToEdit->getPrice() ?>">
                        </div>

                        <div class="input_group" style="flex: 1;">
                            <label class="auth_label">Описание</label>
                            <textarea class="input_field auth_input" name="description" required 
                                      style="resize: vertical; height: 100%; min-height: 120px; padding: 0.75rem;"><?= htmlspecialchars($estateToEdit->getDescription()) ?></textarea>
                        </div>
                    </div>

                    <div style="grid-column: 1 / -1; display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1rem; border-top: 1px solid var(--border-light); padding-top: 1.5rem;">
                        <a href="index.php?action=estate_details&id=<?= $estateToEdit->getId() ?>" class="btn_secondary" style="width: 150px; text-decoration: none;">Отказ</a>
                        <button type="submit" class="btn_primary" style="width: 200px;">Запази промените</button>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const regionSelect = document.getElementById('regionSelect');
            const citySelect = document.getElementById('citySelect');
            const neighborhoodSelect = document.getElementById('neighborhoodSelect');
            
            // Взимаме всички опции, които имат data- атрибути
            const allCityOptions = Array.from(citySelect.querySelectorAll('option[data-region]'));
            const allNeighborhoodOptions = Array.from(neighborhoodSelect.querySelectorAll('option[data-city]'));
            
            let isInitialLoad = true;

            // 1. Филтриране на Градовете според Региона
            function filterCities() {
                const selectedRegionId = regionSelect.value;
                allCityOptions.forEach(opt => opt.style.display = 'none');

                if (!isInitialLoad) {
                    citySelect.value = ""; // Нулираме града
                }

                if (selectedRegionId) {
                    const validCities = allCityOptions.filter(opt => opt.getAttribute('data-region') === selectedRegionId);
                    validCities.forEach(opt => opt.style.display = 'block');

                    if (validCities.length > 0) {
                        citySelect.options[0].innerText = "-- Избери Град --";
                    } else {
                        citySelect.options[0].innerText = "-- Няма градове --";
                    }
                } else {
                    citySelect.options[0].innerText = "-- Първо избери регион --";
                }

                // Когато се смени градът (или се нулира), винаги опресняваме и кварталите
                filterNeighborhoods();
            }

            // 2. Филтриране на Кварталите според Града
            function filterNeighborhoods() {
                const selectedCityId = citySelect.value;
                allNeighborhoodOptions.forEach(opt => opt.style.display = 'none');
                
                if (!isInitialLoad) {
                    neighborhoodSelect.value = ""; // Нулираме квартала
                }

                if (selectedCityId) {
                    const validOptions = allNeighborhoodOptions.filter(opt => opt.getAttribute('data-city') === selectedCityId);
                    validOptions.forEach(opt => opt.style.display = 'block');
                    
                    if (validOptions.length > 0) {
                        neighborhoodSelect.options[0].innerText = "-- Избери Квартал --";
                    } else {
                        neighborhoodSelect.options[0].innerText = "-- Няма квартали --";
                    }
                } else {
                    neighborhoodSelect.options[0].innerText = "-- Първо избери град --";
                }
            }

            // 3. Закачане на събития
            regionSelect.addEventListener('change', () => {
                isInitialLoad = false;
                filterCities();
            });

            citySelect.addEventListener('change', () => {
                isInitialLoad = false;
                filterNeighborhoods();
            });

            // 4. Стартиране при зареждане (за да покаже само валидните опции за вече избрания имот)
            filterCities();
            isInitialLoad = false; // След първоначалното зареждане, изключваме флага
        });
    </script>
</body>
</html>