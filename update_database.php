<?php
header('Content-Type: application/json');

// Retrieve transaction details and selected rows from the POST request
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// Extract common transaction details
$transactionId = $data['transactionId'];
$registrationNumber = $data['registrationNumber'];
$selectedRows = $data['selectedRows'];

// Determine the type of payment and its corresponding sum
$paymentType = isset($data['rupeesSum']) ? 'Rupees' : 'Ethers';
$paymentSum = isset($data['rupeesSum']) ? $data['rupeesSum'] : $data['ethersSum'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Retrieve student ID based on registration number
$sql = "SELECT Student_ID FROM students WHERE Registration_Number = '$registrationNumber'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $studentId = $row['Student_ID'];

    // Insert transaction details into transactions table
    $insert_sql = "INSERT INTO transactions (Transaction_ID, Student_ID, Payment_Type, txn_amount) 
                    VALUES ('$transactionId', '$studentId', '$paymentType', '$paymentSum')";

    if ($conn->query($insert_sql) === TRUE) {
        // Retrieve the auto-incremented txn_id
        $txnId = $conn->insert_id;

        // Iterate through selected rows and update the paid status and transaction ID
        foreach ($selectedRows as $row) {
            $subjectCode = $row['Subject_Code'];

            // Check if the subject code matches the student's subject code
            $check_subject_sql = "SELECT * FROM failed_subjects WHERE Student_ID = '$studentId' AND Subject_Code = '$subjectCode'";
            $check_subject_result = $conn->query($check_subject_sql);

            if ($check_subject_result->num_rows > 0) {
                // Update the paid column and txn_id for the matching row
                $update_paid_sql = "UPDATE failed_subjects SET paid = 'yes', txn_id = '$txnId' WHERE Student_ID = '$studentId' AND Subject_Code = '$subjectCode'";
                if ($conn->query($update_paid_sql) !== TRUE) {
                    echo json_encode(['success' => false, 'message' => 'Error updating paid status: ' . $conn->error]);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => "No matching subject found for Student_ID: $studentId and Subject_Code: $subjectCode"]);
                exit;
            }
        }

        echo json_encode(['success' => true, 'message' => 'Database updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating database: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No student found with the provided registration number']);
}

$conn->close();
?>
