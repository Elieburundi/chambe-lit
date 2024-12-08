<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier employé</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    <?php include 'Accueil.php'; ?>
    <div class="flex-grow container mx-auto max-w-4xl p-8 mt-8">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Modifier employé</h1>
        <?php
        include "connexion.php";

        $employe = null;
        $message = '';

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $bdd->prepare("SELECT * FROM employe WHERE id_employe = :id_employe");
            $stmt->bindParam(':id_employe', $id, PDO::PARAM_INT);
            $stmt->execute();
            $employe = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$employe) {
                $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Employé non trouvé.</div>';
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
            $id_employe = filter_input(INPUT_POST, 'id_employe', FILTER_SANITIZE_NUMBER_INT);
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
            $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING);

            try {
                $stmt = $bdd->prepare("UPDATE employe SET nom = :nom, prenom = :prenom, role = :role, contact = :contact WHERE id_employe = :id_employe");
                $stmt->bindParam(':id_employe', $id_employe, PDO::PARAM_INT);
                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $message = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">Employé modifié avec succès !</div>';
                    // Fetch the updated employe data
                    $stmt = $bdd->prepare("SELECT * FROM employe WHERE id_employe = :id_employe");
                    $stmt->bindParam(':id_employe', $id_employe, PDO::PARAM_INT);
                    $stmt->execute();
                    $employe = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {
                $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Erreur lors de la modification de l\'employé : ' . $e->getMessage() . '</div>';
            }
        }

        echo $message;

        if ($employe):
        ?>
        <form method="POST" action="" class="space-y-4 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id_employe" value="<?php echo htmlspecialchars($employe['id_employe']); ?>">
            
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($employe['nom']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            
            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($employe['prenom']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role :</label>
                <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($employe['role']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700">Contact :</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($employe['contact']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            
            <div class="flex items-center justify-between">
                <input type="submit" name="modifier" value="Modifier" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <a href="affichageemploye.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Retour à la liste
                </a>
            </div>
        </form>
        <?php else: ?>
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
            <p>Aucun employé sélectionné pour modification.</p>
            <p class="mt-2">
                <a href="affichageemploye.php" class="font-bold text-yellow-800 hover:text-yellow-900">Retour à la liste des employés</a>
            </p>
        </div>
        <?php endif; ?>
    </div>
    <script>
        // Add any additional JavaScript here if needed
    </script>
</body>
</html>