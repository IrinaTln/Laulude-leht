<!--CREATE TABLE laulud(
//    id int PRIMARY KEY AUTO_INCREMENT,
//    laulunimi varchar(50),
//    lisamisaeg datetime,
//    punktid int DEFAULT 0,
//    kommentarid text)-->
<?php
require_once ('conf.php');
global $yhendus;
//добавление песни в таблицу
if(!empty($_REQUEST["uusnimi"])) {
    $kask = $yhendus->prepare("INSERT INTO laulud(laulunimi, lisamisaeg) VALUES (?, NOW())");
    $kask->bind_param('s', $_REQUEST["uusnimi"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//удаление песни
if (isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM laulud WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
}

//скрытие песни
if(isset($_REQUEST['peitmine'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET avalik=0 WHERE id=?");
    $kask->bind_param('s', $_REQUEST['peitmine']);
    $kask->execute();
}
//выставление песни
if(isset($_REQUEST['naitamine'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET avalik=1 WHERE id=?");
    $kask->bind_param('s', $_REQUEST['naitamine']);
    $kask->execute();
}

//обнуление пунктов
if(isset($_REQUEST['haal1'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET punktid=0 WHERE id=?");
    $kask->bind_param('s', $_REQUEST['haal1']);
    $kask->execute();
}

//удаление комментариев
if(isset($_REQUEST['kustuda_komment'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET kommentarid=' ' WHERE id=?");
    $kask->bind_param('s', $_REQUEST['kustuda_komment']);
    $kask->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>Laulude admin leht</title>
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
            <h1>Laulude admin leht</h1>
               <table class="table">
                <thead>
                    <tr>
                        <th><strong>Laulu nimi</strong></th>
                        <th><strong>Punktid</strong></th>
                        <th><strong>Lisamisaeg</strong></th>
                        <th><strong>Status</strong></th>
                        <th><strong>Haldus</strong></th>
                        <th><strong>Kustutamine</strong></th>
                        <th><strong>Puntkid nulliks</strong></th>
                        <th><strong>Kommentid</strong></th>
                        <th><strong>Kustuta kommenti</strong></th>
                    </tr>
                </thead>
                <?php
                //вывод заполненной таблицы
                $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg, avalik,kommentarid FROM laulud');
                $kask->bind_result($id, $laulunimi, $punktid, $aeg, $avalik, $kommentarid);
                $kask->execute();

                while ($kask->fetch()){

                    $seisund="Peidetud";
                    $param="naitamine";
                    $tekst="Näita";

                    if ($avalik==1){
                        $seisund="Avatud";
                        $param="peitmine";
                        $tekst="Peida";
                    }

                    echo "<tr>";
                    echo"<td>".htmlspecialchars($laulunimi)."</td>";
                    echo"<td>$punktid</td>";
                    echo"<td>$aeg</td>";
                    echo"<td>$seisund</td>";
                    echo"<td><a href='?$param=$id'>$tekst</a></td>";
                    echo"<td><a href='?kustuta=$id'>Kustuta</a></td>";
                    echo"<td><a href='?haal1=$id'>Puhastada</a></td>";
                    echo "<td>$kommentarid</td>";
                    echo "<td><a href='?kustuda_komment=$id'>Kustuta</a></td>";
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
<?php

$yhendus->close();

//удаление песни
//стили
//на админской странице сделать обнуление пунктов
//навигация между страницами админа и пользователя
//админ видит комменты и может их удалить
//навигация
//код на гитхаб
//
//при добавлении песни после нажатия ок загружается страница с таблицей песен
?>

