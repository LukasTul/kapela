<?php
    session_start(); // Spusť session pro zjištění, zda je uživatel přihlášen

    // Zjisti, zda je uživatel přihlášen
    if (isset($_SESSION['user_nickname'])) {
        $user_display = $_SESSION['user_nickname'];
    } else {
        $user_display = 'nepřihlášen';
    }
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        // Now you can use $userId
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
                    <!--The older vesion of navigation-->
                    <!-- <li class="nav-item"><a class="nav-link" href="#about">Jak to vzniklo?</a></li>
                    <li class="nav-item"><a class="nav-link" href="#koncerty">Koncerty</a></li>
                    <li class="nav-item"><a class="nav-link" href="#diskografie">Diskografie</a></li>
                    <li class="nav-item"><a class="nav-link" href="#poradatele">Pro pořadatele</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="#kontakt">Kontakt</a></li>
                    <?php
                    if (isset($_SESSION['user_nickname'])) {
                        $navKomentsString = '<li class="nav-item"><a class="nav-link" href="komentForm.php">Nový komentář</a></li>
                                           <li class="nav-item"><a class="nav-link" href="komentsView.php">Zobrazení komentářů</a></li>
                                           <li class="nav-item"><a class="nav-link" href="userLogout.php">Odhlášení</a></li>';
                        echo $navKomentsString;
                    }
                    else {
                        echo '<li class="nav-item"><a class="nav-link" href="userLoginForm.php">Přihlášení</a></li>
                         <li class="nav-item"><a class="nav-link" href="userRegisterForm.php">Registrace</a></li>';
                    }
                    if (isset($_SESSION['user_admin']) && $_SESSION['user_admin'] == 1) {
                        echo '<li class="nav-item"><a class="nav-link" href="komentsEdit.php">Editace komentářů</a></li>
                            <li class="nav-item"><a class="nav-link" href="usersEdit.php">Editace profilů</a></li>';
                    } 
                    else {
                        if (isset($_SESSION['user_nickname'])) {
                            echo '<li class="nav-item"><a class="nav-link" href="userEditItem.php?user_id=' . $_SESSION['user_id'] . '">Editace profilu</a></li>';
                        }
                    }
                    ?>
                    <li class="nav-item"><span class="nav-link text-<?php echo isset($_SESSION['user_nickname']) ? 'success' : 'danger'; ?>"><?php echo $user_display; ?></span></li>
                </ul>
            </div>
        </div>
    </nav>
</body>