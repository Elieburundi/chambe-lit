<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Patients</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --background-color: #f0f0f0;
            --text-color: #333;
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
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            margin-top:20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary-color);
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-danger {
            background-color: var(--danger-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
        }

        .btn:hover {
            opacity: 0.8;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            color: #fff;
        }

        .success {
            background-color: var(--secondary-color);
        }

        .error {
            background-color: var(--danger-color);
        }
    </style>
</head>
<body>
<?php include 'Accueil.php';?>;
    <div class="container">
        <h1>Liste des Patients</h1>

        <?php
        // Create the PDO connection first
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=gestion_chambre_lit;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }

        // Check if a delete request has been made
        if (isset($_GET["sup"])) {
            $id_patient = (int)$_GET['sup']; // Cast to int for safety
            try {
                $suppressionPub = $pdo->prepare("DELETE FROM patient WHERE id_patient = :id_patient");
                $suppressionPub->execute([':id_patient' => $id_patient]);
                echo '<div class="message success">Patient supprimé avec succès.</div>';
            } catch (PDOException $e) {
                echo '<div class="message error">Erreur lors de la suppression : ' . $e->getMessage() . '</div>';
            }
        }

        // Fetch all records from the patient table
        $affichageRecl = $pdo->query("SELECT * FROM patient");
        ?>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Contact ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($patientRecup = $affichageRecl->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($patientRecup["nom"]); ?></td>
                        <td><?php echo htmlspecialchars($patientRecup["prenom"]); ?></td>
                        <td><?php echo htmlspecialchars($patientRecup["date_naissance"]); ?></td>
                        <td><?php echo htmlspecialchars($patientRecup["contact_id"]); ?></td>
                        <td>
                            <a href="modifiepatient.php?id=<?php echo $patientRecup["id_patient"]; ?>" class="btn btn-primary">Modifier</a>
                            <a href="affichagepatient.php?sup=<?php echo $patientRecup["id_patient"]; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>