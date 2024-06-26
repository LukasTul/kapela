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

    public function update($user_id, $first_name, $last_name, $nickname, $email) {
        $query = "UPDATE users SET first_name = ?, last_name = ?, nickname = ?, email = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssi", $first_name, $last_name, $nickname, $email, $user_id);
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

   
    if ($userModel->update($user_id, $first_name, $last_name, $nickname, $email)) {
        header('Location: index.php');
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
<body class="bg-dark text-white-50">
    <div class="container">
        <h2 class="text-white">Editate profilu</h2>
        <form action="userEditItem.php" method="post" enctype="multipart/form-data">
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
            <button type="submit" class="btn btn-primary mb-3">Aktualizovat</button>
        </form>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy;  Neutopia kapela 2024</p></div>
        </footer>
    </div>
</body>
</html>
