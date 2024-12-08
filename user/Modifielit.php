<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier lit</title>
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
<body class="flex justify-center items-center min-h-screen p-4">
    <?php include 'Accueil.php'; ?>
    <div class="container max-w-md w-full p-8">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Modifier lit</h1>
        <?php
        include "connexion.php";

        $lit = null;
        $message = '';

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $bdd->prepare("SELECT * FROM lit WHERE id_lit = :id_lit");
            $stmt->bindParam(':id_lit', $id, PDO::PARAM_INT);
            $stmt->execute();
            $lit = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$lit) {
                $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Lit non trouvé.</div>';
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
            $id_lit = filter_input(INPUT_POST, 'id_lit', FILTER_SANITIZE_NUMBER_INT);
            $chambre_id = filter_input(INPUT_POST, 'chambre_id', FILTER_SANITIZE_NUMBER_INT);
            $numero_lit = filter_input(INPUT_POST, 'numero_lit', FILTER_SANITIZE_STRING);
            $statut = filter_input(INPUT_POST, 'statut', FILTER_SANITIZE_STRING);

            try {
                $stmt = $bdd->prepare("UPDATE lit SET chambre_id = :chambre_id, numero_lit = :numero_lit, statut = :statut WHERE id_lit = :id_lit");
                $stmt->bindParam(':id_lit', $id_lit, PDO::PARAM_INT);
                $stmt->bindParam(':chambre_id', $chambre_id, PDO::PARAM_INT);
                $stmt->bindParam(':numero_lit', $numero_lit, PDO::PARAM_STR);
                $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $message = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">Lit modifié avec succès !</div>';
                    // Fetch the updated lit data
                    $stmt = $bdd->prepare("SELECT * FROM lit WHERE id_lit = :id_lit");
                    $stmt->bindParam(':id_lit', $id_lit, PDO::PARAM_INT);
                    $stmt->execute();
                    $lit = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {
                $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Erreur lors de la modification du lit : ' . $e->getMessage() . '</div>';
            }
        }

        echo $message;

        if ($lit):
        ?>
        <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="id_lit" value="<?php echo htmlspecialchars($lit['id_lit']); ?>">
            
            <div>
                <label for="chambre_id" class="block text-sm font-medium text-gray-700">Chambre ID :</label>
                <input type="number" id="chambre_id" name="chambre_id" value="<?php echo htmlspecialchars($lit['chambre_id']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            
            <div>
                <label for="numero_lit" class="block text-sm font-medium text-gray-700">Numéro du lit :</label>
                <input type="text" id="numero_lit" name="numero_lit" value="<?php echo htmlspecialchars($lit['numero_lit']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut :</label>
                <select id="statut" name="statut" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="libre" <?php echo $lit['statut'] == 'libre' ? 'selected' : ''; ?>>Libre</option>
                    <option value="occupé" <?php echo $lit['statut'] == 'occupé' ? 'selected' : ''; ?>>Occupé</option>
                </select>
            </div>
            
            <div>
                <input type="submit" name="modifier" value="Modifier" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>
        </form>
        <?php else: ?>
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">Aucun lit sélectionné pour modification.</div>
        <?php endif; ?>
    </div>
    <script>
        // Add any additional JavaScript here
    </script>
</body>
</html>