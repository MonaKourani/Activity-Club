<?php
class User{
	private $conn;
	private $table ='members';

	public $email;
	public $name;
	public $password;
	public $dateOfBirth;
	public $gender;
	public $joiningDate;
	public $mobile;
	public $emergencyNumber;
	public $photo;
	public $profession;
	public $nationality;
	public $role;

	public function __construct($db){
		$this->conn = $db;
	}

	public function read(){
		$query = 'SELECT
			email,
			name,
			password,
			dateOfBirth,
			gender,
			joiningDate,
			mobile,
			emergencyNumber,
			photo,
			profession,
			nationality,
			role
			FROM
			'.$this->table.'
			ORDER BY joiningDate DESC';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function checkLogin($email, $password) {
        $query = 'SELECT *
            FROM ' . $this->table . '
            WHERE email = :email
            AND password = :password';

        $stmt = $this->conn->prepare($query);

        $email = htmlspecialchars(strip_tags($email));
        $password = htmlspecialchars(strip_tags($password));

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->email = $row['email'];
            $this->name = $row['name'];
            $this->dateOfBirth = $row['dateOfBirth'];
            $this->gender = $row['gender'];
            $this->joiningDate = $row['joiningDate'];
            $this->mobile = $row['mobile'];
            $this->emergencyNumber = $row['emergencyNumber'];
            $this->photo = $row['photo'];
            $this->profession = $row['profession'];
            $this->nationality = $row['nationality'];
            $this->role = $row['role'];

            return true;
        } else {
            return false;
        }
    }
	public function readSingle() {
        $query = 'SELECT
            email,
            name,
            password,
            dateOfBirth,
            gender,
            joiningDate,
            mobile,
            emergencyNumber,
            photo,
            profession,
            nationality,
            role
            FROM
            ' . $this->table . '
            WHERE email = ?
            LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->email = $row['email'];
            $this->name = $row['name'];
            $this->password = $row['password'];
            $this->dateOfBirth = $row['dateOfBirth'];
            $this->gender = $row['gender'];
            $this->joiningDate = $row['joiningDate'];
            $this->mobile = $row['mobile'];
            $this->emergencyNumber = $row['emergencyNumber'];
            $this->photo = $row['photo'];
            $this->profession = $row['profession'];
            $this->nationality = $row['nationality'];
            $this->role = $row['role'];
        } else {
            $this->email = null;
            $this->name = null;
            $this->password = null;
            $this->dateOfBirth = null;
            $this->gender = null;
            $this->joiningDate = null;
            $this->mobile = null;
            $this->emergencyNumber = null;
            $this->photo = null;
            $this->profession = null;
            $this->nationality = null;
            $this->role = null;
        }
    }


	public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET
                    email = :email,
                    name = :name,
                    password = :password,
                    dateOfBirth = :dateOfBirth,
                    gender = :gender,
                    joiningDate = :joiningDate,
                    mobile = :mobile,
                    emergencyNumber = :emergencyNumber,
                    photo = :photo,
                    profession = :profession,
                    nationality = :nationality,
                    role = :role';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':dateOfBirth', $this->dateOfBirth);
        $stmt->bindParam(':gender', $this->gender);

        $joiningDate = date('Y-m-d');
        $stmt->bindParam(':joiningDate', $joiningDate);

        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':emergencyNumber', $this->emergencyNumber);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':profession', $this->profession);
        $stmt->bindParam(':nationality', $this->nationality);

        $role = 0;
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

	public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                SET
                    name = :name,
                    password = :password,
                    dateOfBirth = :dateOfBirth,
                    gender = :gender,
                    mobile = :mobile,
                    emergencyNumber = :emergencyNumber,
                    photo = :photo,
                    profession = :profession,
                    nationality = :nationality,
                    role = :role,
                    joiningDate = :joiningDate
                WHERE
                    email = :email';

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->dateOfBirth = htmlspecialchars(strip_tags($this->dateOfBirth));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->emergencyNumber = htmlspecialchars(strip_tags($this->emergencyNumber));
        $this->photo = htmlspecialchars(strip_tags($this->photo));
        $this->profession = htmlspecialchars(strip_tags($this->profession));
        $this->nationality = htmlspecialchars(strip_tags($this->nationality));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->joiningDate = htmlspecialchars(strip_tags($this->joiningDate));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':dateOfBirth', $this->dateOfBirth);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':emergencyNumber', $this->emergencyNumber);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':profession', $this->profession);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':joiningDate', $this->joiningDate);
        $stmt->bindParam(':email', $this->email);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }


    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':email', $this->email);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin() {
        $query = 'SELECT role FROM '. $this->table .' WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return $row['role'] == 1;
        } else {
            return false;
        }
    }
}

?>