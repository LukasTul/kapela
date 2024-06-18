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
    }

    // Vytvoření instance třídy BookModel s připojením k databázi
    $komentModel = new KomentModel($conn);
    $koments = $komentModel->fetchAll();
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/my-styles.css" rel="stylesheet" /> 
    </head>
    <body class="bg-dark text-white-50">
        <?php
            $navPath = __DIR__ . '/include/navigation.php';
            if (file_exists($navPath) && is_readable($navPath)) {
                include $navPath;
            } else {
                echo 'Navigace není dostupná.';
            }
        ?>

        <!-- Page Content-->
        <div class="container px-4 px-lg-5 mt-10">
            <h2 class="mt-3 text-white">Výpis komentářů z tabulky "hodnocení"</h2>
            <table class="table table-striped table-dark text-white-50">
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
        <!-- Initialize DataTables -->
        <script>
            $(document).ready(function () {
                $('.table').DataTable();
            });
        </script>
    </body>
</html>
