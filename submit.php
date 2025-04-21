<?php
ob_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $name = escapeshellarg($data['name']);
    $attendance = (int)$data['attendance'];
    $unitTest = (int)$data['unitTest'];
    $achievements = escapeshellarg($data['achievements']);
    $mockPractical = (int)$data['mockPractical'];

    $command = "C:\\xamp2k25new\\htdocs\\MProjectDSA\\main.exe $name $attendance $unitTest $achievements $mockPractical";

    $output = shell_exec($command);

    if ($output !== null) {
        $response = ["message" => trim($output)];
    } else {
        $response = ["message" => "Failed to execute C++ program."];
    }

    ob_end_clean();
    echo json_encode($response);
} else {
    echo json_encode(["message" => "Invalid input data"]);
}
?>
