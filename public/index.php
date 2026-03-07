<?php

use Config\Database;

session_start();

const VIEW_DIR = __DIR__ . '/../src/views/';

spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\'    => __DIR__ . '/../src/',
        'Config\\' => __DIR__ . '/../config/'
    ];





    foreach ($prefixes as $prefix => $base_dir) {
        // Проверява дали класът използва този prefix
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Взима името на класа без prefix-а
        $relative_class = substr($class, $len);

        // Превръща namespace пътя във файлов път (напр. Controllers\AuthController -> Controllers/AuthController.php)
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // Ако файлът съществува, го зарежда
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

$action = $_GET['action'] ?? 'homepage';

switch ($action) {
    case 'homepage':
        Database::getInstance(); // Ensure DB is initialized before loading homepage
        require VIEW_DIR . 'homepage.php';
        break;
    case 'buy_rent':
        require VIEW_DIR . 'buy_rent.php';
        break;
    //Admin Panel
    case 'admin':
        if(!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] !== 1) {
            header('Location: index.php?action=homepage');
            exit;
        }
        require VIEW_DIR . 'admin.php';
        break;

    case 'admin_delete_user':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { 
            header("Location: index.php"); exit; 
        }
        
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && $id !== $_SESSION['user_id']) {
            \App\Controllers\UserController::deleteUser($id);
        }
        header("Location: index.php?action=admin");
        exit;
        break;

    case 'admin_add_user':
    case 'admin_edit_user':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { 
            header("Location: index.php"); exit; 
        }
        
        $userToEdit = null;
        if ($action === 'admin_edit_user' && isset($_GET['id'])) {
            $userController = new \App\Controllers\UserController();
            $userToEdit = $userController->getUserById((int)$_GET['id']);
        }
        
        require VIEW_DIR . 'admin_user_form.php';
        break;

    case 'admin_save_user':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { header("Location: index.php"); exit; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $userTypeId = (int)($_POST['user_type_id'] ?? 3);
            
            if ($id > 0) {
                \App\Controllers\UserController::updateUser($id, $username, $email, $userTypeId);
            } else {
                $password = $_POST['password'] ?? '';
                \App\Controllers\AuthController::register($username, $email, $password, $userTypeId);
            }
        }
        header("Location: index.php?action=admin");
        exit;
        break;

        case 'admin_estates':
            if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { header("Location: index.php"); exit; }
            require VIEW_DIR . 'admin_estates.php';
            break;

        case 'admin_add_estate':
        case 'admin_edit_estate':
            if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { header("Location: index.php"); exit; }

            if ($action === 'admin_edit_estate' && isset($_GET['id'])) {
                $estateController = new \App\Controllers\EstateController();
                $estateToEdit = $estateController->getEstateById((int)$_GET['id']);
            } else {
                $estateToEdit = null;
            }

            require VIEW_DIR . 'admin_estate_form.php';
            break;
       
        case 'admin_save_estate':
            if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { header("Location: index.php"); exit; }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = (int)($_POST['id'] ?? 0);
                $cityId = (int)$_POST['city_id'];
                $neighborhoodId = (int)$_POST['neighborhood_id'];
                $address = $_POST['estate_address'] ?? '';
                $estateTypeId = (int)$_POST['estate_type_id'];
                $exposureType = $_POST['exposure_type'] ?? '';
                $rooms = (int)$_POST['rooms'];
                $floor = (int)$_POST['floor'];
                $description = $_POST['description'] ?? '';
                $listingTypeId = (int)$_POST['listing_type_id'];
                $price = (float)$_POST['price'];
                $ownerId = (int)$_POST['owner_id'];
                $statusId = (int)$_POST['status_id'];

                if ($id > 0) {
                    \App\Controllers\EstateController::updateEstate(
                        $id, $cityId, $neighborhoodId, $address, $estateTypeId, 
                        $exposureType, $rooms, $floor, $description, 
                        $listingTypeId, $price, $ownerId, $statusId
                    );
                } else {
                    \App\Controllers\EstateController::createEstate(
                        $cityId, $neighborhoodId, $address, $estateTypeId, 
                        $exposureType, $rooms, $floor, $description, 
                        $listingTypeId, $price, $ownerId, $statusId
                    );
                }
            }
            header("Location: index.php?action=admin_estates");
            exit;
            break;

        case 'admin_delete_estate':
            if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { header("Location: index.php"); exit; }
            
            $id = (int)($_GET['id'] ?? 0);
            if ($id > 0) {
                \App\Controllers\EstateController::deleteEstate($id);
            }
            header("Location: index.php?action=admin_estates");
            exit;
            break;

        case 'admin_settings':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { header("Location: index.php"); exit; }
        
        $userController = new \App\Controllers\UserController();
        $currentUser = $userController->getUserById($_SESSION['user_id']);
        
        require VIEW_DIR . 'admin_settings.php';
        break;

    case 'admin_save_settings':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type_id'] != 1) { header("Location: index.php"); exit; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            
            $success = \App\Controllers\UserController::updateProfile($userId, $username, $email, $newPassword, $currentPassword);
            
            if ($success) {
                $_SESSION['username'] = $username;
                header("Location: index.php?action=admin_settings&success=1");
            } else {
                header("Location: index.php?action=admin_settings&error=1");
            }
            exit;
        }
        break;

    //Auth
    case 'login':
        require VIEW_DIR . 'login.php';
        break;
    case 'register':
        require VIEW_DIR . 'register.php';
        break;
    case 'login_process':
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = App\Controllers\AuthController::login($email, $password);
            if($_SESSION['user_type_id'] === 1) {
                header('Location: index.php?action=admin');
                exit;
            }

            if ($user) {
                header('Location: index.php?action=homepage');
                exit;
            } else {
                header('Location: index.php?action=login&error=invalid_credentials');
                exit;
            }
        }
        break;
    case 'register_process':
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user_type_id = (int)($_POST['user_type_id'] ?? 3);

            $success = App\Controllers\AuthController::register($username, $email, $password, $user_type_id);
            if ($success) {
                header('Location: index.php?action=login&message=registration_success');
                exit;
            } else {
                header('Location: index.php?action=register&error=registration_failed');
                exit;
            }
        }
        break;
    case 'logout':
        App\Controllers\AuthController::logout();
        header('Location: index.php?action=homepage');
        exit;

    default:
        echo "404 Not Found";
        break;
}
