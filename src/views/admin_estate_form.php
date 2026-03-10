<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $estateToEdit ? 'Редакция' : 'Нова Обява' ?> - Админ Панел</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: var(--search-light); padding: 2rem 0;">

    <div class="auth_card" style="width: 100%; max-width: 800px; margin: 0 auto;">
        <div class="auth_header" style="margin-bottom: 1.5rem;">
            <h2 class="section_title" style="text-align: center;">
                <?= $estateToEdit ? 'Редакция на обява #'.$estateToEdit->getId() : 'Създаване на нова обява' ?>
            </h2>
        </div>

        <form action="index.php?action=admin_save_estate" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            
            <input type="hidden" name="id" value="<?= $estateToEdit ? $estateToEdit->getId() : 0 ?>">

            <div>
                <div class="input_group">
                    <label class="auth_label">Собственик / Брокер</label>
                    <select class="input_field auth_input" name="owner_id" required>
                        <option value="">-- Избери --</option>
                        <?php 
                        $users = \App\Controllers\UserController::getAllUsers();
                        foreach($users as $user) {
                            $selected = ($estateToEdit && $estateToEdit->getOwnerId() == $user->getId()) ? 'selected' : '';
                            echo '<option value="'.$user->getId().'" '.$selected.'>'.htmlspecialchars($user->getUsername()).'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="input_group">
                    <label class="auth_label">Град</label>
                    <select class="input_field auth_input" name="city_id" id="citySelect" required>
                        <option value="">-- Избери Град --</option>
                        <?php 
                        $cities = \App\Controllers\CityController::getAllCities();
                        foreach($cities as $city) {
                            $selected = ($estateToEdit && $estateToEdit->getCityId() == $city->getId()) ? 'selected' : '';
                            echo '<option value="'.$city->getId().'" '.$selected.'>'.htmlspecialchars($city->getCityNameBG()).'</option>';
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
                            $selected = ($estateToEdit && $estateToEdit->getNeighborhoodId() == $nh->getId()) ? 'selected' : '';
                            echo '<option value="'.$nh->getId().'" data-city="'.$nh->getCityId().'" '.$selected.'>'.htmlspecialchars($nh->getNeighborhoodNameBG()).'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="input_group">
                    <label class="auth_label">Точен адрес</label>
                    <input type="text" class="input_field auth_input" name="estate_address" required 
                           value="<?= $estateToEdit ? htmlspecialchars($estateToEdit->getEstateAddress()) : '' ?>">
                </div>

                <div class="input_group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label class="auth_label">Тип обява</label>
                        <select class="input_field auth_input" name="listing_type_id" required>
                            <?php 
                            $listingTypes = \App\Controllers\ListingTypeController::getAllListingTypes();
                            foreach($listingTypes as $lt) {
                                $selected = ($estateToEdit && $estateToEdit->getListingTypeId() == $lt->getId()) ? 'selected' : '';
                                echo '<option value="'.$lt->getId().'" '.$selected.'>'.htmlspecialchars($lt->getTypeName()).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="auth_label">Статус</label>
                        <select class="input_field auth_input" name="status_id" required>
                            <option value="1" <?= ($estateToEdit && $estateToEdit->getStatusId() == 1) ? 'selected' : '' ?>>Активна</option>
                            <option value="2" <?= ($estateToEdit && $estateToEdit->getStatusId() == 2) ? 'selected' : '' ?>>Архивирана</option>
                            <option value="3" <?= ($estateToEdit && $estateToEdit->getStatusId() == 3) ? 'selected' : '' ?>>Изтекла</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <div class="input_group">
                    <label class="auth_label">Вид имот</label>
                    <select class="input_field auth_input" name="estate_type_id" required>
                        <option value="">-- Избери --</option>
                        <?php 
                        $estateTypes = \App\Controllers\EstateTypeController::getAllEstateTypes();
                        foreach($estateTypes as $et) {
                            $selected = ($estateToEdit && $estateToEdit->getEstateTypeId() == $et->getId()) ? 'selected' : '';
                            echo '<option value="'.$et->getId().'" '.$selected.'>'.htmlspecialchars($et->getTypeName()).'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="input_group" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <div>
                        <label class="auth_label">Изложение</label>
                        <?php
                        $exposureOptions = \App\Models\ExposureType::getOptions();
                        echo '<select class="input_field auth_input" name="exposure_type" required>';
                        echo '<option value="">-- Избери --</option>';
                        foreach($exposureOptions as $option) {
                            $selected = ($estateToEdit && $estateToEdit->getExposureType()->value == $option) ? 'selected' : '';
                            echo '<option value="'.$option.'" '.$selected.'>'.htmlspecialchars($option).'</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <div>
                        <label class="auth_label">Стаи</label>
                        <input type="number" class="input_field auth_input" name="rooms" required min="1" 
                               value="<?= $estateToEdit ? $estateToEdit->getRooms() : 1 ?>">
                    </div>
                    <div>
                        <label class="auth_label">Етаж</label>
                        <input type="number" class="input_field auth_input" name="floor" required 
                               value="<?= $estateToEdit ? $estateToEdit->getFloor() : 1 ?>">
                    </div>
                </div>

                <div class="input_group">
                    <label class="auth_label">Цена (€)</label>
                    <input type="number" step="0.01" class="input_field auth_input" name="price" required 
                           value="<?= $estateToEdit ? $estateToEdit->getPrice() : '' ?>">
                </div>

                <div class="input_group">
                    <label class="auth_label">Описание</label>
                    <textarea class="input_field auth_input" name="description" rows="5" required style="resize: vertical; padding: 0.75rem;"><?= $estateToEdit ? htmlspecialchars($estateToEdit->getDescription()) : '' ?></textarea>
                </div>
            </div>

            <div style="grid-column: 1 / -1; display: flex; gap: 1rem; margin-top: 1rem;">
                <a href="index.php?action=admin_estates" class="btn_secondary" style="flex: 1; text-decoration: none;">Отказ</a>
                <button type="submit" class="btn_primary" style="flex: 2;">Запази обявата</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citySelect = document.getElementById('citySelect');
            const neighborhoodSelect = document.getElementById('neighborhoodSelect');
            const allNeighborhoodOptions = Array.from(neighborhoodSelect.querySelectorAll('option[data-city]'));
            
            let isInitialLoad = true;
            // Тук също използваме getNeighborhoodId()
            const preselectedNeighborhood = "<?= $estateToEdit ? $estateToEdit->getNeighborhoodId() : '' ?>";

            function filterNeighborhoods() {
                const selectedCityId = citySelect.value;
                allNeighborhoodOptions.forEach(opt => opt.style.display = 'none');
                
                if (!isInitialLoad) {
                    neighborhoodSelect.value = "";
                }

                if (selectedCityId) {
                    const validOptions = allNeighborhoodOptions.filter(opt => opt.getAttribute('data-city') === selectedCityId);
                    validOptions.forEach(opt => opt.style.display = 'block');
                    
                    if(validOptions.length > 0) {
                        neighborhoodSelect.options[0].innerText = "-- Избери Квартал --";
                    } else {
                        neighborhoodSelect.options[0].innerText = "-- Няма въведени квартали --";
                    }
                } else {
                    neighborhoodSelect.options[0].innerText = "-- Първо избери град --";
                }
                
                isInitialLoad = false;
            }

            citySelect.addEventListener('change', filterNeighborhoods);
            filterNeighborhoods();
        });
    </script>
</body>
</html>