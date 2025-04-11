<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read POST input as JSON
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // Escape and quote each argument correctly for shell
    $name = escapeshellarg($data['name']);
    $attendance = (int)$data['attendance'];
    $unitTest = (int)$data['unitTest'];
    $achievements = escapeshellarg($data['achievements']);
    $mockPractical = (int)$data['mockPractical'];

    $command = "C:\\xamp2k25new\\htdocs\\MProjectDSA\\main.exe $name $attendance $unitTest $achievements $mockPractical";

    $output = shell_exec($command);

    echo json_encode(["message" => trim($output)]);
} else {
    echo json_encode(["message" => "Invalid input data"]);
}
?>
