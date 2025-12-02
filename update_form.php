
<style>
    body {
                        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                        margin: 0;
                        padding: 50px;
                        background-color: rgb(210, 200, 216);

                        /* Centering the form both horizontally and vertically */
                        display: flex;
                        justify-content: center;
                        align-items: center;
                       
                    }

                    /* Styling the new window's form container */
                    .form {
                        width: 50%;
                        max-width: 450px;
                        padding: 30px;
                        background-color: rgb(223, 223, 223);
                        border-radius: 10px;
                        border: 1px solid rgb(128, 110, 151); /* Border */
                        box-shadow: 0 50px 30px rgba(8, 7, 7, 0.1);
                        box-sizing: border-box;
                        position: relative; /* Ensure the container position is visible */
                        z-index: 1; /* Ensure it's not hidden behind other elements */
                    }

                    /* Heading */
                    h1 {
                        font-size: 28px;
                        color: #333333;
                        text-align: center;
                        margin-bottom: 30px;
                        font-weight: 600;
                    }

                    /* Label Styling */
                    label {
                        font-size: 16px;
                        color: #555;
                        display: block;
                        margin-bottom: 8px;
                        font-weight: 500;
                    }

                    /* Input Fields */
                    input[type="text"], input[type="number"] {
                        width: 100%; /* Adjusted to full width */
                        padding: 14px 18px;
                        font-size: 16px;
                        border: 1px solid #ccc;
                        border-radius: 8px;
                        margin-bottom: 20px;
                        box-sizing: border-box;
                        background-color: #fafafa;
                        transition: border-color 0.3s ease-in-out;
                    }

                    /* Focused Input Fields */
                    input[type="text"]:focus, input[type="number"]:focus {
                        border-color: rgb(231, 223, 235);
                        outline: none;
                        background-color: #ffffff;
                    }

                    /* Submit Button Styling */
                    button {
                        width: 100%;
                        padding: 14px 20px;
                        font-size: 18px;
                        background-color: rgb(67, 0, 143);
                        color: #ffffff;
                        border: none;
                        border-radius: 8px;
                        cursor: pointer;
                        transition: background-color 0.3s ease-in-out;
                        font-weight: 600;
                    }

                    /* Button Hover Effect */
                    button:hover {
                        background-color:rgb(78, 0, 179);
                    }

                    /* Form Layout */
                    form {
                        display: flex;
                        flex-direction: column;
                    }

                    /* Add spacing between each form element */
                    form > label,
                    form > input,
                    form > button {
                        margin-bottom: 20px;
                    }

                    /* Responsive Styling for Smaller Screens */
                    @media (max-width: 600px) {
                        .form {
                            padding: 20px;
                        }

                        h1 {
                            font-size: 24px;
                        }

                        input[type="text"], input[type="number"], button {
                            font-size: 14px;
                        }
                    }
                </style>
               


<?php

include('dbconnect.php'); // Include your database connection file

// Debug: check what parameters are being passed
var_dump($_GET); // Outputs all the query parameters passed in the URL

// If the parameters are set correctly, this will display their values
$id = isset($_GET['id']) ? $_GET['id'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';

if ($id && $branch) {
    // Assuming the branch table is passed as a parameter in the URL
    $sql = "SELECT * FROM $branch WHERE id = $id"; // Use proper escaping for table names and values
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the row data
    } else {
        echo "<p>Record not found.</p>";
    }
}
?>



