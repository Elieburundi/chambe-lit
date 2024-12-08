<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --background-color: #f0f0f0;
            --text-color: #333;
            --card-bg: rgba(255, 255, 255, 0.1);
        }

        .dark-mode {
            --primary-color: #2980b9;
            --secondary-color: #27ae60;
            --danger-color: #c0392b;
            --background-color: #2c3e50;
            --text-color: #ecf0f1;
            --card-bg: rgba(0, 0, 0, 0.2);
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
            background-color: var(--card-bg);
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
            background-color: var(--card-bg);
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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animated-row {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'Accueil.php'; ?>
    
    <button id="darkModeToggle" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
    </button>

    <div class="container">
        <h1 class="text-3xl font-bold mb-6">Liste des employés</h1>

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
            $id_employe = filter_input(INPUT_GET, 'sup', FILTER_VALIDATE_INT);
            if ($id_employe !== false && $id_employe !== null) {
                try {
                    $suppressionEmp = $pdo->prepare("DELETE FROM employe WHERE id_employe = :id_employe");
                    $suppressionEmp->execute([':id_employe' => $id_employe]);
                    echo '<div class="message success">Employé supprimé avec succès.</div>';
                } catch (PDOException $e) {
                    echo '<div class="message error">Erreur lors de la suppression : ' . $e->getMessage() . '</div>';
                }
            } else {
                echo '<div class="message error">ID d\'employé invalide.</div>';
            }
        }

        // Fetch all records from the employe table
        try {
            $affichageEmp = $pdo->query("SELECT * FROM employe");
        } catch (PDOException $e) {
            echo '<div class="message error">Erreur lors de la récupération des données : ' . $e->getMessage() . '</div>';
            exit;
        }
        ?>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Prénom</th>
                        <th class="px-4 py-2">Rôle</th>
                        <th class="px-4 py-2">Contact</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($employeRecup = $affichageEmp->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr class="animated-row">
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($employeRecup["nom"]); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($employeRecup["prenom"]); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($employeRecup["role"] ?? 'N/A'); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($employeRecup["contact"]); ?></td>
                            <td class="border px-4 py-2">
                                <a href="modifieemploye.php?id=<?php echo $employeRecup["id_employe"]; ?>" class="btn btn-primary">Modifier</a>
                                <a href="affichageemploye.php?sup=<?php echo $employeRecup["id_employe"]; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">Supprimer</a>
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
        const tableRows = document.querySelectorAll('.animated-row');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
</body>
</html>