<?php
try {
    $conexao = new PDO('mysql:host='.$hostname.';dbname='.$dbname, $username, $password);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}