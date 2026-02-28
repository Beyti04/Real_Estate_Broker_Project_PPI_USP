<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - TU Estates</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main_wrapper">
        <div class="auth_page_wrapper">
            <div class="auth_card">
                <div class="auth_header">
                    <h2 class="section_title" style="text-align: center;">Регистрация</h2>
                    <p class="section_description" style="text-align: center;">Създайте своя профил в TU Estates</p>
                </div>

                <form action="index.php?action=register_process" method="POST">
                    <div class="input_group">
                        <label class="auth_label">Потребителско име</label>
                        <input type="text" class="input_field auth_input" name="username" placeholder="Вашето име" required>
                    </div>
                    <div class="input_group">
                        <label class="auth_label">Имейл</label>
                        <input type="email" class="input_field auth_input" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="input_group">
                        <label class="auth_label">Парола</label>
                        <input type="password" class="input_field auth_input" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <div class="input_group">
                        <label class="auth_label">Тип акаунт</label>
                        <select class="input_field auth_input" name="user_type_id" required style="padding-left: 0.75rem;">
                            <option value="3">Частно лице</option>
                            <option value="2">Брокер</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn_primary" style="width: 100%; margin-top: 1.5rem;">Създай профил</button>
                </form>

                <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: var(--par-light);">
                    Вече имате профил? <a href="index.php?action=login" style="color: var(--tu_blue_primary); font-weight: 600; text-decoration: none;">Влезте тук</a>
                </p>
            </div>
        </div>

        </div>
    <script src="script.js"></script>
</body>
</html>