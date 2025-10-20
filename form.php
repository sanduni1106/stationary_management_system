<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the section value (which table to insert into)
    $section = $_POST['vot_num'];

    // Define an associative array to map sections to table names
    $sectionToTable = [
        'ආයතන අංශය' => 'establishment_section', // Establishment section
        'ගිණුම් අංශය' => 'account_section', // Accounts section
        'ක්‍රීඩා අංශය' => 'sports_section', // Sports section
        'සංවර්ධන අංශය' => 'development_section', // Development section
        'ග්‍රාම සංවර්ධන අංශය' => 'ruraldev_section', // Rural Development section
        'සංස්කෘතික අංශය' => 'cultural_section' // Cultural section
    ];

    // Check if the section exists in the array
    if (array_key_exists($section, $sectionToTable)) {
        $tableName = $sectionToTable[$section];
    } else {
        echo "Invalid section";
        exit;
    }

    // Extract and sanitize form data
    $date = isset($_POST['date']) ? mysqli_real_escape_string($conn, $_POST['date']) : '';
    $employeenum = isset($_POST['employeenum']) ? mysqli_real_escape_string($conn, $_POST['employeenum']) : '';
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';

    // Pens data
    $bluePen = isset($_POST['bluePen']) ? (int)$_POST['bluePen'] : 0;
    $blackPen = isset($_POST['blackPen']) ? (int)$_POST['blackPen'] : 0;
    $redPen = isset($_POST['redPen']) ? (int)$_POST['redPen'] : 0;

    // A4 Paper data
    $a4paper = isset($_POST['a4paper']) ? (int)$_POST['a4paper'] : 0;
    $a4orange = isset($_POST['a4orange']) ? (int)$_POST['a4orange'] : 0;

    // File data
    $file1 = isset($_POST['file1']) ? (int)$_POST['file1'] : 0;
    $file2 = isset($_POST['file2']) ? (int)$_POST['file2'] : 0;
    $fileTags = isset($_POST['fileTags']) ? (int)$_POST['fileTags'] : 0;

    // Cover data
    $cover6x3 = isset($_POST['cover6x3']) ? (int)$_POST['cover6x3'] : 0;
    $cover9x4 = isset($_POST['cover9x4']) ? (int)$_POST['cover9x4'] : 0;
    $cover10x7 = isset($_POST['cover10x7']) ? (int)$_POST['cover10x7'] : 0;
    $cover10x15 = isset($_POST['cover10x15']) ? (int)$_POST['cover10x15'] : 0;

    // Sticky Pack data
    $stickyPack = isset($_POST['stickyPack']) ? (int)$_POST['stickyPack'] : 0;
    $stickyPackSheets = isset($_POST['stickyPackSheets']) ? (int)$_POST['stickyPackSheets'] : 0;

    // CR Paper data
    $crPaper40 = isset($_POST['crPaper40']) ? (int)$_POST['crPaper40'] : 0;
    $crPaper80 = isset($_POST['crPaper80']) ? (int)$_POST['crPaper80'] : 0;
    $crPaper120 = isset($_POST['crPaper120']) ? (int)$_POST['crPaper120'] : 0;
    $crPaper160 = isset($_POST['crPaper160']) ? (int)$_POST['crPaper160'] : 0;

    // Other stationery items
    $tippex = isset($_POST['tippex']) ? (int)$_POST['tippex'] : 0;
    $cellotape = isset($_POST['cellotape']) ? (int)$_POST['cellotape'] : 0;
    $pinsPack = isset($_POST['pinsPack']) ? (int)$_POST['pinsPack'] : 0;
    $fileClip = isset($_POST['fileClip']) ? (int)$_POST['fileClip'] : 0;
    $stapler = isset($_POST['stapler']) ? (int)$_POST['stapler'] : 0;
    $manilaPapers = isset($_POST['manilaPapers']) ? (int)$_POST['manilaPapers'] : 0;
    $carbonPaper = isset($_POST['carbonPaper']) ? (int)$_POST['carbonPaper'] : 0;
    $halfSheet = isset($_POST['halfSheet']) ? (int)$_POST['halfSheet'] : 0;
    $highlighter = isset($_POST['highlighter']) ? (int)$_POST['highlighter'] : 0;
    $pencils = isset($_POST['pencils']) ? (int)$_POST['pencils'] : 0;
    $eraser = isset($_POST['eraser']) ? (int)$_POST['eraser'] : 0;
    $notebook = isset($_POST['notebook']) ? (int)$_POST['notebook'] : 0;
    $rulePaper = isset($_POST['rulePaper']) ? (int)$_POST['rulePaper'] : 0;
    $legalPaper = isset($_POST['legalPaper']) ? (int)$_POST['legalPaper'] : 0;
    $glueBottles = isset($_POST['glueBottles']) ? (int)$_POST['glueBottles'] : 0;
    $inkBottle = isset($_POST['inkBottle']) ? (int)$_POST['inkBottle'] : 0;

    $sql = "INSERT INTO $tableName (date, employeenum, name, bluePen, blackPen, redPen, a4paper, a4orange, file1, file2, fileTags, 
    cover6x3, cover9x4, cover10x7, cover10x15, stickyPack, stickyPackSheets, crPaper40, crPaper80, crPaper120, crPaper160, 
    tippex, cellotape, pinsPack, fileClip, stapler, manilaPapers, carbonPaper, halfSheet, highlighter, pencils, eraser, 
    notebook, rulePaper, legalPaper, glueBottles, inkBottle)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters (s = string, i = integer)
mysqli_stmt_bind_param($stmt, "sssiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", 
    $date, $employeenum, $name,
    $bluePen, $blackPen, $redPen, $a4paper, $a4orange, $file1, $file2, $fileTags,  
    $cover6x3, $cover9x4, $cover10x7, $cover10x15, $stickyPack, 
    $stickyPackSheets, $crPaper40, $crPaper80, $crPaper120, $crPaper160, 
    $tippex, $cellotape, $pinsPack, $fileClip, $stapler, 
    $manilaPapers, $carbonPaper, $halfSheet, $highlighter, $pencils, 
    $eraser, $notebook, $rulePaper, $legalPaper, $glueBottles, $inkBottle);


// Execute the statement
if (mysqli_stmt_execute($stmt)) {
// Success message
echo "<script>alert('Record added successfully!'); window.location.href='form.html';</script>";
} else {
echo "Error: " . mysqli_error($conn);
}

// Close the statement
mysqli_stmt_close($stmt);

}
?>
