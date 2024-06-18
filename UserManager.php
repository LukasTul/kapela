<?php
require_once 'include/dbConnection.php'; // Připojení k souboru s třídou pro práci s databází

class UserManager {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function login($email, $password) {
        // Ochrana před SQL injection útoky
        $email = $this->db->getConnection()->real_escape_string($email);

        // Dotaz na databázi pro získání uživatele
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = $this->db->getConnection()->query($query);

        if ($result->num_rows == 1) {
            // Uživatel nalezen
            $user = $result->fetch_assoc();
            // Ověření hesla
            if (password_verify($password, $user['password'])) {
                // Heslo je správné, uložení informací o uživateli do session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_nickname'] = $user['nickname'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_admin'] = $user['admin'];
                // Přesměrování na domovskou stránku nebo jinou požadovanou stránku po přihlášení
                header("Location: index.php"); // Uprav 'index.php' podle potřeby
                exit();
            } else {
                // Neplatné přihlašovací údaje
                return "Neplatné přihlašovací údaje.";
            }
        } else {
            // Uživatel nenalezen
            return "Neplatné přihlašovací údaje.";
        }
    }
}
?>