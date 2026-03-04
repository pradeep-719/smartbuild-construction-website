<?php
// --- Direct MySQL Connection ---
$host = "localhost";
$user = "root";
$pass = "";
$db   = "project_sehat";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = 1; // Example (actual: session se lo)
    $contractor_id = $_POST['contractor_id'];
    $form_data = $conn->real_escape_string($_POST['form_data']);

    // ---- File Upload (User Signature) ----
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir);
    
    $fileName = time() . "_" . basename($_FILES["user_signature"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (!move_uploaded_file($_FILES["user_signature"]["tmp_name"], $targetFilePath)) {
        die("Error uploading file.");
    }

    // ---- Save to Database ----
    $sql = "INSERT INTO deals (user_id, contractor_id, form_data, user_signature, status)
            VALUES ('$user_id', '$contractor_id', '$form_data', '$targetFilePath', 'pending_contractor')";
    $conn->query($sql);

    // ---- Generate PDF ----
    require('fpdf186/fpdf.php'); // Make sure fpdf186/fpdf.php exists in same folder

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Deal Agreement Form', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, "Contractor ID: $contractor_id\n\nDeal Details:\n$form_data", 0, 'L');
    $pdf->Ln(10);

    if (file_exists($targetFilePath)) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'User Signature:', 0, 1);
        $pdf->Image($targetFilePath, 20, $pdf->GetY(), 60);
    }

    $pdfFileName = "deal_" . time() . ".pdf";
    $pdf->Output('D', $pdfFileName); // Force browser download
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Deal Form</title>
<style>
body {
  background: #f8f9fa;
  font-family: Arial, sans-serif;
}
.container {
  background: #fff;
  width: 400px;
  margin: 60px auto;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}
h2 {
  text-align: center;
  color: #333;
  margin-bottom: 15px;
}
label {
  font-weight: bold;
  display: block;
  margin-top: 10px;
}
input, textarea {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border-radius: 6px;
  border: 1px solid #ccc;
  outline: none;
}
button {
  background: #007bff;
  color: #fff;
  border: none;
  margin-top: 15px;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
}
button:hover {
  background: #0056b3;
}
</style>
</head>
<body>

<div class="container">
  <h2>User → Contractor Deal Form</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Contractor ID:</label>
    <input type="number" name="contractor_id" placeholder="Enter contractor ID" required>

    <label>Deal Details:</label>
    <textarea name="form_data" rows="4" placeholder="Enter deal terms..." required></textarea>

    <label>Upload Your Signature:</label>
    <input type="file" name="user_signature" accept="image/*,application/pdf" required>

    <button type="submit">Submit & Download PDF</button>
  </form>
</div>

</body>
</html>
