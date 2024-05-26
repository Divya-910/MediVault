<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <style>
        
        button {
            width: 20%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
    </style>

</head>
<body>
    <?php

    // Check if the form is submitted and file is uploaded
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {

        // Check for file upload errors
        if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {

            // Maximum file size allowed (10MB)
            $max_file_size = 10 * 1024 * 1024; // 10MB in bytes

            // Get the file information
            $file_name = $_FILES["file"]["name"];
            $file_size = $_FILES["file"]["size"];
            $file_tmp = $_FILES["file"]["tmp_name"];

            // Check if the file size is less than or equal to 10MB
            if ($file_size <= $max_file_size) {

                // Connect to MySQL database (replace placeholders with actual database credentials)
                $conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Escape special characters to prevent SQL injection
                $file_name = $conn->real_escape_string($file_name);
                $file_data = file_get_contents($file_tmp);
                $file_data = $conn->real_escape_string($file_data);
                
                // Get the user ID from the session (assuming it's stored as $_SESSION['user_id'])
                
                $id = $_settings->userdata('id');

                    // Insert file data along with user ID into the database
                    $sql = "INSERT INTO files (file_name, file_data, user_id) VALUES ('$file_name', '$file_data', '$id')";
                    if ($conn->query($sql) === TRUE) {
                        // Move uploaded file to a directory on the server
                        $upload_directory = "uploads/";
                        $upload_path = $upload_directory . $file_name;
                        if (move_uploaded_file($file_tmp, $upload_path)) {
                            echo "File uploaded successfully.";
                        } else {
                            echo "Error moving file to directory.";
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                
                // Close the database connection
                $conn->close();

            } else {
                echo 'File size must not be more than 10MB';
            }

        } else {
            echo 'Error uploading file: ' . $_FILES["file"]["error"];
        }

    } else {
        // Display the file upload form
        ?>
        <div style="border:3px solid #000;padding-left:35px;padding-right:15px;padding-top:5px;margin-left:300px;margin-right:400px;margin-top:50px;">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="choosefile"style="color:black;font-size:x-large;padding-left:30px;padding-top:20px;padding-bottom:15px;">Choose the file you want to upload</label>
            <br>
            <br>
            <input type="file" name="file">
            <button type="submit" name="submit"style="background-color:blue;color:white;font-size:large;">Upload</button>
        </form></div>
        <?php
    }
    ?>
</body>
</html>