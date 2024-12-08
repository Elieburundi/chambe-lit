<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Lits</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --background-color: #f0f0f0;
            --text-color: #333;
        }

        .dark-mode {
            --primary-color: #2980b9;
            --secondary-color: #27ae60;
            --danger-color: #c0392b;
            --background-color: #2c3e50;
            --text-color: #ecf0f1;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
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
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: var(--primary-color);
            color: #fff;
        }

        tr {
            background-color: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        tr:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-danger {
            background-color: var(--danger-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
        }

        .btn:hover {
            opacity: 0.8;
            transform: translateY(-2px);
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

        #darkModeToggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'Accueil.php'; ?>
    
    <button id="darkModeToggle" class="btn btn-primary">Toggle Dark Mode</button>

    <div class="container">
        <h1 class="text-3xl font-bold mb-6">Liste des lits</h1>

        <?php
        // Database connection
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=gestion_chambre_lit;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }

        // Delete operation
        if (isset($_GET["sup"])) {
            $id_lit = filter_input(INPUT_GET, 'sup', FILTER_VALIDATE_INT);
            if ($id_lit !== false && $id_lit !== null) {
                try {
                    $suppressionPub = $pdo->prepare("DELETE FROM lit WHERE id_lit = :id_lit");
                    $suppressionPub->execute([':id_lit' => $id_lit]);
                    echo '<div class="message success">Lit supprimé avec succès.</div>';
                } catch (PDOException $e) {
                    echo '<div class="message error">Erreur lors de la suppression : ' . $e->getMessage() . '</div>';
                }
            } else {
                echo '<div class="message error">ID de lit invalide.</div>';
            }
        }

        // Fetch all records from the lit table
        try {
            $affichageRecl = $pdo->query("SELECT * FROM lit");
        } catch (PDOException $e) {
            echo '<div class="message error">Erreur lors de la récupération des données : ' . $e->getMessage() . '</div>';
            exit;
        }
        ?>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Chambre ID</th>
                        <th class="px-4 py-2">Numéro_lit</th>
                        <th class="px-4 py-2">Statut</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($litRecup = $affichageRecl->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($litRecup["id_lit"]); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($litRecup["chambre_id"]); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($litRecup["numero_lit"] ?? 'N/A'); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($litRecup["statut"]); ?></td>
                            <td class="border px-4 py-2">
                                <a href="modifielit.php?id=<?php echo $litRecup["id_lit"]; ?>" class="btn btn-primary">Modifier</a>
                                <a href="affichagelit.php?sup=<?php echo $litRecup["id_lit"]; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce lit ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        darkModeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });

        // Animation for table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animation = `fadeIn 0.5s ease forwards ${index * 0.1}s`;
        });

        // Add this keyframe animation to your CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>