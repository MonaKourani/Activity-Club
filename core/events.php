<?php
class Event {
    private $conn;
    private $table = 'events';

    public $eventid;
    public $description;
    public $destination;
    public $dateFrom;
    public $dateTo;
    public $status;
    public $guides;
    public $categories;
    public $photo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT
            e.eventid,
            e.description,
            e.destination,
            e.dateFrom,
            e.dateTo,
            e.status,
            e.photo,
            GROUP_CONCAT(DISTINCT l.name SEPARATOR ", ") as categories,
            GROUP_CONCAT(DISTINCT g.name SEPARATOR ", ") as guides
            FROM
            ' . $this->table . ' e
            LEFT JOIN lookups l ON e.eventid = l.eventid
            LEFT JOIN guideevents ge ON e.eventid = ge.eventid
            LEFT JOIN guides g ON ge.guide = g.email
            GROUP BY e.eventid
            ORDER BY e.dateFrom DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT
            e.eventid,
            e.description,
            e.destination,
            e.dateFrom,
            e.dateTo,
            e.status,
            e.photo,
            GROUP_CONCAT(DISTINCT l.name SEPARATOR ", ") as categories,
            GROUP_CONCAT(DISTINCT g.name SEPARATOR ", ") as guides
            FROM
            ' . $this->table . ' e
            LEFT JOIN lookups l ON e.eventid = l.eventid
            LEFT JOIN guideevents ge ON e.eventid = ge.eventid
            LEFT JOIN guides g ON ge.guide = g.email
            WHERE e.eventid = ?
            GROUP BY e.eventid';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->eventid);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->eventid = $row['eventid'];
            $this->description = $row['description'];
            $this->destination = $row['destination'];
            $this->dateFrom = $row['dateFrom'];
            $this->dateTo = $row['dateTo'];
            $this->status = $row['status'];
            $this->categories = $row['categories'];
            $this->guides = $row['guides'];
            $this->photo = $row['photo'];
        } else {
            $this->eventid = null;
            $this->description = null;
            $this->destination = null;
            $this->dateFrom = null;
            $this->dateTo = null;
            $this->status = null;
            $this->categories = null;
            $this->guides = null;
            $this->photo = null;
        }
    }

    public function readBrief() {
        $query = 'SELECT
            e.eventid,
            e.description,
            e.status,
            e.photo
            FROM
            ' . $this->table . ' e
            ORDER BY e.dateFrom DESC';
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET
                    description = :description,
                    destination = :destination,
                    dateFrom = :dateFrom,
                    dateTo = :dateTo,
                    status = :status,
                    photo = :photo';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':destination', $this->destination);
        $stmt->bindParam(':dateFrom', $this->dateFrom);
        $stmt->bindParam(':dateTo', $this->dateTo);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':photo', $this->photo);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function edit() {
        $query = 'UPDATE ' . $this->table . '
            SET
                description = :description,
                destination = :destination,
                dateFrom = :dateFrom,
                dateTo = :dateTo,
                status = :status,
                photo = :photo
            WHERE
                eventid = :eventid';

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':eventid', $this->eventid);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':destination', $this->destination);
    $stmt->bindParam(':dateFrom', $this->dateFrom);
    $stmt->bindParam(':dateTo', $this->dateTo);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':photo', $this->photo);

    if ($stmt->execute()) {
        $this->updateCategoriesInLookups($this->eventid, $this->categories);
        $this->updateGuidesInEvent($this->eventid, $this->guides);

        return true;
    } else {
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE eventid = :eventid';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':eventid', $this->eventid);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function updateGuidesInEvent($eventid, $guides) {
        $this->removeGuidesFromEvent($eventid);

        $guidesArray = explode(', ', $guides);
        foreach ($guidesArray as $guide) {
            $this->addGuideToEvent($eventid, $guide);
        }
    }

    private function removeGuidesFromEvent($eventid) {
        $query = 'DELETE FROM guideevents WHERE eventid = :eventid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eventid', $eventid);
        $stmt->execute();
    }

    public function addCategoryToLookups($eventid, $category) {
        $query = 'INSERT INTO lookups (eventid, name) VALUES (:eventid, :category)';
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':eventid', $eventid);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
    }
    public function addGuideToEvent($eventID, $guideEmail) {
        $query = 'INSERT INTO guideevents (eventid, guide) VALUES (:eventid, :guide)';
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':eventid', $eventID);
        $stmt->bindParam(':guide', $guideEmail);
    
        return $stmt->execute();
    }
    public function updateCategoriesInLookups($eventid, $categories) {
        $this->removeCategoriesFromLookups($eventid);

        $categoriesArray = explode(', ', $categories);
        foreach ($categoriesArray as $category) {
            $this->addCategoryToLookups($eventid,$category);
        }
    }
    private function removeCategoriesFromLookups($eventid) {
        $query = 'DELETE FROM lookups WHERE eventid = :eventid';
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eventid', $eventid);
        $stmt->execute();
    }

    public function enroll($userEmail, $eventID) {
        $checkQuery = 'SELECT COUNT(*) FROM memberinevents WHERE email = :user_email AND eventId = :eventid';
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':user_email', $userEmail);
        $checkStmt->bindParam(':eventid', $eventID);
        $checkStmt->execute();

        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            return array('message' => 'User is already enrolled in the event.');
        }

        $insertQuery = 'INSERT INTO memberinevents (email, eventId) VALUES (:user_email, :eventid)';
        $insertStmt = $this->conn->prepare($insertQuery);
        $insertStmt->bindParam(':user_email', $userEmail);
        $insertStmt->bindParam(':eventid', $eventID);

        if ($insertStmt->execute()) {
            return array('message' => 'Enrollment successful.');
        } else {
            return array('message' => 'Enrollment failed.');
        }
    }
    public function getEnrolledEvents($userEmail) {
        $query = 'SELECT
                    e.eventid,
                    e.description,
                    e.destination,
                    e.dateFrom,
                    e.dateTo,
                    e.status,
                    e.photo,
                    GROUP_CONCAT(DISTINCT l.name SEPARATOR ", ") as categories,
                    GROUP_CONCAT(DISTINCT g.name SEPARATOR ", ") as guides
                  FROM
                    events e
                    JOIN memberinevents me ON e.eventid = me.eventId
                    LEFT JOIN lookups l ON e.eventid = l.eventid
                    LEFT JOIN guideevents ge ON e.eventid = ge.eventid
                    LEFT JOIN guides g ON ge.guide = g.email
                  WHERE
                    me.email = :user_email
                  GROUP BY
                    e.eventid
                  ORDER BY
                    e.dateFrom DESC';
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_email', $userEmail);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function unenroll($userEmail, $eventID) {
        $query = 'DELETE FROM memberinevents WHERE email = :user_email AND eventId = :eventid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_email', $userEmail);
        $stmt->bindParam(':eventid', $eventID);
    
        if ($stmt->execute()) {
            return array('message' => 'Unenrollment successful.');
        } else {
            return array('message' => 'Unenrollment failed.');
        }
    }
    public function getEnrolledUsers($eventid) {
        $query = "SELECT members.email, members.name
          FROM members
          INNER JOIN memberinevents ON members.email = memberinevents.email
          WHERE memberinevents.eventid = :eventid";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eventid', $eventid);
        $stmt->execute();

        $enrolledUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $enrolledUsers;
    }
    
}
?>
