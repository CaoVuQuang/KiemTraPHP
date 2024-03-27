<?php
session_start();

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

if(isset($_POST['submit'])) {
    $tenNV = $_POST['tenNV'];
    $phai = $_POST['phai'];
    $noiSinh = $_POST['noiSinh'];
    $maPhong = $_POST['maPhong'];
    $luong = $_POST['luong'];

    $sql = "INSERT INTO Nhanvien (Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong)
            VALUES ('$tenNV', '$phai', '$noiSinh', '$maPhong', '$luong')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>
    <h1>Add New Employee</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="tenNV">Tên Nhân Viên:</label><br>
        <input type="text" id="tenNV" name="tenNV"><br>
        <label for="phai">Giới Tính:</label><br>
        <input type="text" id="phai" name="phai"><br>
        <label for="noiSinh">Nơi Sinh:</label><br>
        <input type="text" id="noiSinh" name="noiSinh"><br>
        <label for="maPhong">Mã Phòng:</label><br>
        <input type="text" id="maPhong" name="maPhong"><br>
        <label for="luong">Lương:</label><br>
        <input type="text" id="luong" name="luong"><br><br>
        <input type="submit" name="submit" value="Add Employee">
    </form>
</body>
</html>
