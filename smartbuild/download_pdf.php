<?php
session_start();
$user_email = $_SESSION['email'] ?? null;
if (!$user_email) {
    header("Location: registr.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usersss";
define('UPLOAD_DIR', 'uploads/');

require_once('tcpdf/tcpdf.php'); // Include TCPDF

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch user track data
$sql = "SELECT worker_id, image_filename, log_datetime FROM track_updates WHERE user_email = ? ORDER BY log_datetime DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$track_data = [];
while ($row = $result->fetch_assoc()) {
    $track_data[] = $row;
}
$stmt->close();
$conn->close();

if (empty($track_data)) {
    die("No track updates to generate PDF.");
}

// Create new PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'My Worker Track Updates', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('helvetica', '', 12);

foreach ($track_data as $row) {
    $pdf->Cell(0, 6, 'Contractor: ' . $row['worker_id'], 0, 1);
    $pdf->Cell(0, 6, 'Upload Time: ' . $row['log_datetime'], 0, 1);

    $imgFile = UPLOAD_DIR . $row['image_filename'];
    if (file_exists($imgFile)) {
        $pdf->Image($imgFile, '', '', 60, 60); // width=60, height=auto
    }
    $pdf->Ln(10); // Space before next entry
}

// Output PDF to browser
$pdf->Output('track_updates.pdf', 'D'); // D = download
