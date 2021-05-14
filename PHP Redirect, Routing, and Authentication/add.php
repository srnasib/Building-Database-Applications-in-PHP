
<?php 
session_start();
require_once "pdo.php";


$notify=false;
$error=false;
if ( ! isset($_SESSION['name'])   ) {
    die('Not logged in');
   
}
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to login.php
    header("Location: view.php");
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
 
$_SESSION['success'] = "Record inserted";
header("Location: view.php");
return;
    

}
else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && strlen($_POST['make']) > 1 && (is_numeric($_POST['year'])!==true || is_numeric($_POST['mileage'])!==true))
{
    $_SESSION['invalid'] = "Mileage and year must be numeric";
    header("Location: add.php");
    return;

}

else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && strlen($_POST['make']) < 1 && is_numeric($_POST['year'])===true && is_numeric($_POST['mileage'])===true )
{
    $_SESSION['invalid'] = "Make is required";
    header("Location: add.php");
    return;

}


?>
<?php
    if ( isset($_SESSION["invalid"]) ) {
        echo('<p style="color:red">'.$_SESSION["invalid"]."</p>\n");
        unset($_SESSION["invalid"]);
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

echo "Welcome ".($_SESSION['name']);


?>
<form method="POST">
<label for="nam">Make :   </label>
<input type="text" name="make" id="nam" size ="40" ><br/>
<label for="id_1723">Year :   </label>
<input type="text" name="year" id="id_1723" size ="40" ><br/>
<label for="id_1722">Milege :   </label>
<input type="text" name="mileage" id="id_1722" size ="40" ><br/>
<input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</p>
</body>


