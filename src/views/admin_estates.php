<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Панел - Обяви</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color: var(--search-light);">

    <header style="background-color: var(--tu_blue_primary); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; z-index: 100;">
        <div class="logo_group" style="color: white;">
            <h1 class="heading_primary" style="color: white; margin: 0;">TU Estates | Админ</h1>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span style="font-weight: 600; font-size: 0.9rem;">Здравей, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="index.php?action=logout" class="btn_secondary" style="color: white; border-color: white;">Изход</a>
        </div>
    </header>

    <div class="admin_layout">
        <aside class="admin_sidebar">
            <nav class="admin_nav">
                <a href="index.php?action=admin" class="admin_nav_link">👥 Потребители</a>
                <a href="index.php?action=admin_estates" class="admin_nav_link active">🏠 Обяви</a>
                <a href="index.php?action=admin_settings" class="admin_nav_link">⚙️ Настройки</a>
                <a href="index.php?action=homepage" class="admin_nav_link" style="margin-top: auto;">🌐 Към сайта</a>
            </nav>
        </aside>

        <main class="admin_main">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 class="section_title">Управление на обяви</h2>
                <a href="index.php?action=admin_add_estate" class="btn_primary" style="text-decoration: none;">+ Нова обява</a>
            </div>

            <div class="table_container">
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Вид Имот</th>
                            <th>Тип</th>
                            <th>Локация</th>
                            <th>Цена</th>
                            <th>Собственик</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        use App\Controllers\EstateController;

                        $estates = EstateController::getAllEstates();

                        if (empty($estates)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem;">Няма намерени обяви.</td>
                            </tr>
                            <?php else:
                            foreach ($estates as $estate):
                                $typeClass = ($estate->listing_type === 'Продажба') ? 'badge-broker' : 'badge-user';
                            ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($estate->id) ?></td>
                                    <td style="font-weight: 600;"><?= htmlspecialchars($estate->estate_type ?? 'Неизвестен') ?></td>
                                    <td><span class="badge <?= $typeClass ?>"><?= htmlspecialchars($estate->listing_type ?? '-') ?></span></td>
                                    <td><?= htmlspecialchars($estate->city_name ?? '') ?>, кв. <?= htmlspecialchars($estate->neighborhood_name ?? '') ?></td>
                                    <td style="font-weight: 700; color: var(--tu_blue_primary);">
                                        <?= number_format($estate->price, 0, ',', ' ') ?> €
                                    </td>
                                    <td><?= htmlspecialchars($estate->owner_name ?? 'Няма') ?></td>
                                    <td>
                                        <a href="index.php?action=admin_edit_estate&id=<?= $estate->id ?>" class="action_btn edit_btn" style="text-decoration: none;">Редакция</a>
                                        <a href="index.php?action=admin_delete_estate&id=<?= $estate->id ?>" class="action_btn delete_btn" style="text-decoration: none;" onclick="return confirm('Сигурни ли сте, че искате да изтриете тази обява?');">Изтриване</a>
                                    </td>
                                </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="pagination" class="pagination_container" style="margin-top: 20px;"></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const table = document.querySelector('.admin_table');
                    const tbody = table.querySelector('tbody');
                    const rows = Array.from(tbody.querySelectorAll('tr'));
                    const paginationContainer = document.getElementById('pagination');

                    const rowsPerPage = 8;
                    let currentPage = 1;
                    const totalPages = Math.ceil(rows.length / rowsPerPage);

                    function renderPagination() {
                        paginationContainer.innerHTML = ''; // Изчистваме старото съдържание

                        if (totalPages <= 1) return;

                        // --- 1. Бутон за ПРЕДИШНА ( < ) ---
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

                        // --- 2. Числата ( 1, 2, 3... ) ---
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

                        // --- 3. Бутон за СЛЕДВАЩА ( > ) ---
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
                        const start = (page - 1) * rowsPerPage;
                        const end = start + rowsPerPage;

                        rows.forEach((row, index) => {
                            row.style.display = (index >= start && index < end) ? '' : 'none';
                        });

                        renderPagination();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }

                    // Стартираме от страница 1
                    if (rows.length > 0) {
                        goToPage(1);
                    }
                });
            </script>
        </main>
    </div>

</body>

</html>