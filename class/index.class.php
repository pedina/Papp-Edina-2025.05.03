<?php

include './async_adatbazis.class.php';
include './async_mozi.class.php';
include './async_utvonal.class.php';

$utvonal = new Utvonal($_SERVER['REQUEST_URI']);
$utvonal->utvonalVizsgalat();


?>