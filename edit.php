<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['Id'])) {
    $id = $_GET['Id'];
    // Fetch employee details based on ID
    $sql = "SELECT * FROM Nhanvien WHERE Ma_NV=$Id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display edit form with pre-filled data
?>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['Ma_NV']; ?>">
            Name: <input type="text" name="name" value="<?php echo $row['Ten_NV']; ?>"><br>
            Gender: <input type="text" name="gender" value="<?php echo $row['Phai']; ?>"><br>
            Place of Birth: <input type="text" name="place_of_birth" value="<?php echo $row['Noi_Sinh']; ?>"><br>
            Department: <input type="text" name="department" value="<?php echo $row['Ma_Phong']; ?>"><br>
            Salary: <input type="text" name="salary" value="<?php echo $row['Luong']; ?>"><br>
            <input type="submit" value="Submit">
        </form>
<?php
    } else {
        echo "Employee not found.";
    }
} else {
    echo "Invalid request.";
}
$conn->close();
?>
