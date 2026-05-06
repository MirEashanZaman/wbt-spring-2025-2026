<?php
// ================================================================
// CONTROLLERS - request handling + role-based logic
// ================================================================

/* ============== Login ============== */
function loginCtrl($conn) {
    $error = '';
    $prefill = $_COOKIE['remember_user'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        if ($u === '' || $p === '') {
            $error = 'Please fill in both fields.';
        } else {
            $admin = authAdmin($conn, $u, $p);
            if ($admin) {
                $_SESSION['user'] = [
                    'id' => $admin['id'], 'username' => $admin['username'],
                    'name' => 'Administrator', 'role' => 'admin'
                ];
                if ($remember) setcookie('remember_user', $u, time() + 86400 * 30, '/');
                else setcookie('remember_user', '', time() - 3600, '/');
                header('Location: index.php?page=admin');
                exit;
            }
            $salesperson = authSalesperson($conn, $u, $p);
            if ($salesperson) {
                $_SESSION['user'] = [
                    'id' => $salesperson['id'], 'username' => $salesperson['username'],
                    'name' => $salesperson['name'], 'role' => 'salesperson'
                ];
                if ($remember) setcookie('remember_user', $u, time() + 86400 * 30, '/');
                else setcookie('remember_user', '', time() - 3600, '/');
                header('Location: index.php?page=salesperson');
                exit;
            }
            $error = 'Invalid username or password.';
        }
    }

    require 'views/login.php';
}

function registerCtrl($conn) {
    $error = $success = '';
    $old = ['name' => '', 'contact' => '', 'username' => ''];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';
        $old = compact('name', 'contact', 'username');

        if ($name === '' || $contact === '' || $username === '' || $password === '') {
            $error = 'All fields are required.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } elseif (salespersonUsernameExists($conn, $username)) {
            $error = 'Username is already taken.';
        } else {
            if (addSalesperson($conn, $name, $contact, $username, $password)) {
                $success = 'Account created! You can now log in.';
                $old = ['name' => '', 'contact' => '', 'username' => ''];
            } else {
                $error = 'Registration failed. Try again.';
            }
        }
    }

    require 'views/register.php';
}

function adminCtrl($conn) {
    $action = $_GET['action'] ?? 'list';
    $error = '';
    $editing = null;  

    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $contact === '' || $username === '' || $password === '') {
            $error = 'All fields are required.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif (salespersonUsernameExists($conn, $username)) {
            $error = 'Username is already taken.';
        } else {
            if (addSalesperson($conn, $name, $contact, $username, $password)) {
                header('Location: index.php?page=admin&msg=added');
                exit;
            }
            $error = 'Failed to add salesperson.';
        }
    }

    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id       = intval($_GET['id'] ?? 0);
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');

        if ($name === '' || $contact === '' || $username === '') {
            $error = 'No field can be empty (NULL). All fields are required.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        } elseif (salespersonUsernameExists($conn, $username, $id)) {
            $error = 'That username is used by another salesperson.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        } else {
            if (updateSalesperson($conn, $id, $name, $contact, $username)) {
                header('Location: index.php?page=admin&msg=updated');
                exit;
            }
            $error = 'Update failed.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        }
    }

    if ($action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getSalesperson($conn, $id);
    }

    if ($action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) deleteSalesperson($conn, $id);
        header('Location: index.php?page=admin&msg=deleted');
        exit;
    }

    $salespersons = getSalespersons($conn);
    require 'views/admin.php';
}

function salespersonCtrl($conn) {
    $action = $_GET['action'] ?? 'list';
    $error = '';
    $editing = null;

    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $brand    = trim($_POST['brand'] ?? '');
        $model    = trim($_POST['model'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');
        $price    = trim($_POST['price'] ?? '');

        if ($brand === '' || $model === '' || $quantity === '' || $price === '') {
            $error = 'All fields are required.';
        } elseif (!ctype_digit($quantity) || intval($quantity) < 0) {
            $error = 'Quantity must be a non-negative whole number.';
        } elseif (!is_numeric($price) || floatval($price) < 0) {
            $error = 'Price must be a non-negative number.';
        } else {
            $salespersonId = $_SESSION['user']['id'];
            if (addCars($conn, $brand, $model, intval($quantity), floatval($price), $salespersonId)) {
                header('Location: index.php?page=salesperson&msg=added');
                exit;
            }
            $error = 'Failed to add car.';
        }
    }

    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id       = intval($_GET['id'] ?? 0);
        $brand    = trim($_POST['brand'] ?? '');
        $model    = trim($_POST['model'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');
        $price    = trim($_POST['price'] ?? '');

        if ($brand === '' || $model === '' || $quantity === '' || $price === '') {
            $error = 'No field can be empty (NULL). All fields are required.';
            $editing = ['id' => $id, 'brand' => $brand, 'model' => $model,
                        'quantity' => $quantity, 'price' => $price];
        } elseif (!ctype_digit($quantity) || intval($quantity) < 0) {
            $error = 'Quantity must be a non-negative whole number.';
            $editing = ['id' => $id, 'brand' => $brand, 'model' => $model,
                        'quantity' => $quantity, 'price' => $price];
        } elseif (!is_numeric($price) || floatval($price) < 0) {
            $error = 'Price must be a non-negative number.';
            $editing = ['id' => $id, 'brand' => $brand, 'model' => $model,
                        'quantity' => $quantity, 'price' => $price];
        } else {
            if (updateCars($conn, $id, $brand, $model, intval($quantity), floatval($price))) {
                header('Location: index.php?page=salesperson&msg=updated');
                exit;
            }
            $error = 'Update failed.';
            $editing = ['id' => $id, 'brand' => $brand, 'model' => $model,
                        'quantity' => $quantity, 'price' => $price];
        }
    }

    if ($action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getCar($conn, $id);
    }

    if ($action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) deleteCars($conn, $id);
        header('Location: index.php?page=salesperson&msg=deleted');
        exit;
    }

    $cars = getCars($conn);
    require 'views/salesperson.php';
}
?>