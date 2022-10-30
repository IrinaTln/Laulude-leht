<!--CREATE TABLE laulud(
//    id int PRIMARY KEY AUTO_INCREMENT,
//    laulunimi varchar(50),
//    lisamisaeg datetime,
//    punktid int DEFAULT 0,
//    kommentarid text Default 0,
avalik int Default 1)-->
<?php
require_once ('conf.php');
global $yhendus;


//комментарии к песне
if (!empty(isSet($_REQUEST['uus_komment']))){
    $kask=$yhendus->prepare("UPDATE laulud SET kommentarid = Concat(kommentarid, ?) WHERE id = ?");
    $lisakommentar=$_REQUEST['komment']."\n"; //оформление перехода на новую строку
    $kask->bind_param("si", $lisakommentar, $_REQUEST['uus_komment']);
    $kask->execute();
}

//Добавление пунктов
if(isset($_REQUEST['haal'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET punktid=punktid+1 WHERE id=?");
    $kask->bind_param('s', $_REQUEST['haal']);
    $kask->execute();
}
//удаление пунктов
if(isset($_REQUEST['haal1'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET punktid=punktid-1 WHERE id=?");
    $kask->bind_param('s', $_REQUEST['haal1']);
    $kask->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Laulude leht</title>
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
            <h1>Laulud</h1>
            <table class="table">
                <thead>
                <tr>
                    <th><strong>Laulu nimi</strong></th>
                    <th><strong>Punktid</strong></th>
                    <th><strong>Lisamisaeg</strong></th>
                    <th><strong>Lisa punktid</strong></th>
                    <th><strong>Emalda punktid</strong></th>
                    <th><strong>Kommentaarid</strong></th>
                    <th><strong>Kirjuta</strong></th>
                </tr>
                </thead>
                <?php
                //вывод заполненной таблицы
                $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg, kommentarid FROM laulud WHERE avalik=1');
                $kask->bind_result($id, $laulunimi, $punktid, $aeg, $kommentarid);
                $kask->execute();

                while ($kask->fetch()){

                    echo "<tr>";
                    echo"<td>".htmlspecialchars($laulunimi)."</td>";
                    echo"<td>$punktid</td>";
                    echo"<td>$aeg</td>";
                    echo"<td><a href='?haal=$id'>Lisa punkt</a> </td>";
                    echo"<td><a href='?haal1=$id'>Võta punkt</a> </td>";
                    echo "<td>".nl2br($kommentarid)."</td>"; //nl2br - функция переноса на другую строку
                    echo"<td>
                            <form action='?'>
                            <input type='hidden' name='uus_komment' value='$id'>
                            <input class='box' type='text' name='komment'>
                            <input type='submit' value='ok'>
                            </form>
                            </td>";
                    echo"</tr>";

                }
                ?>
            </table>
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
