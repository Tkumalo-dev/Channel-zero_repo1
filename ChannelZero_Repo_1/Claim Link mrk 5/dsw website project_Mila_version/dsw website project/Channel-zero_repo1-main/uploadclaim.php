<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $companyName = $_POST['company_name'];
    $file = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];

    if (strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) !== 'csv') {
        die("Only CSV files are allowed.");
    }

    if (($handle = fopen($file, "r")) !== FALSE) {
        include 'db_connect.php';

        $header = fgetcsv($handle);
        $rowCount = 0;
        $skipped = 0;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $idNumber = $data[0];
            $fullName = $data[1];
            $amount = $data[2];
            $date = $data[3];
            $reference = $data[4];

            if (!is_numeric($idNumber) || !is_numeric($amount)) {
                $skipped++;
                continue;
            }

            $stmt = $conn->prepare("INSERT INTO unclaimed_funds (id_number, full_name, amount, date, reference, company_name) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsss", $idNumber, $fullName, $amount, $date, $reference, $companyName);

            if ($stmt->execute()) {
                $rowCount++;
            } else {
                $skipped++;
            }
        }
        fclose($handle);

        echo "Upload complete. $rowCount records inserted. $skipped records skipped due to errors.";
    } else {
        echo "Failed to open the file.";
    }
} else {
    echo "No form submission detected.";
}
?>
