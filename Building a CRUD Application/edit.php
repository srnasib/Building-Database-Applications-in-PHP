<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION['name'])   ) {
    die('Not logged in');
   
}
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to login.php
    header("Location: index.php");
    return;
}


if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model']) && isset($_POST['autos_id']) &&
strlen($_POST['make']) >1   && strlen($_POST['model']) >1 && is_numeric($_POST['year'])===true && is_numeric($_POST['mileage'])===true )
{

$sql= "UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mi WHERE autos_id = :autos_id";

$stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
 
$_SESSION['success'] = "Record Updated";
header("Location: index.php");
return;
    

}
else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model'])  && isset($_POST['autos_id']) && 
strlen($_POST['make']) > 1 &&  strlen($_POST['model'])>1 && (is_numeric($_POST['year'])!==true || is_numeric($_POST['mileage'])!==true))
{
    $_SESSION['invalid'] = "Mileage and year must be numeric";
    header("Location: edit.php?autos_id=".$_POST['autos_id']);
    return;

}

else if (  isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model']) && isset($_POST['autos_id']) && 
(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 ) && is_numeric($_POST['year'])===true && is_numeric($_POST['mileage'])===true )
{
    header("Location: edit.php?autos_id=".$_POST['autos_id']);
    
    return;

}

if ( ! isset($_GET['autos_id']) ) {
    $_SESSION['error'] = "Missing autos_id";
    header("Location: index.php");
    return;
  }

  $stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['autos_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ( $row === false ) {
      $_SESSION['error'] = 'Bad value for autos_id';
      header( 'Location: index.php' ) ;
      return;
  } 
 
  if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$a = htmlentities($row['make']);
$b = htmlentities($row['model']);
$c = htmlentities($row['year']);
$d = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>

<p>Edit Entry</p>
<p>
<form method="POST">
<label for="nam">Make :   </label>
<input type="text" name="make" id="nam" value="<?= $a ?>" ><br/>
<label for="mod">Model :   </label>
<input type="text" name="model" id="mod" value="<?= $b ?>"><br/>
<label for="id_1723">Year :   </label>
<input type="text" name="year" id="id_1723" value="<?= $c ?>" ><br/>
<label for="id_1722">Milege :   </label>
<input type="text" name="mileage" id="id_1722" value="<?= $d ?>" ><br/>
<input type="hidden" name="autos_id"  value="<?= $autos_id ?>" ><br/>
<input type="submit" name="save" value="Save">
<input type="submit" name="cancel" value="Cancel">
</form>
</p>




