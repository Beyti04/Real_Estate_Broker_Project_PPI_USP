<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моите обяви - TU Estates</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <div class="main_wrapper">
        <!-- Header от homepage.php -->
        <header>
            <div class="logo">
                <a class="logo_group" href="index.php?action=homepage">
                    <picture>
                        <img class="icon_box theme_light_img" src="images/broker_logo_light.png" alt="Logo">
                        <img class="icon_box theme_dark_img" src="images/broker_logo_dark.png" alt="Logo">
                    </picture>
                    <h1 class="heading_primary">TU Estates</h1>
                </a>
            </div>
            <div class="nav_wrapper">
                <div class="nav_container">
                    <nav class="nav_links">
                        <a class="nav_link" href="index.php?action=buy_rent">Обяви</a>
                        <a class="nav_link" href="index.php?action=sell">Продай</a>
                        <a class="nav_link" href="index.php?action=agents">Агенти</a>
                        <a class="nav_link active" href="index.php?action=my_estates">Моите обяви</a>
                    </nav>
                    <div class="sing_in_btns">
                        <button id="theme-toggle" class="btn_secondary" style="padding: 0; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-light); cursor: pointer; background: transparent;">
                            🌙
                        </button>
                        <a href="index.php?action=profile" class="btn_primary">Профил</a>
                        <a href="index.php?action=logout" class="btn_secondary">Изход</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="content_section" style="padding: 1rem 0 0;">
            <div class="container_center ">
                <h2 class="section_title" style="margin-bottom: 2rem;">Моите имоти</h2>

                <div class="my_estates_grid">
                    <?php
                    $my_estates = \App\Controllers\EstateController::getEstatesByOwnerId($_SESSION['user_id']);
                    if (empty($my_estates)) {
                        echo '<p style="text-align:center; font-size:1.2rem; color:var(--text-secondary);">Все още нямате добавени обяви. <a href="index.php?action=sell" style="color:var(--primary-color); text-decoration:underline;">Добавете първата си обява!</a></p>';
                    } ?>
                    <?php foreach ($my_estates as $estate): ?>
                        <article class="estate_card">
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

                                    <div class="btn_view">Преглед</div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div id="pagination" class="pagination_container"></div>

                <!-- Pagination Container -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const grid = document.querySelector('.my_estates_grid');
                        const cards = Array.from(grid.querySelectorAll('.estate_card'));
                        const paginationContainer = document.getElementById('pagination');

                        const cardsPerPage = 4;
                        let currentPage = 1;
                        const totalPages = Math.ceil(cards.length / cardsPerPage);

                        function goToPage(page) {
                            if (page < 1 || page > totalPages) return;

                            currentPage = page;
                            const start = (page - 1) * cardsPerPage;
                            const end = start + cardsPerPage;

                            cards.forEach((card, index) => {
                                // Използваме flex, за да запазим подравняването на картата
                                card.style.display = (index >= start && index < end) ? 'flex' : 'none';
                            });

                            renderPagination();

                            // Плавно скролване до началото на секцията
                            window.scrollTo({
                                top: document.querySelector('.content_section').offsetTop - 20,
                                behavior: 'smooth'
                            });
                        }

                        function renderPagination() {
                            paginationContainer.innerHTML = '';
                            if (totalPages <= 1) return;

                            const numbersDiv = document.createElement('div');
                            numbersDiv.className = 'page_numbers';

                            // Бутон за Предишна ( < )
                            if (currentPage > 1) {
                                const prev = document.createElement('a');
                                prev.className = 'page_link';
                                prev.innerHTML = '<';
                                prev.href = '#';
                                prev.onclick = (e) => {
                                    e.preventDefault();
                                    goToPage(currentPage - 1);
                                };
                                numbersDiv.appendChild(prev);
                            }

                            // Номера на страници
                            for (let i = 1; i <= totalPages; i++) {
                                const link = document.createElement('a');
                                link.className = `page_link ${i === currentPage ? 'active' : ''}`;
                                link.innerText = i;
                                link.href = '#';
                                link.onclick = (e) => {
                                    e.preventDefault();
                                    goToPage(i);
                                };
                                numbersDiv.appendChild(link);
                            }

                            // Бутон за Следваща ( > )
                            if (currentPage < totalPages) {
                                const next = document.createElement('a');
                                next.className = 'page_link';
                                next.innerHTML = '>';
                                next.href = '#';
                                next.onclick = (e) => {
                                    e.preventDefault();
                                    goToPage(currentPage + 1);
                                };
                                numbersDiv.appendChild(next);
                            }

                            paginationContainer.appendChild(numbersDiv);
                        }

                        if (cards.length > 0) {
                            goToPage(1);
                        } else {
                            paginationContainer.innerHTML = '';
                        }
                    });
                </script>
            </div>
        </main>
    </div>
</body>

</html>