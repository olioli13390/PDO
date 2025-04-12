<?php

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
        if (preg_match('/^[a-zA-Z]+$/', $firstName) && preg_match('/^[a-zA-Z]+$/', $lastName) && preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mail) && preg_match('/^\d{5}$/', $zipCode)) {
            $addUser->execute([
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':mail' => $mail,
                ':zipCode' => $zipCode
            ]);
        } else {
            throw new Exception("pas bon");
        }
        echo "Utilisateur ajouté avec succès !";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        echo 'Erreur lors de l\'ajout de l\'utilisateur : ' . $e->getMessage();
    }
    echo "Tous les champs sont requis.";
}
