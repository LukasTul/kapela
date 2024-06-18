<?php
require_once 'include/dbConnection.php';

class ComentModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchById($id) {
        $query = "SELECT * FROM hodnoceni WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $kapela_porovnani, $oblibene_skladby, $hudebni_zanr,$styl, $zazitek_koncert, $hodnoceni, $doporuceni, $obrazek) {
        $query = "UPDATE hodnoceni SET kapela_porovnani = ?, oblibene_skladby = ?, hudebni_zanr = ?, styl = ?, zazitek_koncert = ?, hodnoceni = ?, doporuceni = ?, obrazek = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssssssi", $kapela_porovnani, $oblibene_skladby, $hudebni_zanr,$styl, $zazitek_koncert, $hodnoceni, $doporuceni, $obrazek, $id);
        return $stmt->execute();
    }
}

$comentModel = new ComentModel($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $kapela_porovnani = $_POST['kapela_porovnani'];
    $oblibene_skladby = $_POST['oblibene_skladby'];
    $hudebni_zanr = $_POST['hudebni_zanr'];
    $styl = $_POST['styl'];
    $zazitek_koncert = $_POST['zazitek_koncert'];
    $hodnoceni = intval($_POST['hodnoceni']);
    $doporuceni = isset($_POST['doporuceni']) ? implode(", ", $_POST['doporuceni']) : "";
    $obrazek = $_FILES['obrazek']['name'];

    if ($obrazek) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["obrazek"]["name"]);
        move_uploaded_file($_FILES["obrazek"]["tmp_name"], $target_file);
    } else {
        $koment = $comentModel->fetchById($id);
        $obrazek = $koment['obrazek'];
    }

    if ($comentModel->update($id, $kapela_porovnani, $oblibene_skladby, $hudebni_zanr,$styl, $zazitek_koncert, $hodnoceni, $doporuceni, $obrazek)) {
        header('Location: komentsEdit.php');
        exit;
    } else {
        echo "Failed to update koment.";
    }
    } else {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $koment = $comentModel->fetchById($id);
        } else {
            echo "No koment ID provided.";
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Coment</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/my-styles.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="bg-dark text-white-50">
    <div class="container">
        <h2 class="text-white">Edit Coment</h2>
        <form action="komentsEditItem.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($koment['id']) ?>">
            <div class="mb-3">
                <label for="kapela_porovnani" class="form-label">K jaké kapele by si nás přirovnal/a?</label>
                <input type="text" class="form-control" id="kapela_porovnani" name="kapela_porovnani" value="<?= htmlspecialchars($koment['kapela_porovnani']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="oblibene_skladby" class="form-label">Oblíbené skladby (odděluj čárkou):</label>
                <input type="text" class="form-control" id="oblibene_skladby" name="oblibene_skladby" value="<?= htmlspecialchars($koment['oblibene_skladby']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="hudebni_zanr" class="form-label">Tvůj oblíbený hudební žánr:</label>
                <select class="form-select" id="hudebni_zanr" name="hudebni_zanr">
                    <option>Vyberte jednu z možností</option>
                    <option value="rock" <?= $koment['hudebni_zanr'] == 'rock' ? 'selected' : '' ?>>Rock</option>
                    <option value="pop" <?= $koment['hudebni_zanr'] == 'pop' ? 'selected' : '' ?>>Pop</option>
                    <option value="jazz" <?= $koment['hudebni_zanr'] == 'jazz' ? 'selected' : '' ?>>Jazz</option>
                    <option value="elektronicka" <?= $koment['hudebni_zanr'] == 'elektronicka' ? 'selected' : '' ?>>Elektronická</option>
                    <option value="klasicka" <?= $koment['hudebni_zanr'] == 'klasicka' ? 'selected' : '' ?>>Klasická</option>
                </select>
            </div>
                <label for="styl" class="form-label">Tvůj oblíbený styl:</label>
                <select class="form-select" id="styl" name="styl">
                    <?php
                    $options = [];
                    if ($koment['hudebni_zanr'] === 'rock') {
                        $options = ['Hard Rock', 'Soft Rock', 'Alternative Rock'];
                    } else if ($koment['hudebni_zanr'] === 'pop') {
                        $options = ['Dance Pop', 'Pop Rock', 'Teen Pop'];
                    } else if ($koment['hudebni_zanr'] === 'jazz') {
                        $options = ['Smooth Jazz', 'Free Jazz', 'Bebop'];
                    } else if ($koment['hudebni_zanr'] === 'elektronicka') {
                        $options = ['House', 'Techno', 'Trance'];
                    } else if ($koment['hudebni_zanr'] === 'klasicka') {
                        $options = ['Symphony', 'Sonata', 'Concerto'];
                    }

                    foreach ($options as $option) {
                        $selected = $koment['styl'] == $option ? 'selected' : '';
                        echo "<option value=\"$option\" $selected>$option</option>";
                    }
                    ?>
                </select>
            <div class="mb-3">
                <label for="zazitek_koncert" class="form-label">Jak se ti líbil náš poslední koncert?</label>
                <textarea class="form-control" id="zazitek_koncert" name="zazitek_koncert" rows="3"><?= htmlspecialchars($koment['zazitek_koncert']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="hodnoceni" class="form-label">Hodnocení (1-10):</label>
                <input type="number" class="form-control" id="hodnoceni" name="hodnoceni" min="1" max="10" value="<?= htmlspecialchars($koment['hodnoceni']) ?>">
            </div>
            <div class="mb-3">
                <label for="doporuceni" class="form-label">Komu bys nás doporučili?</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doporuceni1" name="doporuceni[]" value="přátelé" <?= strpos($koment['doporuceni'], 'přátelé') !== false ? 'checked' : '' ?>>
                    <label class="form-check-label" for="doporuceni1">Přátelé</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doporuceni2" name="doporuceni[]" value="rodina" <?= strpos($koment['doporuceni'], 'rodina') !== false ? 'checked' : '' ?>>
                    <label class="form-check-label" for="doporuceni2">Rodina</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doporuceni3" name="doporuceni[]" value="kolegové" <?= strpos($koment['doporuceni'], 'kolegové') !== false ? 'checked' : '' ?>>
                    <label class="form-check-label" for="doporuceni3">Kolegové</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="obrazek" class="form-label">Nahrajte obrázek:</label>
                <input class="form-control" type="file" id="formFile" name="obrazek" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary mb-3">Aktualizovat</button>
        </form>
    </div>
    <script>
    $(document).ready(function() {
        $('#hudebni_zanr').change(function() {
            var genre = $(this).val();
            var options = [];
            if (genre === 'rock') {
                options = ['Hard Rock', 'Soft Rock', 'Alternative Rock'];
            } else if (genre === 'pop') {
                options = ['Dance Pop', 'Pop Rock', 'Teen Pop'];
            } else if (genre === 'jazz') {
                options = ['Smooth Jazz', 'Free Jazz', 'Bebop'];
            } else if (genre === 'elektronicka') {
                options = ['House', 'Techno', 'Trance'];
            } else if (genre === 'klasicka') {
                options = ['Symphony', 'Sonata', 'Concerto'];
            }

            var $styl = $('#styl');
            $styl.empty();
            $.each(options, function(index, option) {
                $styl.append($('<option></option>').attr('value', option).text(option));
            });
        });
    });
    </script>
</body>
</html>
