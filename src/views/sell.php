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
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('estate-images-input');
    const previewContainer = document.getElementById('image-preview-container');

    if (!input || !previewContainer) return;

    input.addEventListener('change', function () {
        previewContainer.innerHTML = '';

        const files = Array.from(this.files);

        files.forEach(file => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                const previewItem = document.createElement('div');
                previewItem.classList.add('preview-item');

                previewItem.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                previewContainer.appendChild(previewItem);
            };

            reader.readAsDataURL(file);
        });
    });
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
                <div class="nav_container">
                    <nav class="nav_links">
                        <a class="nav_link" href="index.php?action=buy_rent">Buy/Rent</a>
                        <a class="nav_link" href="index.php?action=sell">Sell</a>
                        <a class="nav_link" href="index.php?action=agents">Agents</a>
                    </nav>
                    <div class="sing_in_btns">
                        <a href="index.php?action=logout" class="btn_secondary">Log Out</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="content_section">
            <div class="create-estate-page">
                <h2 class="section_title" style="margin-top:-100px;">Create Property Listing</h2>

                <form action="index.php?action=create_estate_process" method="POST" enctype="multipart/form-data" class="create-estate-form">

                    <div class="estate-column">
                        <h3 style = "margin-top:-30px;">Property Details</h3>

                        <label>Address</label>
                        <input type="text" name="estate_address" class="input_field" required>

                        <label>Listing Type</label>
                        <select name="listing_type_id" class="input_field" required>
                            <option value="">Choose</option>
                            <?php
                            $listingTypes = \App\Controllers\ListingTypeController::getAllListingTypes();
                            foreach ($listingTypes as $lt) {
                                echo '<option value="'.$lt->getId().'">'.htmlspecialchars($lt->getTypeName()).'</option>';
                            }
                            ?>
                        </select>

                        <label>Estate Type</label>
                        <select name="estate_type_id" class="input_field" required>
                            <option value="">Choose</option>
                            <?php
                            $estateTypes = \App\Controllers\EstateTypeController::getAllEstateTypes();
                            foreach ($estateTypes as $et) {
                                echo '<option value="'.$et->getId().'">'.htmlspecialchars($et->getTypeName()).'</option>';
                            }
                            ?>
                        </select>

                        <label>City</label>
                        <select name="city_id" class="input_field" required>
                            <option value="">Choose</option>
                            <?php
                            $cities = \App\Controllers\CityController::getAllCities();
                            foreach ($cities as $city) {
                                echo '<option value="'.$city->getId().'">'.htmlspecialchars($city->getCityNameBG()).'</option>';
                            }
                            ?>
                        </select>

                        <label>Neighborhood</label>
                        <select name="neighborhood_id" class="input_field" required>
                            <option value="">Choose</option>
                            <?php
                            $neighborhoods = \App\Controllers\NeighborhoodController::getAllNeighborhoods();
                            foreach ($neighborhoods as $neighborhood) {
                                echo '<option value="'.$neighborhood->getId().'">'.htmlspecialchars($neighborhood->getNeighborhoodNameBG()).'</option>';
                            }
                            ?>
                        </select>

                        <label>Exposure</label>
                        <select name="exposure_type" class="input_field" required>
                            <option value="">Choose</option>
                            <?php
                            foreach (\App\Models\ExposureType::getOptions() as $option) {
                                echo '<option value="'.$option.'">'.htmlspecialchars($option).'</option>';
                            }
                            ?>
                        </select>

                        <label>Rooms</label>
                        <input type="number" name="rooms" class="input_field" min="1" required>

                        <label>Floor</label>
                        <input type="number" name="floor" class="input_field" required>

                        <label>Area (m²)</label>
                        <input type="number" step="0.01" name="area" class="input_field" required>

                        <label>Price (€)</label>
                        <input type="number" step="0.01" name="price" class="input_field" required>
                    </div>

                    <div class="estate-column">
                        <h3>Description</h3>
                        <label>Property Description</label>
                        <textarea name="description" class="input_field estate-textarea" required placeholder="Write full property description here..."></textarea>
                    </div>

                    <div class="estate-column">
                        <h3>Images</h3>
                        <label>Upload images</label>
                        <input type="file" name="images[]" class="input_field" accept="image/*" multiple required>

                        <div class="upload-note">
                            At least one image is required. The listing cannot be published without images.
                        </div>

                        <button type="submit" class="btn_primary upload-estate-btn">Upload Listing</button>
                    </div>

                </form>
            </div>
        </section>
    </div>
</body>
</html>