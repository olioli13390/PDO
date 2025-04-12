<?php

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


        if (preg_match('/^[a-zA-Z]+$/', $firstName) && preg_match('/^[a-zA-Z]+$/', $lastName) && preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mail) && preg_match('/^\d{5}$/', $zipCode)) {
            $update->execute([
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':mail' => $mail,
                ':zipCode' => $zipCode,
                ':user_id' => $userId
            ]);
        } else {
            echo "error";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        echo 'Erreur lors de la mise à jour : ' . $e->getMessage();
    }
}
