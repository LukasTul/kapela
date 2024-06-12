<?php
require_once 'include/dbConnection.php';

class BookModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchById($book_id) {
        $query = "SELECT * FROM books WHERE book_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($book_id, $title, $authors, $main_category, $sub_category, $price, $isbn, $year, $pages, $recommendation, $description, $image) {
        $query = "UPDATE books SET title = ?, authors = ?, main_category = ?, sub_category = ?, price = ?, isbn = ?, year = ?, pages = ?, recommendation = ?, description = ?, image = ? WHERE book_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssdsiisssi", $title, $authors, $main_category, $sub_category, $price, $isbn, $year, $pages, $recommendation, $description, $image, $book_id);
        return $stmt->execute();
    }
}

$bookModel = new BookModel($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = intval($_POST['book_id']);
    $title = $_POST['title'];
    $authors = $_POST['authors'];
    $main_category = $_POST['main_category'];
    $sub_category = $_POST['sub_category'];
    $price = floatval($_POST['price']);
    $isbn = $_POST['isbn'];
    $year = intval($_POST['year']);
    $pages = intval($_POST['pages']);
    $recommendation = isset($_POST['recommendation']) ? implode(", ", $_POST['recommendation']) : "";
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $book = $bookModel->fetchById($book_id);
        $image = $book['image'];
    }

    if ($bookModel->update($book_id, $title, $authors, $main_category, $sub_category, $price, $isbn, $year, $pages, $recommendation, $description, $image)) {
        header('Location: booksEdit.php');
        exit;
    } else {
        echo "Failed to update book.";
    }
} else {
    if (isset($_GET['book_id'])) {
        $book_id = intval($_GET['book_id']);
        $book = $bookModel->fetchById($book_id);
    } else {
        echo "No book ID provided.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/my-styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h2>Edit Book</h2>
        <form action="booksEditItem.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Název knihy:*</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="authors" class="form-label">Autoři knihy (více autorů oddělujte čárkou):*</label>
                <input type="text" class="form-control" id="authors" name="authors" value="<?= htmlspecialchars($book['authors']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="main_category" class="form-label">Hlavní kategorie:</label>
                <select class="form-select" id="main_category" name="main_category">
                    <option>Vyberte jednu z možností</option>
                    <option value="beletrie" <?= $book['main_category'] == 'beletrie' ? 'selected' : '' ?>>Beletrie</option>
                    <option value="naučná" <?= $book['main_category'] == 'naučná' ? 'selected' : '' ?>>Naučná literatura</option>
                    <option value="dětská" <?= $book['main_category'] == 'dětská' ? 'selected' : '' ?>>Dětská literatura</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sub_category" class="form-label">Subkategorie:</label>
                <select class="form-select" id="sub_category" name="sub_category">
                    <option>Vyberte jednu z možností</option>
                    <option value="romantické" <?= $book['sub_category'] == 'romantické' ? 'selected' : '' ?>>Romantické</option>
                    <option value="historické" <?= $book['sub_category'] == 'historické' ? 'selected' : '' ?>>Historické</option>
                    <option value="počítačová" <?= $book['sub_category'] == 'počítačová' ? 'selected' : '' ?>>Počítačová</option>
                    <option value="fyzikální" <?= $book['sub_category'] == 'fyzikální' ? 'selected' : '' ?>>Fyzikální</option>
                    <option value="pohádky MŠ" <?= $book['sub_category'] == 'pohádky MŠ' ? 'selected' : '' ?>>Pohádky pro MŠ</option>
                    <option value="pohádky ZŠ" <?= $book['sub_category'] == 'pohádky ZŠ' ? 'selected' : '' ?>>Pohádky pro ZŠ</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Cena (desetinná místa oddělujte tečkou):</label>
                <input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($book['price']) ?>">
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>">
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Rok vydání:</label>
                <input type="number" class="form-control" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>">
            </div>
            <div class="mb-3">
                <label for="pages" class="form-label">Počet stran:</label>
                <input type="number" class="form-control" id="pages" name="pages" value="<?= htmlspecialchars($book['pages']) ?>">
            </div>
            <div class="mb-3">
                <label for="recommendation" class="form-label">Doporučení:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="recommendation1" name="recommendation[]" value="studenti" <?= strpos($book['recommendation'], 'studenti') !== false ? 'checked' : '' ?>>
                    <label class="form-check-label" for="recommendation1">Studenti</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="recommendation2" name="recommendation[]" value="hobíci" <?= strpos($book['recommendation'], 'hobíci') !== false ? 'checked' : '' ?>>
                    <label class="form-check-label" for="recommendation2">Hobíci</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="recommendation3" name="recommendation[]" value="profesionálové" <?= strpos($book['recommendation'], 'profesionálové') !== false ? 'checked' : '' ?>>
                    <label class="form-check-label" for="recommendation3">Profesionálové</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Popis knihy:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($book['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Nahrajte obrázek:</label>
                <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary mb-3">Aktualizovat</button>
        </form>
    </div>
</body>
</html>