<?php

require "db.php";

?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription CRUD</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <h1>Gestion users</h1>
    </header>
    <main>
        <?php if (!$showUpdateForm): ?>
            <section class="form">
                <div class="form-container">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="lastName">Nom</label>
                        <input type="text" name="lastName" required>
                        <label for="firstName">Prénom</label>
                        <input type="text" name="firstName" required>
                        <label for="mail">Mail</label>
                        <input type="email" name="mail" required>
                        <label for="zipCode">zipCode</label>
                        <input type="number" name="zipCode" required>
                        <button class="btn" type="submit">Valider</button>
                    </form>
                </div>

            </section>
        <?php endif; ?>
        <?php if ($showUpdateForm && $userToUpdate): ?>
            <section class="form  update-form">
                <div class="form-container">
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($userToUpdate['id']); ?>">
                        <label for="updateLastName">Nom</label>
                        <input type="text" name="updateLastName" value="<?= htmlspecialchars($userToUpdate['lastName']); ?>" required>
                        <label for="updateFirstName">Prénom</label>
                        <input type="text" name="updateFirstName" value="<?= htmlspecialchars($userToUpdate['firstName']); ?>" required>
                        <label for="updateMail">Mail</label>
                        <input type="email" name="updateMail" value="<?= htmlspecialchars($userToUpdate['mail']); ?>" required>
                        <label for="updateZipCode">Code Postal</label>
                        <input type="number" name="updateZipCode" value="<?= htmlspecialchars($userToUpdate['zipCode']); ?>" required>
                        <button type="submit" name="submit_update">Mettre à jour</button>
                        <? $e?>
                    </form>
                </div>
            </section>
        <?php endif; ?>
        <table>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Mail</th>
                <th>Code postal</th>
            </tr>
            <?php foreach ($users as $entry) { ?>
                <tr>
                    <td><?= htmlspecialchars($entry['firstName']); ?></td>
                    <td><?= htmlspecialchars($entry['lastName']); ?></td>
                    <td><?= htmlspecialchars($entry['mail']); ?></td>
                    <td><?= htmlspecialchars($entry['zipCode']); ?></td>
                    <td>
                        <div>
                            <form class="btn-container" method="POST">
                                <input type="hidden" name="user_id" value="<?= $entry['id']; ?>">
                                <input type="submit" id="delete" value="delete" name="delete">
                                <input type="submit" id="update" value="update" name="update">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>

</html>