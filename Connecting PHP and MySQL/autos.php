<?php require_once "pdo.php"; ?>
<?php
$notify=false;
$error=false;
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
   
}
if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to login.php
    header("Location: login.php");
    return;
}


if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && strlen($_POST['make']) >1  && is_numeric($_POST['year'])===true && is_numeric($_POST['mileage'])===true )
{

$sql= "INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)";
$stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );
 
$notify = "Record Inserted";
    

}
else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && strlen($_POST['make']) > 1 && (is_numeric($_POST['year'])!==true || is_numeric($_POST['mileage'])!==true))
{
$error = "Mileage and year must be numeric";
}

else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && strlen($_POST['make']) < 1 && is_numeric($_POST['year'])===true && is_numeric($_POST['mileage'])===true )
{
$error = "Make is required";
}


?>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $error !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($error)."</p>\n");
}
if ( $notify !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($notify)."</p>\n");
}
?>


<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Md Shohanoor Rahman's AUTOS DATABASE</title>
</head>
<body>

<div class="container">

<p>
<?php

echo "Welcome ".($_GET['name']);


?>
<form method="POST">
<label for="nam">Make :   </label>
<input type="text" name="make" id="nam" size ="40" ><br/>
<label for="id_1723">Year :   </label>
<input type="text" name="year" id="id_1723" size ="40" ><br/>
<label for="id_1722">Milege :   </label>
<input type="text" name="mileage" id="id_1722" size ="40" ><br/>
<input type="submit" name="add" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
</p>
</body>

<head></head><body> <table border="2">
<?php
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
