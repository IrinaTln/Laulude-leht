<?php
require_once ('conf.php');
global $yhendus;

//добавление песни в таблицу
if(!empty($_REQUEST["uusnimi"])) {
    $kask = $yhendus->prepare("INSERT INTO laulud(laulunimi, lisamisaeg) VALUES (?, NOW())");
    $kask->bind_param('s', $_REQUEST["uusnimi"]);
    $kask->execute();
    header("Location: laulud.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Koduleht</title>
    <link rel="shortcut icon" type="image/png" href="../../img/favicon.png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>
<body>
<div class="page">
    <?php
    include('header.php');
    ?>
    <nav class="nav">
        <a class="link-nav" href="homepage.php">Koduleht</a>
        <a class="link-nav" href="laulud.php">Kasutaja leht</a>
        <a class="link-nav" href="lauludAdminLeht.php">Administreerimine leht</a>
        <a class="link-nav" href="">GitHub</a>
    </nav>
    <div class="conteiner">
        <main class="content">
            <h1>Laulude leht</h1>
            <form class="form" action="?" method="post">
                <label for="nimi">Laulu lisamine</label>
                <input class="box1" type="text" name="uusnimi", id="nimi">
                <input type="submit" value="OK">
            </form>
        </main>
    </div>
    <?php
    include('footer.php');
    ?>
</div>
</body>
</html>


<?php

$yhendus->close();
?>

