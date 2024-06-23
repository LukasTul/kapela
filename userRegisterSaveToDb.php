<?php
// Zahrnutí souboru pro připojení k databázi
require_once 'include/dbConnection.php';

// Třída pro manipulaci s uživateli
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Metoda pro vložení nového uživatele do databáze
    public function registerUser($firstName, $lastName, $nickname, $email, $password) {
        // Připravení dotazu
        $query = "INSERT INTO users (first_name, last_name, nickname, email, password, admin) VALUES (?, ?, ?, ?, ?, 0)";

        // Příprava a provedení dotazu
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $firstName, $lastName, $nickname, $email, $password);

        // Pokud se dotaz úspěšně provede, vrať TRUE, jinak FALSE
        return $stmt->execute();
    }
}

// Inicializace objektu User s připojením k databázi
$user = new User($conn); // $conn je připojení k databázi z dbConnection.php

// Zkontrolujeme, zda byl formulář odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Načtení hodnot z formuláře
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $nickname = htmlspecialchars($_POST['nickname']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashování hesla

    // Volání metody pro registraci uživatele
    if ($user->registerUser($firstName, $lastName, $nickname, $email, $password)) {
        $registrationMessage = "Uživatel byl úspěšně registrován.";
    } else {
        $registrationMessage = "Registrace selhala.";
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
        <title>Small Business - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
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
        <div class="container px-4 px-lg-5 mt-10 text-center">
            <h2 class="text-white">Uložení dat do DB</h2>
            <p><?php echo $registrationMessage; ?></p>
        </div>
        <!-- Footer-->
        <footer class="sticky-footer py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Neutopia Kapela 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
