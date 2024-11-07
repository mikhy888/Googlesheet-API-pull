<?php 
    /* Template name: Verify Certificate */
?>

    <?php
  
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regNumber = trim($_GET['regNumber']);
   
    //$regNumber = trim("878787");

    // Configuration
    $spreadsheetId = ''; // Enter spred sheet ID
    $apiKey = ''; // Enter API Key here
    $range = 'A:I'; // Adjust the range according to your sheet structure

    // Google Sheets API URL
    $url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId/values/$range?key=$apiKey";

    // Fetch data from Google Sheets
    $response = file_get_contents($url);
    

    // Check if the API call was successful
    if ($response === FALSE) {
        
        $error = error_get_last();
        print_r($error);
        die('Error occurred while fetching data from Google Sheets.');
    }

    $data = json_decode($response, true);

    // Check if the data retrieval was successful and contains values
    if (!isset($data['values']) || empty($data['values'])) {
        die('No data found in the specified range.');
    }

    $rows = $data['values'];
    $found = false;
    

    echo '<table border="1">
            <thead>
                <tr>
                    <th>Register Number</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Passport</th>
                    <th>Category</th>
                    <th>Center</th>
                    <th>Grade</th>
                    <th>Date</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>';


    foreach ($rows as $index => $row) {
        // Ensure the row has enough columns
        if (count($row) < 9) {
            continue;
        }
        echo print_r(trim($row[0]));
        
        // Compare registration numbers (case-insensitive comparison)
        if (strcasecmp(trim($row[0]), $regNumber) === 0) { // Assuming D column is the 3rd index in range B:F
            $found = true;
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row[0]) . '</td>';
            echo '<td>' . htmlspecialchars($row[1]) . '</td>';
            echo '<td>' . htmlspecialchars($row[2]) . '</td>';
            echo '<td>' . htmlspecialchars($row[3]) . '</td>';
            echo '<td>' . htmlspecialchars($row[4]) . '</td>';
            echo '<td>' . htmlspecialchars($row[5]) . '</td>';
            echo '<td>' . htmlspecialchars($row[6]) . '</td>';
            echo '<td>' . htmlspecialchars($row[7]) . '</td>';
            echo '<td>' . htmlspecialchars($row[8]) . '</td>';
            echo '</tr>';
        }
    }

    if (!$found) {
        echo '<tr><td colspan="6">Registration Number not found!</td></tr>';
    }

    echo '</tbody></table>';
//}

?>
