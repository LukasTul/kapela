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
        <div class="container  px-4 px-lg-5 mt-10">
            <h2>Uložení komentáře do DB</h2>
            <form action="komentSaveToDb.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="kapela_porovnani" class="form-label">K jaké kapele by si nás přirovnal/a?</label>
                    <input type="text" class="form-control" id="kapela_porovnani" name="kapela_porovnani" required>
                </div>
                <div class="mb-3">
                    <label for="oblibene_skladby" class="form-label">Oblíbené skladby (odděluj čárkou):</label>
                    <input type="text" class="form-control" id="oblibene_skladby" name="oblibene_skladby" required>
                </div>
                <div class="mb-3">
                    <label for="hudebni_zanr" class="form-label">Tvůj oblíbený hudební žánr:</label>
                    <select class="form-select" id="hudebni_zanr" name="hudebni_zanr">
                        <option selected>Vyberte jednu z možností</option>
                        <option value="rock">Rock</option>
                        <option value="pop">Pop</option>
                        <option value="jazz">Jazz</option>
                        <option value="elektronicka">Elektronická</option>
                        <option value="klasicka">Klasická</option>
                    </select>
                </div>    
                <div class="mb-3">
                <label for="styl" class="form-label">Tvůj oblíbený styl:</label>
                <select class="form-select" id="styl" name="styl">
                    <!-- Options will be populated based on the selected hudebni_zanr -->
                </select>
                </div>
                <div class="mb-3">
                    <label for="zazitek_koncert" class="form-label">Jak se ti líbil náš poslední koncert?</label>
                    <textarea class="form-control" id="zazitek_koncert" name="zazitek_koncert" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="hodnoceni" class="form-label">Hodnocení (1-10):</label>
                    <input type="number" class="form-control" id="hodnoceni" name="hodnoceni" min="1" max="10">
                </div>
                <div class="mb-3">
                    <label for="doporuceni" class="form-label">Komu bys nás doporučili?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="doporuceni1" name="doporuceni[]" value="přátelé">
                        <label class="form-check-label" for="doporuceni1">Přátelé</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="doporuceni2" name="doporuceni[]" value="rodina">
                        <label class="form-check-label" for="doporuceni2">Rodina</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="doporuceni3" name="doporuceni[]" value="kolegové">
                        <label class="form-check-label" for="doporuceni3">Kolegové</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="obrazek" class="form-label">Nahrajte svůj obrázek z koncertu:</label>
                    <input class="form-control" type="file" id="formFile" name="obrazek" accept="image/*">
                </div>    
                <button type="submit" class="btn btn-primary mb-3">Odeslat hodnocení</button>
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
                function updateStylOptions() {
                var hudebni_zanr = document.getElementById('hudebni_zanr').value;
                var stylSelect = document.getElementById('styl');

                // Clear existing options
                stylSelect.innerHTML = '';

                var options = [];

                // Define the options based on the selected hudebni_zanr
                if (hudebni_zanr === 'rock') {
                    options = ['Hard Rock', 'Soft Rock', 'Alternative Rock'];
                } else if (hudebni_zanr === 'pop') {
                    options = ['Dance Pop', 'Pop Rock', 'Teen Pop'];
                } else if (hudebni_zanr === 'jazz') {
                    options = ['Smooth Jazz', 'Free Jazz', 'Bebop'];
                } else if (hudebni_zanr === 'elektronicka') {
                    options = ['House', 'Techno', 'Trance'];
                } else if (hudebni_zanr === 'klasicka') {
                    options = ['Symphony', 'Sonata', 'Concerto'];
                }

                // Create and append the options
                for (var i = 0; i < options.length; i++) {
                    var option = document.createElement('option');
                    option.value = options[i];
                    option.text = options[i];
                    stylSelect.appendChild(option);
                }
            }
            // Call updateStylOptions when hudebni_zanr changes
            document.getElementById('hudebni_zanr').onchange = updateStylOptions;   
        </script>
    </body>
</html>
