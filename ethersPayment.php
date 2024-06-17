<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <!-- <link rel="stylesheet" href="./css/ethersPayment.css"> -->

    <style>/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
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
    margin-bottom: 20px;
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
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

button:hover {
    background-color: #0056b3;
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
    margin-top: 20px;
}

.cryptoPaymentContent {
    display: flex;
    flex-direction: column;
    align-items: center;
}

#accountDetailsDiv {
    margin-bottom: 10px;
}

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
     <script
      src="https://cdn.ethers.io/scripts/ethers-v3.min.js"
      charset="utf-8"
      type="text/javascript"
    ></script>
</head>
<body>
<div class="container">
    <div class="card">
        <?php
        session_start(); // Start the session

        // Check if the registration number is provided in the URL
        if (isset($_GET['registration_number'])) {
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
                    <th>Ethers</th>
                </tr>
            </thead>
            <tbody id="selectedRowsBody"></tbody>
        </table>
    </div>
</div>
<div class="card">
    <h2>Pay with Crypto</h2>
    <!-- Placeholder content for cryptocurrency payment -->
    <div class="cryptoPaymentContent">
        <h1>Transfer Funds via MetaMask</h1>
        <div id="accountDetailsDiv">
            <!-- Account details will be displayed here -->
        </div>
        <br />
        <button id="connectButton">Connect Metamask</button>
        <!-- Add id attribute to the Transfer Funds button -->
        <div id="amount"></div>
        <button id="transferButton">Transfer Funds</button>
    </div>
</div>
<div id="transactionDetailsDiv" class="receipt" style="display: none;">
    <!-- Transaction details will be displayed here -->
    <h1>Receipt</h1>
    <?php
    // Check if student details are available
    if (isset($registrationNumber) && isset($name) && isset($branch) && isset($course)) {
        echo "<p><strong>Registration Number:</strong> $registrationNumber</p>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Branch:</strong> $branch</p>";
        echo "<p><strong>Course:</strong> $course</p>";
    }
    ?>
    <p><strong>Payment Type:</strong> Ethers</p>
    <p><strong>Amount:</strong> <span id="paymentAmount"></span> Eth</p>
    <p><strong>Transaction ID:</strong> <span id="transactionId"></span></p>
    <p><strong>From Address:</strong> <span id="fromAddress"></span></p>
    <p><strong>To Address:</strong> <span id="toAddress"></span></p>
    <p><strong>Timestamp:</strong> <span id="timestamp"></span></p>
    <h2>Selected Subjects</h2>
    <table>
        <thead>
            <tr>
                <th>Index</th>
                <th>Subject Name</th>
                <th>Subject Code</th>
                <th>Ethers</th>
            </tr>
        </thead>
        <tbody id="additionalTableBody"></tbody>
    </table>
    <!-- Add print button here -->
    <button id="printButton">Print Receipt</button>
</div>

<script>
    // Retrieve selected rows from session storage
    document.getElementById("amount").innerText =sessionStorage.getItem('ethersSum');
    var selectedRows = JSON.parse(sessionStorage.getItem("selectedRows"));

    // Display selected rows
    var selectedRowsBody = document.getElementById("selectedRowsBody");
    var index = 1;
    if (selectedRows) {
        selectedRows.forEach(function (row) {
            var newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${index}</td>
                <td>${row.Subject_Name}</td>
                <td>${row.Subject_Code}</td>
                <td>${row.Ethers}</td>
            `;
            selectedRowsBody.appendChild(newRow);
            index++;
        });
    }

    // Display selected rows in the receipt
    var additionalTableBody = document.getElementById("additionalTableBody");
    if (selectedRows) {
        selectedRows.forEach(function (row, index) {
            var newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${index + 1}</td>
                <td>${row.Subject_Name}</td>
                <td>${row.Subject_Code}</td>
                <td>${row.Ethers}</td>
            `;
            additionalTableBody.appendChild(newRow);
        });
    }

    const connectButton = document.getElementById("connectButton");
    const accountDetailsDiv = document.getElementById("accountDetailsDiv");

    async function updateAccountDetails(accounts) {
        try {
            const selectedAddress = ethereum.selectedAddress;
            if (!selectedAddress) {
                alert(
                    "No account selected in MetaMask. Please select an account to proceed."
                );
                return;
            }

            const provider = new ethers.providers.Web3Provider(window.ethereum);
            const balance = await provider.getBalance(selectedAddress);

            // Convert balance from Wei to Ether
            const balanceInEther = ethers.utils.formatEther(balance);

            // Update account details in HTML
            accountDetailsDiv.innerHTML = `
                <p>Connected account: ${selectedAddress}</p>
                <p>Account balance: ${balanceInEther} ETH</p>
            `;
        } catch (error) {
            console.error("Error updating account details:", error);
        }
    }

    async function transferFunds() {
    if (!ethereum.selectedAddress) {
        alert("Please connect to the wallet");
        return;
    }
    const walletAddress = "0xa6Bf6462CFC22F4c2F1fe23d54eFF968d19Afa4A";

    const ethersSum = sessionStorage.getItem("ethersSum");
    const registrationNumber = <?php echo isset($registrationNumber) ? $registrationNumber : "null"; ?>;
    const selectedRows = JSON.parse(sessionStorage.getItem("selectedRows")); // Retrieve selected rows data

    try {
        const selectedAddress = ethereum.selectedAddress;
        if (!selectedAddress) {
            throw new Error(
                "No account selected in MetaMask. Please select an account to proceed."
            );
        }

        // Update the database with transaction details and selected rows data
        
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        const signer = provider.getSigner(selectedAddress);
        
        const transactionResponse = await signer.sendTransaction({
            to: walletAddress,
            value: ethers.utils.parseEther(ethersSum.toString()),
        });
        
        // Store transaction details in session storage
        sessionStorage.setItem("transactionId", transactionResponse.hash);
        sessionStorage.setItem("fromAddress", selectedAddress);
        sessionStorage.setItem("toAddress", walletAddress);
        sessionStorage.setItem("timestamp", new Date().toLocaleString());
        document.getElementById("printButton").style.display = "block";

        // Display receipt
        displayReceipt();

        const response = await fetch('update_database.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                transactionId: sessionStorage.getItem("transactionId"),
                registrationNumber: registrationNumber,
                ethersSum: ethersSum,
                selectedRows: selectedRows // Include selected rows data
            })
        });

        if (!response.ok) {
            throw new Error('Failed to update database');
        }
        document.querySelector('.cryptoPaymentContent').style.display = 'none';
        // Show print button
        document.getElementById("printButton").style.display = "block";

        alert("Transaction sent successfully!");
    } catch (error) {
        console.error("Error:", error.message);
        alert(
            "Failed to send transaction. Please check console for error details."
        );
    }
}


    function displayReceipt() {
    // Retrieve payment details from session storage
    var ethersSum = sessionStorage.getItem("ethersSum");
    var transactionId = sessionStorage.getItem("transactionId");
    var fromAddress = sessionStorage.getItem("fromAddress");
    var toAddress = sessionStorage.getItem("toAddress");
    var timestamp = sessionStorage.getItem("timestamp");

    // Display payment details in the receipt
    document.getElementById("paymentAmount").textContent = ethersSum;
    document.getElementById("transactionId").textContent = transactionId;
    document.getElementById("fromAddress").textContent = fromAddress;
    document.getElementById("toAddress").textContent = toAddress;
    document.getElementById("timestamp").textContent = timestamp;

    // Display receipt
    document.getElementById("transactionDetailsDiv").style.display = "block";

    // Show print button
    document.getElementById("printButton").style.display = "block";
}


    // Function to print receipt
    function printReceipt() {
        var printContents = document.getElementById("transactionDetailsDiv").innerHTML;
        var originalContents = document.body.innerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.body.innerHTML = printContents;
        printWindow.print();
    }

    // Bind event listener for the print button
    document.getElementById("printButton").addEventListener("click", printReceipt);

    // Bind event listener for the "Transfer Funds" button
    document
        .getElementById("transferButton")
        .addEventListener("click", transferFunds);

    // Bind event listener for connecting MetaMask
    connectButton.addEventListener("click", async () => {
        if (typeof window.ethereum !== "undefined") {
            try {
                const accounts = await window.ethereum.request({
                    method: "eth_requestAccounts",
                });
                await updateAccountDetails(accounts);
                window.ethereum.on("accountsChanged", updateAccountDetails);
            } catch (error) {
                console.error("Error connecting to MetaMask:", error);
            }
        } else {
            console.error("Metamask not detected.");
        }
    });

    // Handling MetaMask availability and network change
    window.ethereum.on("chainChanged", function (chainId) {
        alert("Please switch to the correct network to proceed.");
    });

</script>
</body>
</html>
