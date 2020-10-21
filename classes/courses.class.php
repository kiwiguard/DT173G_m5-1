<?php 

class Courses extends Database { 

    private $conn; 

    //Course properties
    public $id;
    public $name;
    public $code;
    public $progression;
    public $syllabus;


    //get all courses from db
    public function read() {
        $stmt = $this->connect()->prepare('SELECT * FROM courses');
        $stmt->execute();
        return $stmt;
    }

    //get single course from db
    public function readOne() {
        $stmt = $this->connect()->prepare('SELECT * FROM courses.courses WHERE id = ?');
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->code = $row['code'];
        $this->progression = $row['progression'];
        $this->syllabus = $row['syllabus'];
    }
}