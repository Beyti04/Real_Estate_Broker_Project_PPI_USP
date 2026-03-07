<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Панел - TU Estates</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: var(--search-light);"> <header style="background-color: var(--tu_blue_primary); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; z-index: 100;">
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
                <a href="index.php?action=admin" class="admin_nav_link active">👥 Потребители</a>
                <a href="index.php?action=admin_estates" class="admin_nav_link">🏠 Обяви</a>
                <a href="index.php?action=admin_settings" class="admin_nav_link">⚙️ Настройки</a>
                <a href="index.php?action=homepage" class="admin_nav_link" style="margin-top: auto;">🌐 Към сайта</a>
            </nav>
        </aside>

        <main class="admin_main">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 class="section_title">Управление на потребители</h2>
                <a href="index.php?action=admin_add_user" class="btn_primary" style="text-decoration: none;">+ Нов потребител</a>
            </div>

            <div class="table_container">
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Потребителско име</th>
                            <th>Имейл</th>
                            <th>Тип акаунт</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        use App\Controllers\UserController;
                        $users = UserController::getAllUsers();

                        foreach ($users as $user): 
                            // Определяме ролята спрямо ID-то за по-красиво показване
                            $roleName = match((int)$user->getUserType()) {
                                1 => '<span class="badge badge-admin">Админ</span>',
                                2 => '<span class="badge badge-broker">Брокер</span>',
                                3 => '<span class="badge badge-user">Частно лице</span>',
                                default => '<span class="badge">Гост</span>'
                            };
                        ?>
                        <tr>
                            <td>#<?= htmlspecialchars($user->getId()) ?></td>
                            <td style="font-weight: 600;"><?= htmlspecialchars($user->getUsername()) ?></td>
                            <td><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td><?= $roleName ?></td>
                            <td>
                                <a href="index.php?action=admin_edit_user&id=<?= $user->getId() ?>" class="action_btn edit_btn" style="text-decoration: none;">Редакция</a>
                                <a href="index.php?action=admin_delete_user&id=<?= $user->getId() ?>" class="action_btn delete_btn" style="text-decoration: none;" onclick="return confirm('Сигурни ли сте, че искате да изтриете този потребител?');">Изтриване</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>