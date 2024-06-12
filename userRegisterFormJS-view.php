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
            <h2>Registrační formulář</h2>
            <div class="form-group">
            <label>Jméno:</label>
                <p id="firstName" class="form-control"></p>
            </div>
            <div class="form-group">
                <label>Příjmení:</label>
                <p id="lastName" class="form-control"></p>
            </div>
            <div class="form-group">
                <label>Přezdívka:</label>
                <p id="nickname" class="form-control"></p>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script>
            var params = new URLSearchParams(window.location.search);
            document.getElementById('firstName').textContent = params.get('firstName');
            document.getElementById('lastName').textContent = params.get('lastName');
            document.getElementById('nickname').textContent = params.get('nickname');
        </script>
        
    </body>
</html>
