<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier chambre</title>
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
        <h1>Modifier chambre</h1>
        <?php
        include "connexion.php";

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_chambre'])) {
            $id_chambre = $_GET['id_chambre'];
            $stmt = $bdd->prepare("SELECT * FROM chambre WHERE id_chambre = :id_chambre");
            $stmt->bindParam(':id_chambre', $id_chambre, PDO::PARAM_INT);
            $stmt->execute();
            $chambre = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$chambre) {
                echo '<div class="message error">chambre non trouvé.</div>';
                exit;
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
           $id_chambre = $_POST['id_chambre'];
            $numero = $_POST['numero'];
            $type = $_POST['type'];
            $statut = $_POST['statut'];
          

            $stmt = $bdd->prepare("UPDATE chambre SET id_chambre = :id_chambre, numero = :numero, type = :type, statut = :statut WHERE id_chambre = :id_chambre");
            $stmt->bindParam(':id_chambre', $id_chambre, PDO::PARAM_STR);
            $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
         

            if ($stmt->execute()) {
                echo '<div class="message success">chambre modifié avec succès !</div>';
            } else {
                echo '<div class="message error">Erreur lors de la modification du chambre.</div>';
            }

            $chambre = [
                'id_chambre' => $id_chambre,
                'numero' => $numero,
                'type' => $type,
                'statut' => $statut,
               
            ];
        }

        if (isset($chambre)):
        ?>
        <form method="POST" action="">
            <input type="hidden" name="id_chambre" value="<?php echo $chambre['id_chambre']; ?>">  
            
            <label for="numero">Nom :</label>
            <input type="text" id="numero" name="numero" value="<?php echo $chambre['numero']; ?>" required>
            
            <label for="type">type :</label>
            <input type="text" id="type" name="type" value="<?php echo $chambre['type']; ?>" required>
            
            <label for="statut">statut  :</label>
            <input type="statut" id="statut" name="statut" value="<?php echo $chambre['statut']; ?>" required>
            <input type="submit" name="modifier" value="Modifier">
        </form>
        <?php else: ?>
        <div class="message error">Aucun chambre sélectionné pour modification.</div>
        <?php endif; ?>
    </div>
</body>
</html>