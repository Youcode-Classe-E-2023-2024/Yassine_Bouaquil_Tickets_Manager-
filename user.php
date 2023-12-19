<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($nom, $prenom, $username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO userss (nom, prenom, username, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $username, $email, $hashedPassword]);
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT id, password FROM userss WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
    
            if (password_verify($password, $user["password"])) {
                $stmt->close();
                return true;
            }
        }
        $stmt->close();
        return false;
    }
    


    public function logout() {
        unset($_SESSION['user']);
    }

    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    public function getCurrentUserId() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
}
?>