<!-- The rest of the update form -->
<div class="update-form-container">
    <h2>Update Record</h2>

    <form action="update_process.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

  
    <label for="bluePen">Blue Pen:</label>
    <input type="number" id="bluePen" name="bluePen" value="<?php echo htmlspecialchars($row['bluePen']); ?>"><br>

    <label for="blackPen">Black Pen:</label>
    <input type="number" id="blackPen" name="blackPen" value="<?php echo htmlspecialchars($row['blackPen']); ?>"><br>

    <label for="redPen">Red Pen:</label>
    <input type="number" id="redPen" name="redPen" value="<?php echo htmlspecialchars($row['redPen']); ?>"><br>

   
    <label for="a4paper">A4 Paper:</label>
    <input type="number" id="a4paper" name="a4paper" value="<?php echo htmlspecialchars($row['a4paper']); ?>"><br>

    <label for="a4orange">A4 Orange:</label>
    <input type="number" id="a4orange" name="a4orange" value="<?php echo htmlspecialchars($row['a4orange']); ?>"><br>

    
    <label for="file1">File 1:</label>
    <input type="number" id="file1" name="file1" value="<?php echo htmlspecialchars($row['file1']); ?>"><br>

    <label for="file2">File 2:</label>
    <input type="number" id="file2" name="file2" value="<?php echo htmlspecialchars($row['file2']); ?>"><br>

    
    <label for="fileTags">File Tags:</label>
    <input type="number" id="fileTags" name="fileTags" value="<?php echo htmlspecialchars($row['fileTags']); ?>"><br>

  
    <label for="cover6x3">Cover 6x3:</label>
    <input type="number" id="cover6x3" name="cover6x3" value="<?php echo htmlspecialchars($row['cover6x3']); ?>"><br>

    <label for="cover9x4">Cover 9x4:</label>
    <input type="number" id="cover9x4" name="cover9x4" value="<?php echo htmlspecialchars($row['cover9x4']); ?>"><br>

    <label for="cover10x7">Cover 10x7:</label>
    <input type="number" id="cover10x7" name="cover10x7" value="<?php echo htmlspecialchars($row['cover10x7']); ?>"><br>

    <label for="cover10x15">Cover 10x15:</label>
    <input type="number" id="cover10x15" name="cover10x15" value="<?php echo htmlspecialchars($row['cover10x15']); ?>"><br>

  
    <label for="stickyPack">Sticky Pack:</label>
    <input type="number" id="stickyPack" name="stickyPack" value="<?php echo htmlspecialchars($row['stickyPack']); ?>"><br>

    <label for="stickyPackSheets">Sticky Pack Sheets:</label>
    <input type="number" id="stickyPackSheets" name="stickyPackSheets" value="<?php echo htmlspecialchars($row['stickyPackSheets']); ?>"><br>

   
    <label for="crPaper40">CR Paper 40:</label>
    <input type="number" id="crPaper40" name="crPaper40" value="<?php echo htmlspecialchars($row['crPaper40']); ?>"><br>

    <label for="crPaper80">CR Paper 80:</label>
    <input type="number" id="crPaper80" name="crPaper80" value="<?php echo htmlspecialchars($row['crPaper80']); ?>"><br>

    <label for="crPaper120">CR Paper 120:</label>
    <input type="number" id="crPaper120" name="crPaper120" value="<?php echo htmlspecialchars($row['crPaper120']); ?>"><br>

    <label for="crPaper160">CR Paper 160:</label>
    <input type="number" id="crPaper160" name="crPaper160" value="<?php echo htmlspecialchars($row['crPaper160']); ?>"><br>

   
    <label for="tippex">Tippex:</label>
    <input type="number" id="tippex" name="tippex" value="<?php echo htmlspecialchars($row['tippex']); ?>"><br>

    <label for="cellotape">Cellotape:</label>
    <input type="number" id="cellotape" name="cellotape" value="<?php echo htmlspecialchars($row['cellotape']); ?>"><br>

    <label for="pinsPack">Pins Pack:</label>
    <input type="number" id="pinsPack" name="pinsPack" value="<?php echo htmlspecialchars($row['pinsPack']); ?>"><br>

    <label for="fileClip">File Clip:</label>
    <input type="number" id="fileClip" name="fileClip" value="<?php echo htmlspecialchars($row['fileClip']); ?>"><br>

    <label for="stapler">Stapler:</label>
    <input type="number" id="stapler" name="stapler" value="<?php echo htmlspecialchars($row['stapler']); ?>"><br>

    <label for="manilaPapers">Manila Papers:</label>
    <input type="number" id="manilaPapers" name="manilaPapers" value="<?php echo htmlspecialchars($row['manilaPapers']); ?>"><br>

    <label for="carbonPaper">Carbon Paper:</label>
    <input type="number" id="carbonPaper" name="carbonPaper" value="<?php echo htmlspecialchars($row['carbonPaper']); ?>"><br>

    <label for="halfSheet">Half Sheet:</label>
    <input type="number" id="halfSheet" name="halfSheet" value="<?php echo htmlspecialchars($row['halfSheet']); ?>"><br>

    <label for="highlighter">Highlighter:</label>
    <input type="number" id="highlighter" name="highlighter" value="<?php echo htmlspecialchars($row['highlighter']); ?>"><br>

    <label for="pencils">Pencils:</label>
    <input type="number" id="pencils" name="pencils" value="<?php echo htmlspecialchars($row['pencils']); ?>"><br>

    <label for="eraser">Eraser:</label>
    <input type="number" id="eraser" name="eraser" value="<?php echo htmlspecialchars($row['eraser']); ?>"><br>

    <label for="notebook">Notebook:</label>
    <input type="number" id="notebook" name="notebook" value="<?php echo htmlspecialchars($row['notebook']); ?>"><br>

    <label for="rulePaper">Rule Paper:</label>
    <input type="number" id="rulePaper" name="rulePaper" value="<?php echo htmlspecialchars($row['rulePaper']); ?>"><br>

    <label for="legalPaper">Legal Paper:</label>
    <input type="number" id="legalPaper" name="legalPaper" value="<?php echo htmlspecialchars($row['legalPaper']); ?>"><br>

    <label for="glueBottles">Glue Bottles:</label>
    <input type="number" id="glueBottles" name="glueBottles" value="<?php echo htmlspecialchars($row['glueBottles']); ?>"><br>

    <label for="inkBottle">Ink Bottle:</label>
    <input type="number" id="inkBottle" name="inkBottle" value="<?php echo htmlspecialchars($row['inkBottle']); ?>"><br>

    <button type="submit">Update Record</button>
</form>

</div>
