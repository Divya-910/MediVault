<?php
// Include config file
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('./config.php');

// Fetch test names from the database
$tests = $conn->query("SELECT * FROM BloodReports  ORDER BY ReportName ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Test Analyzer</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            color: #555;
        }

        .form-control {
            margin-bottom: 15px;
        }
        select {
            width: 100%;
            margin-bottom: 25px;
            border: 20px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 20px;
            
        }
       

        .input-group-addon {
            width: 50px; /* Adjust this value as needed */
            height: 38px; /* Same as input height */
        }


        .btn-success,
        .btn-danger {
            width: 38px;
            height: 38px;
            font-size: 18px;
            padding: 6px 10px;
            margin-top: 10px;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-container button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Blood Test Analyzer</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="analyse.php" method="post" class="mb-4"  >
                    <div class="form-row" id="testRows">
                        <div class="form-group col-md-6">
                            <label for="testName">Select Test Name:</label>
                            <!-- Use Select2 for the test name dropdown -->
                            <select  name="testName[]" class="form-control form-control-lg equal-size" style="width: 1000px;">
                                <?php while($row= $tests->fetch_assoc()): ?>
                                <option value="<?= $row['ReportName'] ?>"><?= $row['ReportName'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="testValue">Enter Test Value:</label>
                            <div class="input-group">
                                <input type="text" name="testValue[]" class="form-control form-control-lg equal-size">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Units</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-success add-row">+</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Analyze</button>
                    </div>
                </form>

                
            </div>
        </div>
    </div>

    <!-- Include jQuery and Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for initial test selection
            $('select[name="testName[]"]').select2({
                width: '100%',
                placeholder: 'Select Test Name',
            });

            // Add row on plus button click
            $('.add-row').click(function() {
                var newRow = `
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="testName">Select Test Name:</label>
                            <select name="testName[]" class="form-control form-control-lg equal-size" style="width: 100%;">
                                <?php $tests->data_seek(0); while($row= $tests->fetch_assoc()): ?>
                                <option value="<?= $row['ReportName'] ?>"><?= $row['ReportName'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="testValue">Enter Test Value:</label>
                            <div class="input-group">
                                <input type="text" name="testValue[]" class="form-control form-control-lg equal-size">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Units</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-danger remove-row">-</button>
                        </div>
                    </div>
                `;
                $('#testRows').append(newRow);
                // Reinitialize Select2 for new row
                $('select[name="testName[]"]').select2({
                    width: '100%',
                    placeholder: 'Select Test Name',
                });
            });

            // Remove row on minus button click
            $('#testRows').on('click', '.remove-row', function() {
                $(this).closest('.form-row').remove();
            });

            // Handle form submission
            $('#analysisForm').submit(async function(event) {
                event.preventDefault();
                const form = $(this);
                const data = new FormData(form[0]);
                const response = await fetch('/analyze', {
                    method: 'POST',
                    body: data
                });
                const result = await response.json();
                $('#analysisResult').html(result.message);
            });
        });
    </script>
</body>
</html>