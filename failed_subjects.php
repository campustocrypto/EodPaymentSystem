<?php
session_start(); // Start the session

// Check if the session variable containing data exists
if (isset($_SESSION['failed_subjects']) && is_array($_SESSION['failed_subjects']) && !empty($_SESSION['failed_subjects'])) {
    $failed_subjects = $_SESSION['failed_subjects'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch student details from database
    if (isset($_GET['registration_number'])) {
        $registrationNumber = $_GET['registration_number'];
        $sql = "SELECT Registration_Number, Name, branch, course FROM students WHERE Registration_Number = '$registrationNumber'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output student details
            while ($row = $result->fetch_assoc()) {
                echo "<h2>Student Details</h2>";
                echo "<p>Registration Number: " . $row['Registration_Number'] . "</p>";
                echo "<p>Name: " . $row['Name'] . "</p>";
                echo "<p>Branch: " . $row['branch'] . "</p>";
                echo "<p>Course: " . $row['course'] . "</p>";
            }
        } else {
            echo "<p>No student details found.</p>";
        }
    } else {
        echo "<p>No registration number provided.</p>";
    }

    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Subjects</title>
    <link rel="stylesheet" href="./css/failed_subjects.css">
    <style>
        /* General Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e9edf3;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.container {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    text-align: center;
}

h2 {
    color: #333;
    margin-bottom: 20px;
    font-size: 28px;
    border-bottom: 2px solid #007bff;
    display: inline-block;
    padding-bottom: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fafafa;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

td {
    background-color: white;
}

td input {
    margin-right: 10px;
}

/* Checkbox Styles */
.cyberpunk-checkbox {
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #999;
    border-radius: 3px;
    cursor: pointer;
    outline: none;
    transition: background-color 0.3s, border-color 0.3s;
}

.cyberpunk-checkbox:checked {
    background-color: #007bff;
    border-color: #007bff;
}

/* Button Styles */
button {
    padding: 12px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

button:hover {
    background-color: #45a049;
}

button.disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

button:active {
    transform: translateY(1px);
}

h3 {
    margin: 20px 0;
    color: #333;
    font-size: 24px;
}

.form-footer a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
}

.form-footer a:hover {
    color: #0056b3;
}

/* Student Details Section */
.studentDetails {
    text-align: left;
    margin-bottom: 20px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

.studentDetails p {
    margin: 10px 0;
    color: #555;
    font-size: 18px;
}

.copy-text {
    display: inline-block;
    background-color: #f9f9f9;
    padding: 5px 10px;
    border-radius: 5px;
    font-family: monospace;
}

/* Table Styles */
.table {
    text-align: left;
}

.table h2 {
    text-align: center;
}

@media (max-width: 600px) {
    .container {
        width: 95%;
        margin: 20px auto;
        padding: 10px;
    }

    th, td {
        padding: 8px;
    }

    button {
        width: 100%;
        margin: 10px 0;
    }

    .studentDetails {
        padding: 10px;
    }
}

    </style>
</head>
<body>
   
    <!-- Student details will be displayed above the table -->
    <div class="table">
        <h2>Failed Subjects</h2>
        <table id="tableBody">
            <tr>
                <th>Index</th>
                <th>Subject Name</th>
                <th>Subject Code</th>
                <th>Rupees</th>
                <th>Ethers</th>
            </tr>
            <?php
            $index = 1;
            foreach ($failed_subjects as $subject) {
                echo "<tr>";
                echo "<td>" . $index . "</td>";
                echo "<td>" . $subject['Subject_Name'] . "</td>";
                echo "<td>" . $subject['Subject_Code'] . "</td>";
                echo "<td><input type='checkbox'  class='cyberpunk-checkbox' name='rupeesCheckBox[]' value='" . $subject['amountRupees'] . "'>" . $subject['amountRupees'] . "</td>";
                echo "<td><input type='checkbox' class='cyberpunk-checkbox' name='ethersCheckBox[]' value='" . $subject['amountEthers'] . "'>" . $subject['amountEthers'] . "</td>";
                echo "</tr>";
                $index++;
            }
            ?>
        </table>
    </div>

    <h3>Total Rupees: <span id="rupe">0</span></h3>
    <h3>Total Ethers: <span id="ethe">0</span></h3>

    <!-- Rupees Payment button -->
<a id="rupeesPayment" href="./rupees_Payment.php?registration_number=<?php echo $registrationNumber; ?>" class="disabled"><button>Rupees Payment</button></a>

<!-- Ethers Payment button -->
<a id="ethersPayment" href="./ethersPayment.php?registration_number=<?php echo $registrationNumber; ?>" class="disabled"><button>Ethers Payment</button></a>


<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_registration_number'])) {
    // Retrieve the registration number entered by the user
    $registration_number = $_POST['search_registration_number'];

    // Validate registration number format if needed

    // Establish database connection
    $conn = mysqli_connect("localhost", "root", "", "students");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve student details based on registration number
    $student_query = "SELECT * FROM Students WHERE Registration_Number = '$registration_number'";
    $student_result = mysqli_query($conn, $student_query);

    if (mysqli_num_rows($student_result) > 0) {
        // Display student details
        $student_row = mysqli_fetch_assoc($student_result); 
        echo "<div class='studentDetails'>";
        echo "<h2>Student Details</h2>";
        echo "<p><strong>Registration Number:</strong> " . htmlspecialchars($student_row['Registration_Number'] ? $student_row['Registration_Number'] : "NULL") . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($student_row['Name'] ? $student_row['Name'] : "NULL") . "</p>";
        echo "<p><strong>Course:</strong> " . htmlspecialchars($student_row['course'] ? $student_row['course'] : "NULL") . "</p>";
        echo "<p><strong>Branch:</strong> " . htmlspecialchars($student_row['branch'] ? $student_row['branch'] : "NULL") . "</p>";
        echo "</div>";

        // Retrieve failed subjects of the student including amount from transactions
        $failed_subjects_query = "SELECT failed_subjects.Failed_Subject_ID, failed_subjects.Subject_Name, failed_subjects.Subject_Code, transactions.Payment_Type, Transactions.Transaction_ID, failed_subjects.amountEthers
                FROM Failed_Subjects
                LEFT JOIN transactions ON failed_Subjects.Student_ID = transactions.Student_ID 
                WHERE Failed_Subjects.Student_ID = (SELECT Student_ID FROM Students WHERE Registration_Number = '$registration_number')";
        $failed_subjects_result = mysqli_query($conn, $failed_subjects_query);

        if (mysqli_num_rows($failed_subjects_result) > 0) {
            echo "<div class='table'>";
            echo "<h2>Failed Subjects</h2>";
            echo "<table>";
            echo "<tr><th>Subject Name</th><th>Subject Code</th><th>Payment Type</th><th>Transaction ID</th><th>Amount</th><th>Update</th></tr>";
            while ($failed_subject_row = mysqli_fetch_assoc($failed_subjects_result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($failed_subject_row['Subject_Name'] ? $failed_subject_row['Subject_Name'] : "NULL") . "</td>";
                echo "<td>" . htmlspecialchars($failed_subject_row['Subject_Code'] ? $failed_subject_row['Subject_Code'] : "NULL") . "</td>";
                echo "<td>" . htmlspecialchars($failed_subject_row['Payment_Type'] ? $failed_subject_row['Payment_Type'] : "NULL") . "</td>";
                echo "<td><span class='copy-text'>" . htmlspecialchars($failed_subject_row['Transaction_ID'] ? $failed_subject_row['Transaction_ID'] : "NULL") . "</span></td>";
                echo "<td>" . htmlspecialchars($failed_subject_row['amountEthers'] ? $failed_subject_row['amountEthers'] : "NULL") . "</td>";
                echo "<td><input type='checkbox' name='select_subject[]' class='cyberpunk-checkbox' value='" . htmlspecialchars($failed_subject_row['Failed_Subject_ID']) . "' onchange='updateSelectedSubjects(this)'></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>"; // Closing div for table
        } else {
            echo "<p>No failed subjects found.</p>";
        }
    } else {
        echo "<p>No student found with the provided registration number.</p>";
    }

    mysqli_close($conn); // Close database connection
}
?>



    <script>
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var rupeesPaymentBtn = document.getElementById('rupeesPayment');
    var ethersPaymentBtn = document.getElementById('ethersPayment');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            // If this checkbox is checked, uncheck the other checkbox in the row
            if (this.checked) {
                checkboxes.forEach(function (cb) {
                    if (cb !== checkbox && cb.parentNode.parentNode === checkbox.parentNode.parentNode) {
                        cb.checked = false;
                    }
                });
            }
            updateSums();
            storeSelectedRows(); // Call the function to store selected rows
        });
    });

    function updateSums() {
        var rupeesSum = 0;
        var ethersSum = 0;
        var tableBody = document.getElementById("tableBody");

        const rows = tableBody.querySelectorAll("tr");

        rows.forEach(function (row) {
            const checkboxes = row.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    // Check if checkbox is checked
                    const name = checkbox.name; // Get the value attribute of the checkbox

                    if (name === "rupeesCheckBox[]") {
                        rupeesSum += parseFloat(checkbox.value);
                    }
                    if (name === "ethersCheckBox[]") {
                        ethersSum += parseFloat(checkbox.value);
                    }
                }
            });
        });

        // Update paragraph elements with calculated sums
        const rupeesElement = document.getElementById("rupe");
        const ethersElement = document.getElementById("ethe");
        rupeesElement.innerHTML = rupeesSum;
        ethersElement.innerHTML = ethersSum;

        // Enable/disable payment buttons based on sums
        if (rupeesSum > 0) {
            rupeesPaymentBtn.classList.remove('disabled');
        } else {
            rupeesPaymentBtn.classList.add('disabled');
        }

        if (ethersSum > 0) {
            ethersPaymentBtn.classList.remove('disabled');
        } else {
            ethersPaymentBtn.classList.add('disabled');
        }
        
        // Update session storage with sums
        sessionStorage.setItem("ethersSum", ethersSum);
        sessionStorage.setItem("rupeesSum", rupeesSum);
    }

    function storeSelectedRows() {
        var selectedRows = [];
        var tableBody = document.getElementById("tableBody");
        const rows = tableBody.querySelectorAll("tr");

        rows.forEach(function (row) {
            const checkboxes = row.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    // If checkbox is checked, store the row data
                    var rowData = {
                        "Subject_Name": row.cells[1].textContent,
                        "Subject_Code": row.cells[2].textContent,
                        "Rupees": row.cells[3].textContent,
                        "Ethers": row.cells[4].textContent
                    };
                    selectedRows.push(rowData);
                }
            });
        });

        // Store selected rows in session storage as JSON
        sessionStorage.setItem("selectedRows", JSON.stringify(selectedRows));
    }
</script>


</body>
</html>

<?php

    
} else {
    // If session variable doesn't exist or is empty, display an appropriate message
    echo "<p>No data available.</p>";
}
?>
