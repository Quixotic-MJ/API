<?php
require_once '../Repositories/StudRepository.php';
require_once '../Core/Response.php';

class StudControllers {
    private $Repositories;

    public function __construct($db) {
        $this->Repositories = new StudRepository($db);
    }

    public function getAllStudents() {
        $StudRepository = $this->Repositories->getAllStudents();
        Response::json($StudRepository);
    }

    public function getStudentById($id) {
        $StudRepository = $this->Repositories->getStudentById($id);
        if ($StudRepository) {
            Response::json($StudRepository);
        } else {
            Response::json(["message" => "Student not found."], 404);
        }
    }

    public function addStudent($data) {
        if (isset($data['STUD_NAME'], $data['STUD_MID'], $data['STUD_FSCORE'])) {
            $this->Repositories->addStudent($data['STUD_NAME'], $data['STUD_MID'], $data['STUD_FSCORE']);
            Response::json(["message" => "Student added successfully."]);
        } else {
            Response::json(["message" => "Invalid input."], 400);
        }
    }

    public function updateStudent($data) {
        if (isset($data['STUD_ID'], $data['STUD_MID'], $data['STUD_FSCORE'])) {
            $this->Repositories->updateStudent($data['STUD_ID'], $data['STUD_MID'], $data['STUD_FSCORE']);
            Response::json(["message" => "Student updated successfully."]);
        } else {
            Response::json(["message" => "Invalid input."], 400);
        }
    }

    public function deleteStudent($id) {
        $this->Repositories->deleteStudent($id);
        Response::json(["message" => "Student deleted successfully."]);
    }
}
?>