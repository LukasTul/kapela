<?php
    // Zahrnutí souboru pro připojení k databázi
    require_once 'include/dbConnection.php';

    class KomentModel {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function fetchAll() {
            $query = "SELECT * FROM hodnoceni";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function delete($id) {
            $query = "DELETE FROM hodnoceni WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }

    // Vytvoření instance třídy BookModel s připojením k databázi
    $komentModel = new KomentModel($conn);
    $koments = $komentModel->fetchAll();

    // Mazání komentáře
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        if ($komentModel->delete($id)) {
            header('Location: KomentsEdit.php');
            exit;
        } else {
            echo "Failed to delete koment$koment.";
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
            <h2>Výpis hodnoceni z tabulky "hodnoceni"</h2>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kapela porovnání</th>
                        <th>Oblíbené skladby</th>
                        <th>Hudební žánr</th>
                        <th>Styl</th>
                        <th>Zážitek z koncertu</th>
                        <th>Hodnocení</th>
                        <th>Doporučení</th>
                        <th>Obrázek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($koments as $koment): ?>
                        <tr>
                            <td><?= htmlspecialchars($koment['id']) ?></td>
                            <td><?= htmlspecialchars($koment['kapela_porovnani']) ?></td>
                            <td><?= htmlspecialchars($koment['oblibene_skladby']) ?></td>
                            <td><?= htmlspecialchars($koment['hudebni_zanr']) ?></td>
                            <td><?= htmlspecialchars($koment['styl']) ?></td>
                            <td><?= htmlspecialchars($koment['zazitek_koncert']) ?></td>
                            <td><?= htmlspecialchars($koment['hodnoceni']) ?></td>
                            <td><?= htmlspecialchars($koment['doporuceni']) ?></td>
                            <td><img src="<?= htmlspecialchars($koment['obrazek']) ?>" alt="<?= htmlspecialchars($koment['id']) ?>" style="width: 100px; height: auto;"></td>
                            <td>
                                <a href="komentsEditItem.php?id=<?= $koment['id'] ?>" class="btn btn-primary">Edit</a>
                                <form action="komentsEdit.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $koment['id'] ?>">
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
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>