<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Chambre</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e40af;
            color: #22d3ee;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <?php include 'Accueil.php'; ?>

    <div class="container p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold mb-6 text-center">Inscription Chambre</h1>

        <form method="post" action="" class="space-y-4">
            <div>
                <label for="numero" class="block mb-1">Numéro</label>
                <input type="text" name="numero" id="numero" class="w-full px-3 py-2 bg-blue-800 text-aqua rounded" required />
            </div>
            <div>
                <label for="type" class="block mb-1">Type</label>
                <input type="text" name="type" id="type" class="w-full px-3 py-2 bg-blue-800 text-aqua rounded" required />
            </div>
            <div>
                <label for="statut" class="block mb-1">Statut</label>
                <select name="statut" id="statut" class="w-full px-3 py-2 bg-blue-800 text-aqua rounded" required>
                    <option value="disponible">Disponible</option>
                    <option value="occupe">Occupé</option>
                    <option value="maintenance">En maintenance</option>
                </select>
            </div>
            <div class="flex justify-between">
                <input type="submit" name="envoyer" value="Enregistrer" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 cursor-pointer" />
                <input type="reset" value="Réinitialiser" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 cursor-pointer" />
            </div>
        </form>

        <?php
        include "connexion.php";

        if (isset($_POST["envoyer"])) {
            try {
                $recupnumero = filter_input(INPUT_POST, "numero", FILTER_SANITIZE_STRING);
                $recuptype = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
                $recupstatut = filter_input(INPUT_POST, "statut", FILTER_SANITIZE_STRING);

                $insertionChambre = "INSERT INTO chambre (numero, type, statut) VALUES (:numero, :type, :statut)";
                $stmt = $bdd->prepare($insertionChambre);
                
                $stmt->bindParam(':numero', $recupnumero);
                $stmt->bindParam(':type', $recuptype);
                $stmt->bindParam(':statut', $recupstatut);
                
                if ($stmt->execute()) {
                    echo "<p class='mt-4 text-green-400'>Chambre enregistrée avec succès!</p>";
                    // Uncomment the following line if you want to redirect after successful insertion
                    // header("Location: affichagechambre.php");
                    // exit();
                } else {
                    echo "<p class='mt-4 text-red-400'>Erreur lors de l'enregistrement de la chambre.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='mt-4 text-red-400'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        ?>
    </div>

    <script>
        // Add any JavaScript functionality here
    </script>
</body>
</html>>