<?php
class Book {
 
    private $conn;
    private $table_name = "books";
 
    public $id;
    public $name;
    public $author;
    public $publishing_company;
 
    public function __construct($db) {
        $this->conn = $db;
    }

    function read() {
        $query = "SELECT p.id, p.name, p.author, p.publishing_company FROM " . $this->table_name . " p ORDER BY p.name ASC";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->execute();
    
        return $stmt;
    }

    function readOne() {
        $query = "SELECT p.id, p.name, p.author, p.publishing_company FROM " . $this->table_name . " p WHERE p.id=:id";
    
        $stmt = $this->conn->prepare( $query );
    
        $stmt->bindParam(":id", $this->id);
    
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->author = $row['author'];
        $this->publishing_company = $row['publishing_company'];
    }

    function search($keywords) {
        $query = "SELECT b.id, b.name, b.author, b.publishing_company
                    FROM " . $this->table_name . " b
                WHERE
                    b.name LIKE :keywords OR b.author LIKE :keywords OR b.publishing_company LIKE :keywords
                ORDER BY
                    b.name DESC";
     
        $stmt = $this->conn->prepare($query);
     
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
     
        $stmt->bindParam(":keywords", $keywords);
     
        $stmt->execute();
     
        return $stmt;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, author=:author, publishing_company=:publishing_company";
     
        $stmt = $this->conn->prepare($query);
     
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->publishing_company=htmlspecialchars(strip_tags($this->publishing_company));
     
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":publishing_company", $this->publishing_company);
     
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET
                    name = :name,
                    author = :author,
                    publishing_company = :publishing_company
                WHERE
                    id = :id";
     
        $stmt = $this->conn->prepare($query);
     
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->publishing_company=htmlspecialchars(strip_tags($this->publishing_company));
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':publishing_company', $this->publishing_company);
        $stmt->bindParam(':id', $this->id);
     
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
     
        $stmt = $this->conn->prepare($query);
     
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        $stmt->bindParam(1, $this->id);
     
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>