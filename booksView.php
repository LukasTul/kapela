<?php
    // Zahrnutí souboru pro připojení k databázi
    require_once 'include/dbConnection.php';

    class BookModel {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function fetchAll() {
            $query = "SELECT * FROM books";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }

    // Vytvoření instance třídy BookModel s připojením k databázi
    $bookModel = new BookModel($conn);
    $books = $bookModel->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Výpis knih</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/my-styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            $navPath = __DIR__ . '/include/navigation.php';
            if (file_exists($navPath) && is_readable($navPath)) {
                include $navPath;
            } else {
                echo 'Navigace není dostupná.';
            }
        ?>

        <!-- Page Content-->
        <div class="container px-4 px-lg-5">
            <h2 class="mt-3">Výpis knih z tabulky "books"</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Authors</th>
                        <th>Main Category</th>
                        <th>Sub Category</th>
                        <th>Price</th>
                        <th>ISBN</th>
                        <th>Year</th>
                        <th>Pages</th>
                        <th>Recommendation</th>
                        <th>Description</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['book_id']) ?></td>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['authors']) ?></td>
                            <td><?= htmlspecialchars($book['main_category']) ?></td>
                            <td><?= htmlspecialchars($book['sub_category']) ?></td>
                            <td><?= htmlspecialchars($book['price']) ?></td>
                            <td><?= htmlspecialchars($book['isbn']) ?></td>
                            <td><?= htmlspecialchars($book['year']) ?></td>
                            <td><?= htmlspecialchars($book['pages']) ?></td>
                            <td><?= htmlspecialchars($book['recommendation']) ?></td>
                            <td><?= htmlspecialchars($book['description']) ?></td>
                            <td><img src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" style="width: 100px; height: auto;"></td>
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
