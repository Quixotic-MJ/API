<?php
require_once '../Config/Database.php';
require_once '../Controllers/StudControllers.php';

$database = new Database();
$db = $database->connect();
$controllers = new StudControllers($db);


$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? null;

try {
    if ($requestMethod === 'GET' && $action === 'all') {
        $controllers->getAllStudents();
    } elseif ($requestMethod === 'GET' && isset($_GET['STUD_ID'])) {
        $controllers->getStudentById($_GET['STUD_ID']);
    } elseif ($requestMethod === 'POST' && $action === 'add') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["message" => "Invalid JSON data"]);
            exit;
        }

        $controllers->addStudent($data);
    } elseif ($requestMethod === 'PUT' && $action === 'update') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["message" => "Invalid JSON data"]);
            exit;
        }

        $controllers->updateStudent($data);
    } elseif ($requestMethod === 'DELETE' && isset($_GET['STUD_ID'])) {
        $controllers->deleteStudent($_GET['STUD_ID']);
    } else {
        echo json_encode([
            "message" => "Invalid request.",
            "method" => $requestMethod,
            "action" => $action
        ]);
    }
} catch (Exception $e) {
    echo json_encode(["message" => "Server error", "error" => $e->getMessage()]);
    error_log("Error: " . $e->getMessage());
}


error_log("Request Method: " . $requestMethod);
error_log("Action: " . $action);
error_log("Data: " . file_get_contents("php://input"));
?>