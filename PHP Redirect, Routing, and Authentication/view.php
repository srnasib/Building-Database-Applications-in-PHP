
<head></head><body> <table border="5">
<div class="container">
<p>
<body>
<?php 
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name'])   ) {
  die('Not logged in');
 
}


$st= $pdo->query("SELECT * FROM autos");
while ($row =$st->fetch(PDO::FETCH_ASSOC))
{
echo "<tr><td>";
echo ($row['make']);
echo ("</td><td>");
echo ($row['year']);
echo ("</td><td>");
echo ($row['mileage']);
echo ("</td></tr>\n");
}
?>

</p>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Md Shohanoor Rahman's AUTOS DATABASE</title>
</head>
<body>

<div class="container">

<p>
</body>
<?php

echo "Welcome ".($_SESSION['name']);

if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
  }
?>
<p>
<a href="add.php">Add New</a>
<a href="logout.php">Logout</a>


</p>

</p>
</body>
