<?php
//error_reporting(E_ALL & ~E_NOTICE);
session_start(); // Spusť session pro ukládání informací o přihlášeném uživateli
require_once 'UserManager.php'; // Připojení souboru s třídou pro správu uživatelů

// Vytvoření instance třídy UserManager s existujícím připojením k databázi
$userManager = new UserManager($db);

// Zpracování přihlašovacího formuláře
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login_result = $userManager->login($email, $password);
    if ($login_result !== true) {
        // Zobrazit chybové hlášení, pokud přihlášení selže
        echo '<div class="alert alert-danger">' . $login_result . '</div>';
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
            <h2>Přihlášení uživatele</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:*</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Heslo:*</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Přihlásit se</button>
            </form>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Neutopia Kapela 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script>
            document.querySelector('form').onsubmit = function(event) {
                var password = document.getElementById('password').value;
                var confirmPassword = document.getElementById('confirmPassword').value;
                if (password !== confirmPassword) {
                    alert('Hesla se neshodují!');
                    event.preventDefault(); // Zabránit odeslání formuláře
                }
            };
        </script>
    </body>
</html>
