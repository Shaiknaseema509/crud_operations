<?php
require 'vendor/autoload.php'; // Make sure PhpSpreadsheet is installed and included

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if the export action is triggered
if (isset($_POST['export']) && $_POST['export'] == 'true') {

    // Include database connection
    include_once("includes/config.php");

    // Fetch the search query or fetch all records
    $search_term = isset($_POST['search']) ? $_POST['search'] : '';

    // Query based on the search term (filter results by search term)
    $query = "SELECT `id`, `name`, `email`, `phone`, `status` FROM `excel_import`";
    if ($search_term != '') {
        // Apply search filter if there is a search term
        $query .= " WHERE `status` LIKE '%$search_term%'";
    }

    // Execute query
    $rows = mysqli_query($mysqli, $query);

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set column headers
    $sheet->setCellValue('A1', 'Id');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Phone');
    $sheet->setCellValue('E1', 'Status');

    // Populate data from the database
    $rowNum = 2; // Starting row after header
    while ($result = mysqli_fetch_assoc($rows)) {
        $sheet->setCellValue('A' . $rowNum, $result['id']);
        $sheet->setCellValue('B' . $rowNum, $result['name']);
        $sheet->setCellValue('C' . $rowNum, $result['email']);
        $sheet->setCellValue('D' . $rowNum, $result['phone']);
        $sheet->setCellValue('E' . $rowNum, $result['status']);
        $rowNum++;
    }

    // Create a writer instance to output the spreadsheet
    $writer = new Xlsx($spreadsheet);

    // Set the header for the download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="lms_list.xlsx"');
    header('Cache-Control: max-age=0');

    // Write the file to the browser
    $writer->save('php://output');
    exit;
}
?>
