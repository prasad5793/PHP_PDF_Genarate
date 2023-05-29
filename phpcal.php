<?php
// Connect to the database
$servername = 'localhost';
$username = 'root';
$password = 'put here DB PW';
$dbname = 'put here DB name';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database to fetch the data
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Generate the HTML for printing
$html = '<html>
<head>
    <style>
        @page { size: A4; }
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h1>Print A4 Example</h1>
    <table>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
        </tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['firstname'] . '</td>
                    <td>' . $row['lastname'] . '</td>
                    <td>' . $row['username'] . '</td>
                </tr>';
    }
} else {
    $html .= '<tr><td colspan="3">No data available</td></tr>';
}

$html .= '</table>
</body>
</html>';

// Close the database connection
$conn->close();

// Generate PDF and output it for printing
require_once('vendor/tcpdf.php'); // Include the library for PDF generation, e.g., TCPDF or Dompdf

// Create a new PDF instance and set the document properties
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');
//$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('W Buddhika Prasad');
$pdf->SetTitle('Print A4 Example');
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// Add a page and set the content
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF for printing
$pdf->Output('print_a4_example.pdf', 'I');
