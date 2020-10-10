<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=datasiswa","root","",[PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
$siswa=$db->query("select * from tabel_siswa");
$data_siswa=$siswa->fetchAll();