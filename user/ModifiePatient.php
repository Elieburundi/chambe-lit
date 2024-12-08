<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Patient</title>
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
        input[type="date"] {
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
    <?php include 'Accueil.php';?>;
    <div class="container">
        <h1>Modifier Patient</h1>
        <?php
        include "connexion.php";

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $bdd->prepare("SELECT * FROM patient WHERE id_patient = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$patient) {
                echo '<div class="message error">Patient non trouvé.</div>';
                exit;
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $date_naissance = $_POST['date_naissance'];
            $contact = $_POST['contact'];

            $stmt = $bdd->prepare("UPDATE patient SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, contact_id = :contact WHERE id_patient = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo '<div class="message success">Patient modifié avec succès !</div>';
            } else {
                echo '<div class="message error">Erreur lors de la modification du patient.</div>';
            }

            $patient = [
                'id' => $id,
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => $date_naissance,
                'contact_id' => $contact
            ];
        }

        if (isset($patient)):
        ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $patient['id_patient']; ?>">
            
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo $patient['nom']; ?>" required>
            
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo $patient['prenom']; ?>" required>
            
            <label for="date_naissance">Date de naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $patient['date_naissance']; ?>" required>
            
            <label for="contact">Contact :</label>
            <input type="text" id="contact" name="contact" value="<?php echo $patient['contact_id']; ?>" required>
            
            <input type="submit" name="modifier" value="Modifier">
        </form>
        <?php else: ?>
        <div class="message error">Aucun patient sélectionné pour modification.</div>
        <?php endif; ?>
    </div>
</body>
</html>