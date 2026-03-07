<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки - Админ Панел</title>
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
                <a href="index.php?action=admin_estates" class="admin_nav_link">🏠 Обяви</a>
                <a href="index.php?action=admin_settings" class="admin_nav_link active">⚙️ Настройки</a>
                <a href="index.php?action=homepage" class="admin_nav_link" style="margin-top: auto;">🌐 Към сайта</a>
            </nav>
        </aside>

        <main class="admin_main">
            <h2 class="section_title" style="margin-bottom: 2rem;">Настройки на профила</h2>

            <?php if (isset($_GET['success'])): ?>
                <div style="background-color: #dcfce7; color: #15803d; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 600;">
                    ✅ Промените бяха запазени успешно!
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 600;">
                    ❌ Възникна грешка при запазването. Моля, опитайте отново.
                </div>
            <?php endif; ?>

            <div class="auth_card" style="max-width: 600px; margin: 0;">
                <form action="index.php?action=admin_save_settings" method="POST">
                    
                    <h3 style="margin-bottom: 1rem; color: var(--text-light); border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">Лични данни</h3>
                    
                    <div class="input_group">
                        <label class="auth_label">Потребителско име</label>
                        <input type="text" class="input_field auth_input" name="username" required 
                               value="<?= htmlspecialchars($currentUser->username ?? $currentUser->getUsername()) ?>">
                    </div>

                    <div class="input_group">
                        <label class="auth_label">Имейл адрес</label>
                        <input type="email" class="input_field auth_input" name="email" required 
                               value="<?= htmlspecialchars($currentUser->email ?? $currentUser->getEmail()) ?>">
                    </div>

                    <h3 style="margin-top: 2rem; margin-bottom: 1rem; color: var(--text-light); border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">Смяна на парола</h3>
                    <p style="font-size: 0.85rem; color: var(--par-light); margin-bottom: 1rem;">Оставете празно, ако не желаете да променяте текущата си парола.</p>

                    <div class="input_group">
                        <label class="auth_label">Текуща парола</label>
                        <input type="password" class="input_field auth_input" name="current_password" placeholder="Въведете текущата си парола...">
                    </div>
                    
                    <div class="input_group">
                        <label class="auth_label">Нова парола</label>
                        <input type="password" class="input_field auth_input" name="new_password" placeholder="Въведете нова парола...">
                    </div>

                    <button type="submit" class="btn_primary" style="margin-top: 1.5rem; width: 100%;">Запази промените</button>
                </form>
            </div>
        </main>
    </div>

</body>
</html>