<?php
    session_start(); // Spusť session pro zjištění, zda je uživatel přihlášen

    // Zjisti, zda je uživatel přihlášen
    if (isset($_SESSION['user_nickname'])) {
        $user_display = $_SESSION['user_nickname'];
    } else {
        $user_display = 'nepřihlášen';
    }
?>
<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand" href="./index.php">Neutopia</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <!-- <li class="nav-item"><a class="nav-link" href="#about">Jak to vzniklo?</a></li>
                    <li class="nav-item"><a class="nav-link" href="#koncerty">Koncerty</a></li>
                    <li class="nav-item"><a class="nav-link" href="#diskografie">Diskografie</a></li>
                    <li class="nav-item"><a class="nav-link" href="#poradatele">Pro pořadatele</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="#kontakt">Kontakt</a></li>
                    <li class="nav-item"><a class="nav-link" href="userRegisterForm.php">Registrace</a></li>
                    <?php
                    if (isset($_SESSION['user_nickname'])) {
                        $navKomentsString = '<li class="nav-item"><a class="nav-link" href="komentForm.php">Nový komentář</a></li>
                                           <li class="nav-item"><a class="nav-link" href="komentsView.php">Zobrazení komentářů</a></li>
                                           <li class="nav-item"><a class="nav-link" href="komentsEdit.php">Editace komentářů</a></li>';
                        echo $navKomentsString;
                    }    
                    ?>
                    <li class="nav-item"><a class="nav-link" href="userLoginForm.php">Přihlášení</a></li>
                    <li class="nav-item"><a class="nav-link" href="userLogout.php">Odhlášení</a></li>
                    <li class="nav-item"><span class="nav-link text-<?php echo isset($_SESSION['user_nickname']) ? 'success' : 'danger'; ?>"><?php echo $user_display; ?></span></li>
                </ul>
            </div>
        </div>
    </nav>
</body>