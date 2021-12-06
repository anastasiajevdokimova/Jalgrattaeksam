<?php
require_once("konf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ab_login.php');
    exit();
}
global $yhendus;
if(!empty($_REQUEST["teooriatulemus"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?");
    $kask->bind_param("ii", $_REQUEST["teooriatulemus"], $_REQUEST["id"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE teooriatulemus=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<?php include ("admin_nav.php");?>
<!doctype html>
<html>
<head>
    <title>Teooriaeksam</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        .teoo {
            border-bottom: 3px solid #FFA500;
            color: #FFA500;
        }
    </style>
</head>
<body>
<header class="header">
    <p><?= $_SESSION["kasutaja"]?> on sisse logitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout" class="btnlogout">
    </form>
    <div class="container">
        <h1>Teooriaeksam</h1>
    </div>
</header>
<div class="teoo-form">
    <br>
<table>
    <?php
    while($kask->fetch()){
        echo "
		    <tr>
			  <td>$eesnimi</td>
			  <td>$perekonnanimi</td>
			  <td><form action=''>
			         <input type='hidden' name='id' value='$id' />
					 <input type='text' class='teoo-input' name='teooriatulemus' required />
					 <input type='submit' class='teoo-input' value='Sisesta tulemus' />
			      </form>
			  </td>
			</tr>
			<br>
		  ";
    }
    ?>
</table>
</div>
</body>
</html>
