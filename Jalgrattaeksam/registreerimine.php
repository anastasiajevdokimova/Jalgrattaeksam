<?php
require_once("konf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ab_login.php');
    exit();
}
global $yhendus;
if(isSet($_REQUEST["sisestusnupp"])){
    $kask=$yhendus->prepare(
        "INSERT INTO jalgrattaeksam(eesnimi, perekonnanimi) VALUES (?, ?)");
    $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"]);
    $kask->execute();
    $yhendus->close();
    header("Location: $_SERVER[PHP_SELF]?lisatudeesnimi=$_REQUEST[eesnimi]");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <title>Kasutaja registreerimine</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
           .regi {
           border-bottom: 3px solid #FFA500;
           color: #FFA500;
           }
    </style>
</head>
<?php include ("user_nav.php");?>
<body>
<header class="header">
    <p><?= $_SESSION["kasutaja"]?> on sisse logitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout" class="btnlogout">
    </form>
</header>
<div class="reg">
    <h1>Registreerimine</h1>
<?php
if(isSet($_REQUEST["lisatudeesnimi"])){
    echo "Lisati $_REQUEST[lisatudeesnimi]";
}
?>
<form action="?">
    <dl>
        <dt class="reg-input"> Eesnimi:</dt>
        <dd><input class="reg-input" type="text" name="eesnimi" required/></dd>
        <br>
        <dt class="reg-input"> Perekonnanimi:</dt>
        <dd><input class="reg-input" type="text" name="perekonnanimi" required/></dd>
        <br>
        <dt><input class="reg-input" type="submit" name="sisestusnupp" value="sisesta" /></dt>
    </dl>
</form>
</body>
</div>
</html>
