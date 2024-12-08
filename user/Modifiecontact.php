<?php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $bdd->prepare("SELECT * FROM contact WHERE id_contact = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        echo '<div class="message error">Contact non trouvé.</div>';
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $nom_rel = $_POST['rel'];
    $tel = $_POST['tel'];

    // Remove the extra comma before WHERE clause
    $stmt = $bdd->prepare("UPDATE contact SET nom_contact = :nom, relation = :rel, telephone = :tel WHERE id_contact = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':rel', $nom_rel, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);

    try {
        if ($stmt->execute()) {
            echo '<div class="message success">Contact modifié avec succès !</div>';
        } else {
            echo '<div class="message error">Erreur lors de la modification du contact.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="message error">Erreur : ' . $e->getMessage() . '</div>';
    }

    // Fetch the updated contact information
    $stmt = $bdd->prepare("SELECT * FROM contact WHERE id_contact = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Contact</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #f0f0f0;
            --text-color: #333;
            --error-color: #e74c3c;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="tel"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }

        .success {
            background-color: var(--secondary-color);
            color: #fff;
        }

        .error {
            background-color: var(--error-color);
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include 'Accueil.php'; ?>
    <div class="container">
        <h1>Modifier Contact</h1>
        <?php if (isset($contact)): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($contact['id_contact']); ?>">
            
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($contact['nom_contact']); ?>" required>
            
            <label for="rel">Relation :</label>
            <input type="text" id="rel" name="rel" value="<?php echo htmlspecialchars($contact['relation']); ?>" required>
            
            <label for="tel">Téléphone :</label>
            <input type="tel" id="tel" name="tel" value="<?php echo htmlspecialchars($contact['telephone']); ?>" required>
            
            <input type="submit" name="modifier" value="Modifier">
        </form>
        <?php else: ?>
        <div class="message error">Aucun contact sélectionné pour modification.</div>
        <?php endif; ?>
    </div>
</body>
</html>