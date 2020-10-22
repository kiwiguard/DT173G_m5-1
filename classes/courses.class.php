<?php 

class Courses extends Database { 

    //Course properties
    public $id;
    public $name;
    public $code;
    public $progression;
    public $syllabus;

    //Strips input data of tags
    function cleanInput($name, $code, $progression, $syllabus) {
        $this->name = strip_tags($name);
        $this->code = strip_tags($code);
        $this->progression = strip_tags($progression);
        $this->syllabus = strip_tags($syllabus);

        if($this->code !='') {
            return true;
        } else {
            return false;
        }
    }

    function checkId($id) {
        $stmt = $this->connect()->prepare('SELECT * FROM courses WHERE id=?');
        $stmt->execute(['$id']);
        $count = $stmt->fetch();
        if($count) {
            return true;
        } else {
            return false;
        }
    }

    //Get all courses from db
    function read() {
        $stmt = $this->connect()->prepare('SELECT * FROM courses');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // //get single course from db
    // public function readOne($id) {
    //     $stmt = $this->conn->prepare('SELECT * FROM' . $this->table . ' WHERE id =' . $id . 'LIMIT 1');
    //     $stmt->execute();
    //     $data = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if(!$data) {
    //         $data = array();
    //     }

    //     return $data;
    // }

    //add course to db
    public function addCourse($inname, $incode, $inprogression, $insyllabus) {
        $stmt = $this->connect()->prepare('INSERT INTO courses (name, code, progression, syllabus) VALUES (?, ?, ?, ?)');
        if($this->cleanInput($inname, $incode, $inprogression, $insyllabus)) {
            if($stmt->execute([$this->name, $this->code, $this->progression, $this->syllabus])) {
                return true;
            } else {
                return false;
            }
        }
     } 

    //update course
    public function updateCourse($inname, $incode, $inprogression, $insyllabus, $id) {
        $stmt = $this->connect()->prepare('UPDATE courses SET name=?, code=?, progression=?, syllabus=? WHERE id=?');
        if($this->cleanInput($inname, $incode, $inprogression, $insyllabus)) {
            if($stmt->execute([$this->name, $this->code, $this->progression, $this->syllabus, $this->id])) {
                return true;
            } else {
                return false;
            }
            $stmt->execute([]);
        }
    }
   

    //delete course from db
    public function deleteCourse($id) {
        $stmt = $this->connect()->prepare('DELETE FROM courses WHERE id=:id');
        if($stmt->execute(['$id'])) {
                return true;
        } else {
            return false;
        }
    }
}