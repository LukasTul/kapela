<?php
// Zahrnutí souboru pro připojení k databázi
require_once 'include/dbConnection.php';

// Třída pro manipulaci s uživateli
class Koment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Metoda pro vložení nového uživatele do databáze
    
     public function registerKoment($kapela_porovnani, $oblibene_skladby, $hudebni_zanr,$styl, $zazitek_koncert, $hodnoceni, $doporuceni_str, $obrazek) {
        // Připravení dotazu
        $query = "INSERT INTO hodnoceni (kapela_porovnani, oblibene_skladby, hudebni_zanr, styl, zazitek_koncert, hodnoceni, doporuceni, obrazek, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
    
        // Příprava a provedení dotazu
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssiss", $kapela_porovnani, $oblibene_skladby, $hudebni_zanr, $styl, $zazitek_koncert, $hodnoceni, $doporuceni_str, $obrazek);
    
        // Pokud se dotaz úspěšně provede, vrať TRUE, jinak FALSE
        return $stmt->execute();
    } 
}

// Inicializace objektu koment s připojením k databázi
$koment = new Koment($conn); // $conn je připojení k databázi z dbConnection.php

// Zkontrolujeme, zda byl formulář odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Načtení hodnot z formuláře
    $kapela_porovnani = htmlspecialchars($_POST['kapela_porovnani']);
    $oblibene_skladby = htmlspecialchars($_POST['oblibene_skladby']);
    $hudebni_zanr = htmlspecialchars($_POST['hudebni_zanr']);
    $styl = htmlspecialchars($_POST['styl']);
    $zazitek_koncert = htmlspecialchars($_POST['zazitek_koncert']);
    $hodnoceni = htmlspecialchars($_POST['hodnoceni']);
    
    
    
    if (isset($_POST['doporuceni']) && is_array($_POST['doporuceni'])) {
        $doporuceni = array_map('htmlspecialchars', $_POST['doporuceni']);
        $doporuceni_str = implode(",", $doporuceni); // Convert array to string
    } else {
        $doporuceni_str = "";
    }
    
    //$xxx = htmlspecialchars($_POST['xxx']);
    
    // Zpracování nahraného obrázku
    $obrazek = "";
    if (isset($_FILES['obrazek']) && $_FILES['obrazek']['error'] == 0) {
        $targetDir = "assets/img-koment/";
        $obrazek = $targetDir . basename($_FILES["obrazek"]["name"]);
        if (!move_uploaded_file($_FILES["obrazek"]["tmp_name"], $obrazek)) {
            $obrazek = "";
        }
    }

    // Volání metody pro registraci uživatele
    if ($koment->registerKoment($kapela_porovnani, $oblibene_skladby, $hudebni_zanr,$styl, $zazitek_koncert, $hodnoceni, $doporuceni_str, $obrazek)) {
        $registrationMessage = "Komentář byl úspěšně uložen do DB.";
    }  else {
        $registrationMessage = "Uložení komentáře selhalo.";
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
        <title>Uložení komentáře</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/my-styles.css" rel="stylesheet" />
    </head>
    <body class="text-white-50 bg-dark">
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
            <h2 class="text-white">Uložení komentáře do DB</h2>
            <p><?php echo $registrationMessage; ?></p>
            <a href="./index.php" class="btn btn-primary">Zpět na hlavní stránku</a>
        </div>
        <!-- Footer-->
        <footer class="sticky-footer py-5k">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
