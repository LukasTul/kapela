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
            <form action="bookSaveToDb.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Název knihy:*</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="authors" class="form-label">Autoři knihy (více autorů oddělujte čárkou):*</label>
                    <input type="text" class="form-control" id="authors" name="authors" required>
                </div>
                <div class="mb-3">
                    <label for="main_category" class="form-label">Hlavní kategorie:</label>
                    <select class="form-select" id="main_category" name="main_category">
                        <option selected>Vyberte jednu z možností</option>
                        <option value="beletrie">Beletrie</option>
                        <option value="naučná">Naučná literatura</option>
                        <option value="dětská">Dětská literatura</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sub_category" class="form-label">Subkategorie:</label>
                    <select class="form-select" id="sub_category" name="sub_category">
                        <option selected>Vyberte jednu z možností</option>
                        <option value="romantické">Romantické</option>
                        <option value="historické">Historické</option>
                        <option value="počítačová">Počítačová</option>
                        <option value="fyzikální">Fyzikální</option>
                        <option value="pohádky MŠ">pohádky pro MŠ</option>
                        <option value="pohádky ZŠ">pohádky pro ZŠ</option>
                    </select>
                </div>    
                <div class="mb-3">
                    <label for="price" class="form-label">Cena (desetinná místa oddělujte tečkou):</label>
                    <input type="text" class="form-control" id="price" name="price">
                </div>
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN:</label>
                    <input type="text" class="form-control" id="isbn" name="isbn">
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Rok vydání:</label>
                    <input type="number" class="form-control" id="year" name="year">
                </div>
                <div class="mb-3">
                    <label for="pages" class="form-label">Počet stran:</label>
                    <input type="number" class="form-control" id="pages" name="pages">
                </div>
                <div class="mb-3">
                    <label for="recommendation" class="form-label">Doporučení:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="recommendation1" name="recommendation" value="studenti">
                        <label class="form-check-label" for="recommendation1">Studenti</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="recommendation2" name="recommendation" value="hobíci">
                        <label class="form-check-label" for="recommendation2">Hobíci</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="recommendation3" name="recommendation" value="profesionálové">
                        <label class="form-check-label" for="recommendation3">Profesionálové</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Popis knihy:</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Nahrajte obrázek:</label>
                    <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                </div>    
                <button type="submit" class="btn btn-primary mb-3">Registrovat</button>
            </form>
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
