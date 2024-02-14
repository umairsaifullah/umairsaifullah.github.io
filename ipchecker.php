<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate the IP address
    $ip = $_POST['ip'];
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        // Establish a database connection (replace with your actual database credentials)
        $db_host = 'hayzeltech.com';
        $db_user = 'hayzelte_IPDatabase';
        $db_pass = 'hayzelte_IPDatabase';
        $db_name = 'hayzelte_IPDatabase';

        // Establish a database connection (replace with your actual database credentials)
        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // Check if the IP already exists in the database
        $sql = "SELECT * FROM ip_addresses WHERE ip = '$ip'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // IP already exists
            echo "Duplicate IP";
        } else {
            
            $insert_sql = "INSERT INTO ip_addresses (ip) VALUES ('$ip')";
            if (mysqli_query($conn, $insert_sql)) {
                echo "IP Address saved successfully!";
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        // Invalid IP format
        //header('HTTP/1.1 400 Bad Request');
        echo "Enter a valid IP address";
    }
}
?>
