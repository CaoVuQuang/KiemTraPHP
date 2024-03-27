<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <a href="add.php"><button>Thêm Nhân Viên</button></a>
</body>

</html>


<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";
$employeesPerPage = 5;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $employeesPerPage;

if(isset($_GET['logout'])) {
    // Destroy session
    session_unset();
    session_destroy();
    // Redirect to login page
    echo "Logout clicked"; // Debugging output
    header("Location: login.php");
    exit();
}







if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM Nhanvien WHERE Ma_NV=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
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



$sql = "SELECT * FROM Nhanvien LIMIT $start, $employeesPerPage";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output table header
  echo "<table>";
  echo "<tr>
  <th>Mã Nhân Viên</th>
  <th>Tên Nhân Viên</th>
  <th>Giới Tính</th>
  <th>Nơi Sinh</th>
  <th>Tên Phòng</th>
  <th>Lương</th>
  <th>Thao Tác</th>
</tr>";

  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["Ma_NV"] . "</td>";
    echo "<td>" . $row["Ten_NV"] . "</td>";
    echo "<td>";
    if($row["Phai"] == "NAM") {
      echo "<img src='https://cdn-icons-png.flaticon.com/128/709/709699.png' alt='Man' width='50' height='50'>";
    } else {
      echo "<img src='https://cdn-icons-png.flaticon.com/128/563/563230.png' alt='Woman' width='50' height='50'>";
    }
    echo "</td>";
    echo "<td>" . $row["Noi_Sinh"] . "</td>";
    echo "<td>" . $row["Ma_Phong"] . "</td>";
    echo "<td>" . $row["Luong"] . "</td>";
    echo "<td><a href='edit.php?id=".$row["Ma_NV"]."'>Edit</a> | <a href='?action=delete&id=".$row["Ma_NV"]."' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td>";
    echo "</tr>";
  }
  echo "</table>";

  $sql = "SELECT COUNT(*) AS total FROM Nhanvien";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalPages = ceil($row["total"] / $employeesPerPage);
    echo "<br>";
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='?page=$i'>$i</a> ";
    }

} else {
  echo "0 results";
}
$conn->close();




?>



<a href="?logout=true">Logout</a>

<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }
  th, td {
    padding: 8px;
    text-align: left;
  }
  th {
    background-color: #f2f2f2;
  }
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>
