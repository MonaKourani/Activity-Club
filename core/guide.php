<?php
class Guide {
    private $conn;
    private $table = 'guides';

    public $email;
    public $name;
    public $dateOfBirth;
    public $profession;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function view() {
        $query = 'SELECT email, name, dateOfBirth, profession FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function edit() {
        $query = 'UPDATE ' . $this->table . ' SET name = :name, dateOfBirth = :dateOfBirth, profession = :profession WHERE email = :email';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':dateOfBirth', $this->dateOfBirth);
        $stmt->bindParam(':profession', $this->profession);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function readSingle() {
        $query = "SELECT * FROM guides WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $guide = $stmt->fetch(PDO::FETCH_ASSOC);

        return $guide;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (email, name, dateOfBirth, profession) VALUES (?, ?, ?, ?)';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->name);
        $stmt->bindParam(3, $this->dateOfBirth);
        $stmt->bindParam(4, $this->profession);

        return $stmt->execute();
    }
}
?>
