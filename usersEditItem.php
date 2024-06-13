<?php
require_once 'include/dbConnection.php';

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchById($user_id) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($user_id, $first_name, $last_name, $nickname, $email, $admin) {
        $query = "UPDATE users SET first_name = ?, last_name = ?, nickname = ?, email = ?,`admin` = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssssi", $first_name, $last_name, $nickname, $email, $admin, $user_id);
        return $stmt->execute();
    }
}

$userModel = new UserModel($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $admin = intval($_POST['admin']);

   
    if ($userModel->update($user_id, $first_name, $last_name, $nickname, $email, $admin)) {
        header('Location: usersEdit.php');
        exit;
    } else {
        echo "Failed to update user.";
    }
    } else {
        if (isset($_GET['user_id'])) {
            $user_id = intval($_GET['user_id']);
            $user = $userModel->fetchById($user_id);
        } else {
            echo "No user ID provided.";
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Coment</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/my-styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h2>Edit Coment</h2>
        <form action="usersEditItem.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nickname" class="form-label">Nickname</label>
                <input type="text" class="form-control" id="nickname" name="nickname" value="<?= htmlspecialchars($user['nickname']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="admin" class="form-label">Admin</label>
                <input type="number" class="form-control" id="admin" name="admin" min="0" max="1" value="<?= htmlspecialchars($user['admin']) ?>">
            </div>
            <button type="submit" class="btn btn-primary mb-3">Aktualizovat</button>
        </form>
    </div>
</body>
</html>
