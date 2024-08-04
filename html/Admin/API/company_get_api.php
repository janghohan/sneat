<?php

include '../dbConnect.php';


$companyName = $_POST['companyName'];

$sql = "SELECT * FROM company_list WHERE company_name='$companyName'";

$result = $conn->query($sql);

// Check if any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row; // Append each row to the data array
    }
    echo json_encode(array('success' => true, 'data' => $data));
} else {
    echo "0 results";
}



?>