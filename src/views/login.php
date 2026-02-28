<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - TU Estates</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="main_wrapper">
        <div class="auth_page_wrapper">
            <div class="auth_card">
                <div class="auth_header">
                    <h2 class="section_title" style="text-align: center;">Вход</h2>
                    <p class="section_description" style="text-align: center;">Добре дошли отново в TU Estates</p>
                </div>

                <form action="index.php?action=login_process" method="POST">
                    <div class="input_group">
                        <label class="auth_label">Имейл</label>
                        <input type="email" class="input_field auth_input" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="input_group">
                        <label class="auth_label">Парола</label>
                        <input type="password" class="input_field auth_input" name="password" placeholder="••••••••" required>
                    </div>
                    
                   <?php
                    if (isset($_GET['error'])) {
                        $error = htmlspecialchars(urldecode($_GET['error']));
                        if ($error === 'invalid_credentials') {
                            echo '<p style="color: red; font-size: 0.875rem; margin-top: 0.5rem;">Невалиден имейл или парола</p>';
                        }
                    }
                    ?>

                    <button type="submit" class="btn_primary" style="width: 100%; margin-top: 1.5rem;">Влез</button>
                </form>

                <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: var(--par-light);">
                    Нямате профил? <a href="index.php?action=register" style="color: var(--tu_blue_primary); font-weight: 600; text-decoration: none;">Регистрирайте се</a>
                </p>
            </div>
        </div>

        </div>
    <script src="script.js"></script>
</body>
</html>