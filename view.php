<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .content-box {
            border: 2px solid #000; /* Border of the box */
            padding: 20px;         /* Space inside the box */
            margin: 20px auto;     /* Center the box on the page */
            max-width: 600px;      /* Maximum width of the box */
            text-align: center;    /* Center the text inside the box */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            border-radius: 10px;   /* Rounded corners */
        }
        .file-link {
            background-color: #f0f0f0;
            color: #333;
            padding: 5px;
            display: inline-block;
            margin-bottom: 5px;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid black;
        }
        .delete-button {
            display: inline;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="content-box">
        <h1>These are files you uploaded</h1>
        <h5>(You can delete them, if they are no longer needed)</h5>
        <br>

        <?php
        // Check if the user is logged in
        $id = $_settings->userdata('id');

        // Connect to MySQL database (replace placeholders with actual database credentials)
        $conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if delete request is made
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_file'])) {
            $file_to_delete = $_POST['delete_file'];
            
            // Delete file from database
            $sql_delete = "DELETE FROM files WHERE file_name = '$file_to_delete' AND user_id = '$id'";
            if ($conn->query($sql_delete) === TRUE) {
                // Delete file from server (if applicable)
                $file_path = 'uploads/' . $file_to_delete;
                if (file_exists($file_path)) {
                    unlink($file_path); // Delete file from server
                }
                echo "File deleted successfully.";
            } else {
                echo "Error deleting file: " . $conn->error;
            }
        }

        // Fetch files uploaded by the current user
        $sql = "SELECT file_name FROM files WHERE user_id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display files for the current user
            while ($row = $result->fetch_assoc()) {
                // Display file name and delete button
                echo "<div>";
                echo "<a href='uploads/" . $row['file_name'] . "' target='_blank' class='file-link'>" . $row['file_name'] . "</a>";
                echo "<form method='POST' class='delete-button'>";
                echo "<input type='hidden' name='delete_file' value='" . $row['file_name'] . "'>";
                echo "<button type='submit'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No files found for this user.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
