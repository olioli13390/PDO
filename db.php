<?php

$showUpdateForm = false;
/// Read
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=crud", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // $db->query = $db->exec
    $users = $db->query("SELECT * FROM user")->fetchAll();
} catch (Exception $e) {
    echo $e->getMessage();
}

/// Create
if (!isset($_POST['firstName'])) {
    $firstName =  null;
    $lastName = null;
    $mail =  null;
    $zipCode = null;
} else {
    $firstName =  $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $mail =  $_POST['mail'];
    $zipCode = $_POST['zipCode'];

    try {
        $addUser = $db->prepare("INSERT INTO user (firstName, lastName, mail, zipCode) VALUES (:firstName, :lastName, :mail, :zipCode)");

        $addUser->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':mail' => $mail,
            ':zipCode' => $zipCode
        ]);
        echo "Utilisateur ajouté avec succès !";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        echo 'Erreur lors de l\'ajout de l\'utilisateur : ' . $e->getMessage();
    }
    echo "Tous les champs sont requis.";
}

/// Update

if (isset($_POST['update'])) {
    $showUpdateForm = true;
    $userId = $_POST['user_id'];

    try {
        $displayUser = $db->prepare('SELECT * FROM user WHERE id = :user_id');
        $displayUser->execute([':user_id' => $userId]);
        $userToUpdate = $displayUser->fetch();
    } catch (Exception $e) {
        echo 'Erreur lors de la récupération des données : ' . $e->getMessage();
    }
}

if (isset($_POST['submit_update'])) {
    $userId = $_POST['user_id'];
    $firstName = $_POST['updateFirstName'];
    $lastName = $_POST['updateLastName'];
    $mail = $_POST['updateMail'];
    $zipCode = $_POST['updateZipCode'];

    try {
        $update = $db->prepare('UPDATE user SET firstName = :firstName, lastName = :lastName, mail = :mail, zipCode = :zipCode WHERE id = :user_id');
        $update->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':mail' => $mail,
            ':zipCode' => $zipCode,
            ':user_id' => $userId
        ]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        echo 'Erreur lors de la mise à jour : ' . $e->getMessage();
    }
}

/// Delete
if (isset($_POST['delete'])) {
    $userId = $_POST['user_id'];
    try {
        $delete = $db->prepare('DELETE FROM user WHERE id = :user_id');
        $delete->execute([
            ':user_id' => $userId
        ]);
        echo 'Utilisateur supprimé avec succès';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        echo 'Erreur lors de la suppression : ' . $e->getMessage();
    }
}
