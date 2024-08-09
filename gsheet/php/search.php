
   <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regNumber = trim($_POST['regNumber']);

    // Configuration
    $spreadsheetId = ''; // Enter spred sheet ID
    $apiKey = ''; // Enter API Key here
    $range = 'B:F'; // Adjust the range according to your sheet structure

    // Google Sheets API URL
    $url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId/values/$range?key=$apiKey";

    // Fetch data from Google Sheets
    $response = file_get_contents($url);
    

    // Check if the API call was successful
    if ($response === FALSE) {
        
        $error = error_get_last();
    print_r($error);
        //die('Error occurred while fetching data from Google Sheets.');
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
                    <th>Serial Number</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Registration Number</th>
                    <th>Section</th>
                    <th>Additional Details</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($rows as $index => $row) {
        // Ensure the row has enough columns
        if (count($row) < 4) {
            continue;
        }

        // Compare registration numbers (case-insensitive comparison)
        if (strcasecmp(trim($row[2]), $regNumber) === 0) { // Assuming D column is the 3rd index in range B:F
            $found = true;
            echo '<tr>';
            echo '<td>' . ($index + 1) . '</td>';
            echo '<td>' . htmlspecialchars($row[0]) . '</td>';
            echo '<td>' . htmlspecialchars($row[1]) . '</td>';
            echo '<td>' . htmlspecialchars($row[2]) . '</td>';
            echo '<td>' . htmlspecialchars($row[3]) . '</td>';
            echo '<td>' . (isset($row[4]) ? htmlspecialchars($row[4]) : '') . '</td>';
            echo '</tr>';
        }
    }

    if (!$found) {
        echo '<tr><td colspan="6">Registration Number not found!</td></tr>';
    }

    echo '</tbody></table>';
}
?>
