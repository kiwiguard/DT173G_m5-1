<?php 

class Courses extends Database { 

    //Course properties
    public $id;
    public $name;
    public $code;
    public $progression;
    public $syllabus;


    //Get all courses from db
    function read() {
        $stmt = $this->connect()->prepare('SELECT * FROM susanneni_dt173g.courses');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //get single course from db
    public function readOne($id) {
        $stmt = $this->connect()->prepare('SELECT * FROM susanneni_dt173g.courses WHERE id =' . $id );
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$data) {
            $data = array();
        }

        return $data;
    }

    //add course to db
    public function addCourse() {
        $q = 'INSERT INTO susanneni_dt173g.courses 
        SET
            name = :name,
            code = :code,
            progression = :progression,
            syllabus = :syllabus';

        $stmt = $this->connect()->prepare($q);

        //strip data of tags
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->progression = htmlspecialchars(strip_tags($this->progression));
        $this->syllabus = htmlspecialchars(strip_tags($this->syllabus));

        // bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':code', $this->code);
        $stmt->bindParam(':progression', $this->progression);
        $stmt->bindParam(':syllabus', $this->syllabus);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
     } 

    //update course
    public function updateCourse($id) {
        $stmt = $this->connect()->prepare('UPDATE susanneni_dt173g.courses 
            SET 
                name = :name,
                code = :code,
                progression = :progression,
                syllabus = :syllabus
            WHERE
                id = :id');
        //strip data of tags
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->progression = htmlspecialchars(strip_tags($this->progression));
        $this->syllabus = htmlspecialchars(strip_tags($this->syllabus));

        // bind data
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':code', $this->code);
        $stmt->bindParam(':progression', $this->progression);
        $stmt->bindParam(':syllabus', $this->syllabus);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
    }

    //delete course from db
    public function deleteCourse($id) {
            $stmt = $this->connect()->prepare('DELETE FROM susanneni_dt173g.courses WHERE id= ' . $id);
            if($stmt->execute()) {
                    return true;
            } else {
                return false;
            }
        }
    }
