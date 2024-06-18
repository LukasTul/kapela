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
    <body class="bg-dark">
        <?php
            $navPath = __DIR__ . '/include/navigation.php';
            if (file_exists($navPath) && is_readable($navPath)) {
                include $navPath;
            } else {
                echo 'Navigace není dostupná.';
            }
        ?>

        <!-- Page Content-->
        <div class="container mt-10 text-white-50 px-4 px-lg-5 mt-10">
            <h2>Registrační formulář</h2>
            <form action="userRegisterSaveToDb.php" method="POST">
                <div class="mb-3">
                    <label for="firstName" class="form-label">Jméno:*</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Příjmení:*</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                <div class="mb-3">
                    <label for="nickname" class="form-label">Přezdívka:*</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:*</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                <label for="password" class="form-label">Heslo:*</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" pattern="^(?=.*[A-Z])(?=.*\d).{8,}$" title="Heslo musí mít minimálně 8 znaků, alespoň jedno velké písmeno a alespoň jedno číslo." required>
                    <button type="button" class="btn btn-primary btn-outline-secondary" onclick="togglePasswordVisibility('password')"><i class="bi bi-eye-slash" id="togglePassword"></i>🔑</button>
                </div>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Potvrzení hesla:*</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        <button type="button" class="btn btn-primary btn-outline-secondary" onclick="togglePasswordVisibility('confirmPassword')"><i class="bi bi-eye-slash" id="toggleConfirmPassword"></i>🔑</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Registrovat</button>
            </form>
        </div>
        <!-- Footer-->
        <footer class="py-5">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Neutopia kapela 2024</p></div>
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
            function togglePasswordVisibility(id) {
                var passwordField = document.getElementById(id);
                var toggleIcon = document.getElementById('toggle' + id.charAt(0).toUpperCase() + id.slice(1));
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    toggleIcon.classList.remove('bi-eye-slash');
                    toggleIcon.classList.add('bi-eye');
                } else {
                    passwordField.type = "password";
                    toggleIcon.classList.remove('bi-eye');
                    toggleIcon.classList.add('bi-eye-slash');
                }
            }
        </script>
    </body>
</html>
