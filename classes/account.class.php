<?php
require_once __DIR__ . '/../database/connect.php';

class Account
{
    public $id = '';
    public $lrn = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $username = '';
    public $password = '';
    public $section_id = '';
    public $grade_lvl = '';


    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function getAllStudents()
    {
        $sql = "SELECT st.*, st.lrn, CONCAT(st.first_name,' ', st.last_name) AS student_name, sc.section_name AS section_name 
        FROM students st
        JOIN section sc ON st.section_id = sc.id
        ORDER BY st.id DESC;";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        $data = $query->fetchAll();

        return $data;
    }

    function addStudent()
    {
        $sql = "INSERT INTO students (first_name, last_name, lrn, grade_lvl, section_id, password) VALUES (:first_name, :last_name, :lrn, :grade_lvl, :section_id, :password);";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':lrn', $this->lrn);
        $query->bindParam(':grade_lvl', $this->grade_lvl);
        $query->bindParam(':section_id', $this->section_id);
        $query->bindParam(':password', $this->password);

        return $query->execute();
    }

    function loginStudent($lrn, $password)
    {
        // Join the students and section tables
        $sql = "SELECT * FROM students WHERE lrn = :lrn LIMIT 1;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam('lrn', $lrn);

        if ($query->execute()) {
            $data = $query->fetch();
            if ($data && password_verify($password, $data['password'])) {
                $_SESSION['student_id'] = $data['id'];
                $_SESSION['student_fname'] = $data['first_name'];
                $_SESSION['student_lname'] = $data['last_name'];
                $_SESSION['student_lrn'] = $data['lrn'];
                $_SESSION['student_grade_lvl'] = $data['grade_lvl'];
                $_SESSION['student_section_id'] = $data['section_id'];
                return true;
            }
        }

        return false;
    }

    function loginAdmin($username, $password)
    {
        $sql = "SELECT * FROM admin WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);

        if ($query->execute()) {
            $data = $query->fetch();
            if ($data && password_verify($password, $data['password'])) {
                $_SESSION['admin_id'] = $data['id'];
                $_SESSION['admin_fname'] = $data['first_name'];
                $_SESSION['admin_lname'] = $data['last_name'];
                $_SESSION['admin_username'] = $data['username'];
                return true;
            }
        }

        return false;
    }

    function lrnExist($lrn, $excludeID)
    {
        $sql = "SELECT COUNT(*) FROM students WHERE lrn = :lrn";
        if ($excludeID) {
            $sql .= " and id != :excludeID";
        }
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':lrn', $lrn);

        if ($excludeID) {
            $query->bindParam(':excludeID', $excludeID);
        }
        $count = $query->execute() ? $query->fetchColumn() : 0;
        return $count > 0;
    }



    function getSections()
    {
        $sql = "SELECT id, section_name FROM section";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();  // Return the list of sections
    }

    function fetch($lrn)
    {
        $sql = "SELECT * FROM students WHERE lrn = :lrn LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('lrn', $lrn);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }

        return $data;
    }



    function fetchUser($username)
    {
        $sql = "SELECT * FROM admin WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }

        return $data;
    }

    // Method to fetch student by ID
    public function getStudentById($student_id)
    {
        $sql = "SELECT * FROM students WHERE id = :student_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update student data
    public function updateStudent($student_id)
    {
        $sql = "UPDATE students SET first_name = :first_name, last_name = :last_name, lrn = :lrn, grade_lvl = :grade_lvl, section_id = :section_id WHERE id = :student_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':lrn', $this->lrn);
        $query->bindParam(':grade_lvl', $this->grade_lvl);
        $query->bindParam(':section_id', $this->section_id);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        return $query->execute();
    }
}
