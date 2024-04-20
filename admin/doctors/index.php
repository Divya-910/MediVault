<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Recommendation System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        .img-thumb-path {
            width: 100px;
            height: 80px;
            object-fit: scale-down;
            object-position: center center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card card-outline card-primary rounded-0 shadow">
            <div class="card-header">
                <h3 class="card-title">List of Doctors</h3>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <table class="table table-bordered table-hover table-striped">
                        <colgroup>
                            <col width="5%">
                            <col width="30%">
                            <col width="25%">
                            <col width="20%">
                            <col width="20%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-primary text-light">
                                <th>#</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>Specialization</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming $conn is your database connection
                            $query = $conn->query("SELECT * FROM doctors ORDER BY id ASC");
                            $i = 1;
                            while ($row = $query->fetch_assoc()) :
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class=""><?php echo $row['name']; ?></td>
                                    <td class=""><?php echo $row['city']; ?></td>
                                    <td class=""><?php echo $row['specialization']; ?></td>
                                    <td class=""><?php echo $row['contact_number']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
