<?php
// ================================================================
// MODELS - All DB access using procedural mysqli + prepared stmts
// ================================================================

function authAdmin($conn, $username, $password) {
    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM admins WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return ($row && password_verify($password, $row['password'])) ? $row : false;
}

function getSalespersons($conn) {
    $r = mysqli_query($conn, "SELECT id, name, contact, username FROM salespersons ORDER BY id DESC");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function getSalesperson($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT id, name, contact, username FROM salespersons WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function addSalesperson($conn, $name, $contact, $username, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO salespersons (name, contact, username, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $contact, $username, $hash);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateSalesperson($conn, $id, $name, $contact, $username) {
    $stmt = mysqli_prepare($conn, "UPDATE salespersons SET name = ?, contact = ?, username = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'sssi', $name, $contact, $username, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteSalesperson($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM salespersons WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function searchSalesperson($conn, $term) {
    $like = '%' . $term . '%';
    $stmt = mysqli_prepare($conn,
        "SELECT id, name, contact, username FROM salespersons
         WHERE name LIKE ? OR username LIKE ? OR contact LIKE ?
         ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function authSalesperson($conn, $username, $password) {
    $stmt = mysqli_prepare($conn, "SELECT id, name, username, password FROM salespersons WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return ($row && password_verify($password, $row['password'])) ? $row : false;
}

function salespersonUsernameExists($conn, $username, $excludeId = null) {
    if ($excludeId) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM salespersons WHERE username = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, 'si', $username, $excludeId);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM salespersons WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

function getCars($conn) {
    $r = mysqli_query($conn, "SELECT id, brand, model, quantity, price FROM cars ORDER BY id DESC");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function getCar($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT id, brand, model, quantity, price FROM cars WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function addCars($conn, $brand, $model, $quantity, $price, $salespersonId) {
    $stmt = mysqli_prepare($conn, "INSERT INTO cars (brand, model, quantity, price, salesperson_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssidi', $brand, $model, $quantity, $price, $salespersonId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateCars($conn, $id, $brand, $model, $quantity, $price) {
    $stmt = mysqli_prepare($conn, "UPDATE cars SET brand = ?, model = ?, quantity = ?, price = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'ssidi', $brand, $model, $quantity, $price, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteCars($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM cars WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function searchCars($conn, $term) {
    $like = '%' . $term . '%';
    $stmt = mysqli_prepare($conn,
        "SELECT id, brand, model, quantity, price FROM cars
         WHERE model LIKE ? OR brand LIKE ?
         ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, 'ss', $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}
?>