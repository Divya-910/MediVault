<?php require_once('./config.php');
// Connect to your MySQL database
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

// Retrieve data from POST request
$specialization = $_POST['specialization'];
$location = $_POST['location'];

// Prepare SQL statement to fetch doctors based on specialization and location
$sql = "SELECT * FROM doctors WHERE specialization = :specialization AND location = :location";
$stmt = $pdo->prepare($sql);
$stmt->execute(['specialization' => $specialization, 'location' => $location]);
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return JSON response with doctors data
header('Content-Type: application/json');
echo json_encode($doctors);
?>
