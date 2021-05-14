
<?php 
session_start();
require_once "pdo.php";


if ( ! isset($_SESSION['name'])   ) {
    die('Not logged in');
   
}
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to login.php
    header("Location: index.php");
    return;
}


if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model']) && strlen($_POST['make']) >1  
&& strlen($_POST['model']) >1 && is_numeric($_POST['year'])===true && is_numeric($_POST['mileage'])===true )
{

$sql= "INSERT INTO autos (make,model, year, mileage) VALUES ( :mk,:md, :yr, :mi)";
$stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
);
 
$_SESSION['success'] = "Record added";
header("Location: index.php");
return;
    

}
else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model'])  && strlen($_POST['make']) > 1 
&&  strlen($_POST['model'])>1 && (is_numeric($_POST['year'])!==true || is_numeric($_POST['mileage'])!==true))
{
    $_SESSION['invalid'] = "Mileage and year must be numeric";
    header("Location: add.php");
    return;

}

else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model']) && (strlen($_POST['make']) < 1 
|| strlen($_POST['model']) < 1 ) && is_numeric($_POST['year'])===true && is_numeric($_POST['mileage'])===true )
{
    $_SESSION['invalid'] = "Make or model is required";
    header("Location: add.php");
    return;

}
else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model']) && 
(strlen($_POST['make'])<0 && strlen($_POST['year'])<0 || strlen($_POST['mileage'])<0 || strlen($_POST['model'] <0)  )   )
{
    $_SESSION['invalid'] = "All fields are required";
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
<label for="mod">Model :   </label>
<input type="text" name="model" id="mod" size ="40" ><br/>
<label for="id_1723">Year :   </label>
<input type="text" name="year" id="id_1723" size ="40" ><br/>
<label for="id_1722">Milege :   </label>
<input type="text" name="mileage" id="id_1722" size ="40" ><br/>
<input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</p>
</body>


