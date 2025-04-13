<?php
$error = [];
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

    if (!preg_match('/^[a-zA-Z]+$/', $firstName)) {
        $error[] = "renseignez le prénom";
    }

    if (!preg_match('/^[a-zA-Z]+$/', $lastName)) {
        $error[] = "renseignez le nom";
    }
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mail)) {
        $error[] = "renseignez le mail";
    }
    if (!preg_match('/^\d{5}$/', $zipCode)) {
        $error[] = "renseignez le code postal";
    }

    if (empty($error)) {
        try {
            $addUser = $db->prepare("INSERT INTO user (firstName, lastName, mail, zipCode) VALUES (:firstName, :lastName, :mail, :zipCode)");
            $addUser->execute([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'mail' => $mail,
                'zipCode' => $zipCode
            ]);
            echo "Utilisateur ajouté avec succès !";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (Exception $e) {
            echo 'Erreur lors de l\'ajout de l\'utilisateur : ' . $e->getMessage();
        }
    } else {
        foreach ($error as $err) {
            echo $err . "<br>";
        }
    }
}
