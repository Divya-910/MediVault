<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Recommendation Form</title>
</head>
<body>
    <h1>Find Doctors</h1>
    <form action="recommendation.php" method="POST">
        <label for="location">City:</label>
        <select id="location">
            <option value="New York">New York</option>
            <option value="Los Angeles">Los Angeles</option>
        </select><br><br>

        <label for="specialty">Specialty:</label>
        <select id="specialty">
            <option value="Cardiologist">Cardiologist</option>
            <option value="Dermatologist">Dermatologist</option>
        </select><br><br>

        <button type="submit">Find Doctors</button>
    </form>
</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Recommendation Form</title>
</head>
<body>
    <h1>Find Doctors</h1>
    <form action="recommendation.php" method="POST">
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br><br>

        <label for="specialty">Specialty:</label>
        <input type="text" id="specialty" name="specialty" required><br><br>

        <button type="submit">Find Doctors</button>
    </form>
</body>
</html>