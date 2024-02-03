<?php
class Message {
    private $conn;
    private $table = 'messages';

    public $id;
    public $name;
    public $email;
    public $message;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET
                    name = :name,
                    email = :email,
                    message = :message';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':message', $this->message);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function view() {
        $query = 'SELECT
            id,
            name,
            email,
            message
            FROM
            ' . $this->table . '
            ORDER BY id DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
