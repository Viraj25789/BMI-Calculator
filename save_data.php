<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function respond(int $statusCode, array $payload): void {
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    respond(405, ['success' => false, 'message' => 'Method not allowed.']);
}

$heightInput = $_POST['height'] ?? null;
$weightInput = $_POST['weight'] ?? null;

if (!is_numeric($heightInput) || !is_numeric($weightInput)) {
    respond(400, ['success' => false, 'message' => 'Height and weight must be numeric values.']);
}

$height = (float) $heightInput;
$weight = (float) $weightInput;

if (!is_finite($height) || !is_finite($weight) || $height <= 0 || $weight <= 0) {
    respond(400, ['success' => false, 'message' => 'Height and weight must be greater than zero.']);
}

$bmi = $weight / (($height / 100) ** 2);
if (!is_finite($bmi)) {
    respond(400, ['success' => false, 'message' => 'Unable to calculate BMI from these values.']);
}

$status = $bmi < 18.5 ? 'Underweight' : ($bmi < 25 ? 'Normal' : 'Overweight');

$host = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'bmi_db';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli($host, $username, $password, $dbName);
    $conn->set_charset('utf8mb4');

    $stmt = $conn->prepare(
        'INSERT INTO bmi_records (height_cm, weight_kg, bmi_value, status) VALUES (?, ?, ?, ?)'
    );
    $stmt->bind_param('ddds', $height, $weight, $bmi, $status);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    respond(200, [
        'success' => true,
        'message' => 'BMI record saved successfully.',
        'bmi' => round($bmi, 2),
        'status' => $status,
    ]);
} catch (Throwable $e) {
    error_log('BMI Calculator database save failed: ' . $e->getMessage());
    respond(500, ['success' => false, 'message' => 'Could not save this calculation. Check the server database configuration.']);
}
