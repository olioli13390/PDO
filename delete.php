<?php

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
