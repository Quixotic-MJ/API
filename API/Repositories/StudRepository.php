<?php
class StudRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllStudents() {
        $sql = "SELECT * FROM student";
        $result = $this->conn->query($sql);

        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    }

    public function getStudentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM student WHERE STUD_ID = ?" );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function addStudent($name, $midterm_score, $final_score) {
        $stmt = $this->conn->prepare("INSERT INTO student (STUD_NAME, STUD_MID, STUD_FSCORE) VALUES (?, ?, ?)");
        $stmt->bind_param("sdd", $name, $midterm_score, $final_score);
        return $stmt->execute();
    }

    public function updateStudent($id, $midterm_score, $final_score) {
        $stmt = $this->conn->prepare("UPDATE student SET STUD_MID = ?, STUD_FSCORE = ? WHERE STUD_ID = ?");
        $stmt->bind_param("ddi", $midterm_score, $final_score, $id);
        return $stmt->execute();
    }

    public function deleteStudent($id) {
        $stmt = $this->conn->prepare("DELETE FROM student WHERE STUD_ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>