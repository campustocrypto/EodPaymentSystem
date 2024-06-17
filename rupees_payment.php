<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupees Payment</title>
    <link rel="stylesheet" href="./css/rupeesPayment.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        /* General Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    min-height: 100vh;
}

.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    margin-top: 20px;
    gap: 20px;
}

.card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 400px;
    width: 100%;
    text-align: center;
    box-sizing: border-box;
}

h2 {
    color: #333;
    margin-bottom: 15px;
    font-size: 24px;
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

button:active {
    transform: translateY(1px);
}

button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.receipt {
    margin-top: 20px;
    text-align: left;
}

.receipt h1 {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

.receipt p {
    margin-bottom: 10px;
    font-size: 16px;
    color: #555;
}

.receipt table {
    width: 100%;
    border-collapse: collapse;
}

.receipt th, .receipt td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.receipt th {
    background-color: #f2f2f2;
    font-weight: bold;
}

#printButton {
    display: none;
    margin-top: 20px;
}



/* Media Queries */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
    }

    .card {
        max-width: 95%;
    }

    th, td {
        padding: 10px;
    }

    button {
        width: 100%;
        margin: 10px 0;
    }

    .receipt p {
        font-size: 14px;
    }
}

    </style>
    <style media="print">
    body * {
        display: none;
    }

    .receipt, .receipt * {
        display: block !important;
    }
</style>

</head>
<body>
    <div class="container">
        <div class="card">
            <?php
            session_start();if (isset($_GET['registration_number'])) {
                $registrationNumber = $_GET['registration_number'];

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
                $sql = "SELECT Registration_Number, Name, branch, course FROM students WHERE Registration_Number = '$registrationNumber'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output student details
                    while ($row = $result->fetch_assoc()) {
                        // Store student details in variables
                        $registrationNumber = $row['Registration_Number'];
                        $name = $row['Name'];
                        $branch = $row['branch'];
                        $course = $row['course'];

                        // Output student details
                        echo "<h2>Student Details</h2>";
                        echo "<p>Registration Number: " . $registrationNumber . "</p>";
                        echo "<p>Name: " . $name . "</p>";
                        echo "<p>Branch: " . $branch . "</p>";
                        echo "<p>Course: " . $course . "</p>";
                    }
                } else {
                    echo "<p>No student details found.</p>";
                }

                $conn->close();
            } else {
                echo "<p>No registration number provided.</p>";
            }
            ?>
        </div>
        <div class="card">
            <h2>Selected Subjects</h2>
            <table>
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Rupees</th>
                    </tr>
                </thead>
                <tbody id="selectedRowsBody"></tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <h2>Pay with Rupees</h2>
        <div class="rupeesPaymentContent">
            <h1>Complete Payment via Razorpay</h1>
            <div id="amount"></div>
            <button id="payButton">Pay Now</button>
        </div>
    </div>
    <div id="transactionDetailsDiv" class="receipt" style="display: none;">
        <h1>Receipt</h1>
        <?php
        if (isset($registrationNumber) && isset($name) && isset($branch) && isset($course)) {
            echo "<p><strong>Registration Number:</strong> $registrationNumber</p>";
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Branch:</strong> $branch</p>";
            echo "<p><strong>Course:</strong> $course</p>";
        }
        ?>
        <p><strong>Payment Type:</strong> Rupees</p>
        <p><strong>Amount:</strong> <span id="paymentAmount"></span> INR</p>
        <p><strong>Transaction ID:</strong> <span id="transactionId"></span></p>
        <h2>Selected Subjects</h2>
        <table>
            <thead>
                <tr>
                    <th>Index</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Rupees</th>
                </tr>
            </thead>
            <tbody id="additionalTableBody"></tbody>
        </table>
        <button id="printButton">Print Receipt</button>
    </div>

    <script>
        document.getElementById("amount").innerText = sessionStorage.getItem('rupeesSum');
        var selectedRows = JSON.parse(sessionStorage.getItem("selectedRows"));

        var selectedRowsBody = document.getElementById("selectedRowsBody");
        var index = 1;
        if (selectedRows) {
            selectedRows.forEach(function (row) {
                var newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td>${index}</td>
                <td>${row.Subject_Name}</td>
                <td>${row.Subject_Code}</td>
                <td>${row.Rupees}</td>
            `;
                selectedRowsBody.appendChild(newRow);
                index++;
            });
        }

        var additionalTableBody = document.getElementById("additionalTableBody");
        if (selectedRows) {
            selectedRows.forEach(function (row, index) {
                var newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td>${index + 1}</td>
                <td>${row.Subject_Name}</td>
                <td>${row.Subject_Code}</td>
                <td>${row.Rupees}</td>
            `;
                additionalTableBody.appendChild(newRow);
            });
        }

        const payButton = document.getElementById("payButton");

        payButton.addEventListener("click", function () {
            const registrationNumber = "<?php echo isset($registrationNumber) ? $registrationNumber : 'null'; ?>";
            const rupeesSum = sessionStorage.getItem("rupeesSum");
            const selectedRows = JSON.parse(sessionStorage.getItem("selectedRows"));

            var options = {
                "key": "rzp_test_byPLZtNtsJuOI3",
                "amount": rupeesSum * 100, // Amount is in currency subunits. Default currency is INR.
                "currency": "INR",
                "name": "Your Company Name",
                "description": "Test Transaction",
                "handler": function (response) {
                    sessionStorage.setItem("transactionId", response.razorpay_payment_id);
                    document.getElementById("printButton").style.display = "block";
                    displayReceipt();

                    fetch('update_database.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            transactionId: sessionStorage.getItem("transactionId"),
                            registrationNumber: registrationNumber,
                            rupeesSum: rupeesSum,
                            selectedRows: selectedRows
                        })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            alert("Payment successful and database updated!");
                        } else {
                            alert("Payment successful but database update failed!");
                        }
                    }).catch(error => {
                        console.error("Error updating database:", error);
                    });
                },
                "prefill": {
                    "name": "<?php echo isset($name) ? $name : ''; ?>",
                    "email": "user@example.com",
                    "contact": "9999999999"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        });

        function displayReceipt() {
            document.getElementById("transactionDetailsDiv").style.display = "block";
            document.getElementById("paymentAmount").innerText = sessionStorage.getItem("rupeesSum");
            document.getElementById("transactionId").innerText = sessionStorage.getItem("transactionId");
        }

      
    // Function to handle printing the receipt
    function printReceipt() {
        // Hide the print button to prevent multiple prints
        document.getElementById("printButton").style.display = "none";
        // Print only the receipt section
        window.print();
        // Show the print button again after printing is done
        document.getElementById("printButton").style.display = "block";
    }

    // Event listener for the print button
    document.getElementById("printButton").addEventListener("click", function () {
        printReceipt();
    });



    </script>
</body>

</html>