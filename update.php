<?php

$error = [];

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


    if (!preg_match('/^[a-zA-Z]+$/', $lastName)) {
        $error[] = "Erreur dans le nom";
    }
    if (!preg_match('/^[a-zA-Z]+$/', $firstName)) {
        $error[] = "Erreur dans le prénom";
    }
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mail, $mail)) {
        $error[] = "Erreur dans le mail";
    }
    if (!preg_match('/^\d{5}$/', $zipCode)) {
        $error[] = "Erreur dans le code postal";
    }

    if (empty($error)) {
        try {
            $update = $db->prepare('UPDATE user SET firstName = :firstName, lastName = :lastName, mail = :mail, zipCode = :zipCode WHERE id = :user_id');
            $update->execute([
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
    } else {
        foreach ($error as $err) {
            echo $err . "<br>";
        }
    }
}
