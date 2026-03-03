<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $userToEdit ? 'Редакция' : 'Нов Потребител' ?> - Админ Панел</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: var(--search-light); display: flex; align-items: center; justify-content: center; height: 100vh;">

    <div class="auth_card" style="width: 100%; max-width: 500px;">
        <div class="auth_header" style="margin-bottom: 1.5rem;">
            <h2 class="section_title" style="text-align: center;">
                <?= $userToEdit ? 'Редакция на потребител' : 'Създаване на потребител' ?>
            </h2>
        </div>

        <form action="index.php?action=admin_save_user" method="POST">
            <input type="hidden" name="id" value="<?= $userToEdit ? $userToEdit->getId() : 0 ?>">

            <div class="input_group">
                <label class="auth_label">Потребителско име</label>
                <input type="text" class="input_field auth_input" name="username" 
                       value="<?= $userToEdit ? htmlspecialchars($userToEdit->getUsername()) : '' ?>" required>
            </div>

            <div class="input_group">
                <label class="auth_label">Имейл</label>
                <input type="email" class="input_field auth_input" name="email" 
                       value="<?= $userToEdit ? htmlspecialchars($userToEdit->getEmail()) : '' ?>" required>
            </div>

            <?php if (!$userToEdit): ?>
            <div class="input_group">
                <label class="auth_label">Парола</label>
                <input type="password" class="input_field auth_input" name="password" required>
            </div>
            <?php endif; ?>

            <div class="input_group">
                <label class="auth_label">Роля (Тип акаунт)</label>
                <?php $currentTypeId = $userToEdit ? $userToEdit->getUserType() : 3; ?>
                <select class="input_field auth_input" name="user_type_id" required style="padding-left: 0.75rem;">
                    <option value="1" <?= $currentTypeId == 1 ? 'selected' : '' ?>>Админ</option>
                    <option value="2" <?= $currentTypeId == 2 ? 'selected' : '' ?>>Брокер</option>
                    <option value="3" <?= $currentTypeId == 3 ? 'selected' : '' ?>>Частно лице</option>
                </select>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <a href="index.php?action=admin" class="btn_secondary" style="flex: 1; text-decoration: none;">Отказ</a>
                <button type="submit" class="btn_primary" style="flex: 1;">Запази</button>
            </div>
        </form>
    </div>

</body>
</html>