<?php
    session_start(); // Spusť session pro zjištění, zda je uživatel přihlášen

    // Zjisti, zda je uživatel přihlášen
    if (isset($_SESSION['user_nickname'])) {
        $user_display = $_SESSION['user_nickname'];
    } else {
        $user_display = 'nepřihlášen';
    }
?>



<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="index.php">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.html">Home</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Services</a></li> -->
                <li class="nav-item"><a class="nav-link" href="userRegisterForm.php">Registrace</a></li>
                <li class="nav-item"><a class="nav-link" href="dataTablesUkazka.php">DataTables</a></li>
                
                <?php
                    if (isset($_SESSION['user_nickname'])) {
                        $navBooksString = '<li class="nav-item"><a class="nav-link" href="bookForm.php">Nová kniha</a></li>
                                           <li class="nav-item"><a class="nav-link" href="booksView.php">Zobrazení knih</a></li>
                                           <li class="nav-item"><a class="nav-link" href="booksEdit.php">Editace knih</a></li>';
                        echo $navBooksString;
                    }    
                ?>
                


                <li class="nav-item"><a class="nav-link" href="userLoginForm.php">Přihlášení</a></li>
                <li class="nav-item"><a class="nav-link" href="userLogout.php">Odhlášení</a></li>
                
                <li class="nav-item"><span class="nav-link text-<?php echo isset($_SESSION['user_nickname']) ? 'success' : 'danger'; ?>"><?php echo $user_display; ?></span></li>
            </ul>
        </div>
    </div>
</nav>