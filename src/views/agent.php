<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Агенти</title>
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

        <section class="agent_content_section">
            <div class="container_center">
                <div class="agent_header">
                    <h2 class="section_title">Агенти</h2>
                </div>
                <div class="agents_grid">
                    <?php foreach ($agents as $agent): ?>
                        <a class="agent_card theme_dark" href="index.php?action=agent_profile&id=<?= $agent->getId(); ?>" style="text-decoration:none; color:inherit;"> 
                        
                        <img class="agent_image"
                                src="<?= $agent->getImage() !== "-" && !empty($agent->getImage()) ? htmlspecialchars($agent->getImage()) : 'images/base_broker.png'; ?>"
                                alt="<?= htmlspecialchars($agent->getUsername()); ?>">
                            <div class="agent-info-row">
                                <div class="agent_label">Име:</div>
                                <div class="agent_data"><?= htmlspecialchars($agent->getUsername()); ?></div>
                            </div>
                            <div class="agent-info-row">
                                <div class="agent_label">Телефон:</div>
                                <div class="agent_data"><?= htmlspecialchars($agent->getPhone()); ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>


        <script>
            //Pagination logic
            document.addEventListener('DOMContentLoaded', function() {
                const grid = document.querySelector('.agents_grid');
                const cards = Array.from(grid.querySelectorAll('.agent_card'));

                // Търсим контейнера за пагинация или го създаваме динамично под грида
                let paginationContainer = document.getElementById('pagination');
                if (!paginationContainer) {
                    paginationContainer = document.createElement('div');
                    paginationContainer.id = 'pagination';
                    paginationContainer.className = 'pagination_container';
                    paginationContainer.style.marginTop = '2rem';
                    grid.parentNode.insertBefore(paginationContainer, grid.nextSibling);
                }

                const cardsPerPage = 3; // Брой агенти на една страница (кратно на 3 е идеално за твоя грид)
                let currentPage = 1;
                const totalPages = Math.ceil(cards.length / cardsPerPage);

                function renderPagination() {
                    paginationContainer.innerHTML = ''; // Изчистване на старите бутони

                    if (totalPages <= 1) return; // Ако има малко агенти, скриваме пагинацията

                    // 1. Бутон за ПРЕДИШНА страница (<)
                    if (currentPage > 1) {
                        const prevDiv = document.createElement('div');
                        prevDiv.className = 'page_numbers';
                        prevDiv.innerHTML = `<a href="#" class="page_link"><</a>`;
                        prevDiv.onclick = (e) => {
                            e.preventDefault();
                            goToPage(currentPage - 1);
                        };
                        paginationContainer.appendChild(prevDiv);
                    }

                    // 2. Номерата на страниците (1, 2, 3...)
                    const numbersDiv = document.createElement('div');
                    numbersDiv.className = 'page_numbers';

                    for (let i = 1; i <= totalPages; i++) {
                        const pageLink = document.createElement('a');
                        pageLink.href = "#";
                        pageLink.className = `page_link ${i === currentPage ? 'active' : ''}`;
                        pageLink.textContent = i;
                        pageLink.onclick = (e) => {
                            e.preventDefault();
                            goToPage(i);
                        };
                        numbersDiv.appendChild(pageLink);
                    }
                    paginationContainer.appendChild(numbersDiv);

                    // 3. Бутон за СЛЕДВАЩА страница (>)
                    if (currentPage < totalPages) {
                        const nextDiv = document.createElement('div');
                        nextDiv.className = 'page_numbers';
                        nextDiv.innerHTML = `<a href="#" class="page_link">></a>`;
                        nextDiv.onclick = (e) => {
                            e.preventDefault();
                            goToPage(currentPage + 1);
                        };
                        paginationContainer.appendChild(nextDiv);
                    }
                }

                function goToPage(page) {
                    currentPage = page;
                    const start = (page - 1) * cardsPerPage;
                    const end = start + cardsPerPage;

                    // Показваме/скриваме картите в зависимост от страницата
                    cards.forEach((card, index) => {
                        // Използваме 'flex', защото обикновено картите са flexbox контейнери в твоя CSS
                        card.style.display = (index >= start && index < end) ? 'flex' : 'none';
                    });

                    renderPagination();

                    // Плавно скролване обратно до заглавието "Агенти"
                    const headerOffset = document.querySelector('.agent_header').offsetTop;
                    window.scrollTo({
                        top: headerOffset - 20,
                        behavior: 'smooth'
                    });
                }

                // Инициализация - стартираме винаги от страница 1
                if (cards.length > 0) {
                    goToPage(1);
                }
            });
        </script>
    </div>
</body>