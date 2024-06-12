<?php
// Zahrnutí souboru pro připojení k databázi
require_once 'include/dbConnection.php';

// Třída pro manipulaci s uživateli
class Book {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Metoda pro vložení nového uživatele do databáze
    public function registerBook($title, $authors, $main_category, $sub_category, $price, $isbn, $year, $pages, $recommendation, $description, $image) {
        // Připravení dotazu
        $query = "INSERT INTO books (title, authors, main_category, sub_category, price, isbn, year, pages, recommendation, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Příprava a provedení dotazu
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssssss", $title, $authors, $main_category, $sub_category, $price, $isbn, $year, $pages, $recommendation, $description, $image);
                           
        // Pokud se dotaz úspěšně provede, vrať TRUE, jinak FALSE
        return $stmt->execute();
    }
}

// Inicializace objektu Book s připojením k databázi
$book = new Book($conn); // $conn je připojení k databázi z dbConnection.php

// Zkontrolujeme, zda byl formulář odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Načtení hodnot z formuláře
    $title = htmlspecialchars($_POST['title']);
    $authors = htmlspecialchars($_POST['authors']);
    $main_category = htmlspecialchars($_POST['main_category']);
    $sub_category = htmlspecialchars($_POST['sub_category']);
    $price = htmlspecialchars($_POST['price']);
    $isbn = htmlspecialchars($_POST['isbn']);
    $year = htmlspecialchars($_POST['year']);
    $pages = htmlspecialchars($_POST['pages']);
    
    if (isset($_POST['recommendation'])) {
        $recommendation = htmlspecialchars($_POST['recommendation']);
    } else {
        $recommendation = "nebylo zvoleno";
    }
    
    $description = htmlspecialchars($_POST['description']);
    
    //$xxx = htmlspecialchars($_POST['xxx']);
    
    // Zpracování nahraného obrázku
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "assets/images-books/";
        $image = $targetDir . basename($_FILES["image"]["name"]);
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
            $image = "";
        }
    }

    // Volání metody pro registraci uživatele
    if ($book->registerBook($title, $authors, $main_category, $sub_category, $price, $isbn, $year, $pages, $recommendation, $description, $image)) {
        $registrationMessage = "Kniha byla úspěšně uložena do DB.";
    } else {
        $registrationMessage = "Uložení knihy selhalo.";
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
        <title>Uložení knihy</title>
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
            <h2>Uložení knihy do DB</h2>
            <p><?php echo $registrationMessage; ?></p>
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
