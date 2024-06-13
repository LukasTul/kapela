<?php
    // Zahrnutí souboru pro připojení k databázi
    require_once 'include/dbConnection.php';

    class UserModel {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function fetchAll() {
            $query = "SELECT * FROM users";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function delete($user_id) {
            $query = "DELETE FROM users WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        }
    }

    // Vytvoření instance třídy KomentModel s připojením k databázi
    $userModel = new UserModel($conn);
    $users = $userModel->fetchAll();

    // Mazání knihy
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
        $user_id = intval($_POST['user_id']);
        if ($userModel->delete($user_id)) {
            header('Location: usersEdit.php');
            exit;
        } else {
            echo "Failed to delete koment$user_id.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Výpis komentářů</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/my-styles.css" rel="stylesheet" />
    </head>
    <body class="bg-dark text-white">
        <?php
            $navPath = __DIR__ . '/include/navigation.php';
            if (file_exists($navPath) && is_readable($navPath)) {
                include $navPath;
            } else {
                echo 'Navigace není dostupná.';
            }
        ?>

        <!-- Page Content-->
        <div class="container mx-5 px-4 px-lg-5 mt-10">
            <h2>Výpis uživatelů z tabulky "users"</h2>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jméno</th>
                        <th>Příjmení</th>
                        <th>Přezdívka</th>
                        <th>Email</th>
                        <th>Heslo</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['user_id']) ?></td>
                            <td><?= htmlspecialchars($user['first_name']) ?></td>
                            <td><?= htmlspecialchars($user['last_name']) ?></td>
                            <td><?= htmlspecialchars($user['nickname']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['password']) ?></td>
                            <td><?= htmlspecialchars($user['admin']) ?></td>
                            <td>
                                <a href="userEditItem.php?id=<?= $user['user_id'] ?>" class="btn btn-primary">Edit</a>
                                <form action="usersEdit.php" method="post" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger mt-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>        
                </tbody>
            </table>    
            
        </div>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy;  Neutopia kapela 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>