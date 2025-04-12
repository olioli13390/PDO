<?php

$showUpdateForm = false;
/// Read
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=crud", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    require 'create.php';
    require 'update.php';
    require 'delete.php';
    $users = $db->query("SELECT * FROM user")->fetchAll();
} catch (Exception $e) {
    echo $e->getMessage();
}
