<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details Search</title>
</head>
<body>
    <h1>Search Student Details</h1>
    <form id="searchForm" method="post" action="search.php">
        <label for="regNumber">Enter Registration Number:</label>
        <input type="text" id="regNumber" name="regNumber" required>
        <button type="submit">Submit</button>
    </form>
    
    <h2>Student Details</h2>
    <table border="1">
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
        <tbody id="resultTable">
            <!-- Results will be populated here -->
        </tbody>
    </table>
</body>
</html>
