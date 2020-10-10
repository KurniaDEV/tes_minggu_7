<?php

function insertSiswa($nama_siswa, $sekolah, $motivasi)
{
    include 'connection.php';

    if ($data_siswa) {
        $sql = 'UPDATE tabel_siswa SET nama_siswa = ?, sekolah = ?, motivasi = ? WHERE id_siswa = ?';
        var_dump($sql);
        exit;
    }else {
    $sql='INSERT INTO siswa(nama_siswa, sekolah, motivasi) VALUES(?, ?, ?)';
    }


    try {
        $results =$db->prepare($sql);
        $results->bindValue(1, $nama_siswa, PDO::PARAM_STR);
        $results->bindValue(2, $sekolah, PDO::PARAM_STR);
        $results->bindValue(3, $motivasi, PDO::PARAM_STR);
        if ($data_siswa) {
            $results->bindValue(4, $data_siswa, PDO::PARAM_STR);
        }
        $results->execute();
    } catch (Exception $e) {
        echo "Error!: ". $e->getMessage()."<br />";
        return false;
    }
    if ($data_siswa) {
        header("Location: index.php");
    }
    return true;
}