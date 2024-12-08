<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Bloc</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .neumorphic {
            background: #f0f0f0;
            box-shadow: 12px 12px 24px #cccccc, -12px -12px 24px #ffffff;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <?php include 'Accueil.php'; ?>
    
    <div class="container max-w-md w-full bg-white rounded-lg shadow-lg p-8 neumorphic">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Modifier Bloc</h1>
        
        <div id="message" class="hidden mb-4 p-4 rounded-md text-center"></div>

        <?php
        include "connexion.php";

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $bdd->prepare("SELECT * FROM bloc WHERE id_bloc = :id_bloc");
            $stmt->bindParam(':id_bloc', $id, PDO::PARAM_INT);
            $stmt->execute();
            $bloc = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$bloc) {
                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">Bloc non trouvé.</div>';
                exit;
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
            $id = filter_input(INPUT_POST, 'id_bloc', FILTER_SANITIZE_NUMBER_INT);
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

            $stmt = $bdd->prepare("UPDATE bloc SET nom = :nom, description = :description WHERE id_bloc = :id_bloc");
            $stmt->bindParam(':id_bloc', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);

            try {
                if ($stmt->execute()) {
                    echo '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">Bloc modifié avec succès !</div>';
                } else {
                    echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">Erreur lors de la modification du bloc.</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
            }

            $stmt = $bdd->prepare("SELECT * FROM bloc WHERE id_bloc = :id_bloc");
            $stmt->bindParam(':id_bloc', $id, PDO::PARAM_INT);
            $stmt->execute();
            $bloc = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>

        <?php if (isset($bloc)): ?>
        <form id="modifyForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="id_bloc" value="<?php echo htmlspecialchars($bloc['id_bloc']); ?>">
            
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($bloc['nom']); ?>" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description :</label>
                <textarea id="description" name="description" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                          rows="3"><?php echo htmlspecialchars($bloc['description']); ?></textarea>
            </div>
            
            <div>
                <button type="submit" name="modifier"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Modifier
                </button>
            </div>
        </form>
        <?php else: ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            Aucun bloc sélectionné pour modification.
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('modifyForm');
        const messageDiv = document.getElementById('message');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!validateForm()) {
                    return;
                }

                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form)
                })
                .then(response => response.text())
                .then(data => {
                    messageDiv.innerHTML = data;
                    messageDiv.classList.remove('hidden');
                    if (data.includes('succès')) {
                        messageDiv.classList.add('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700', 'p-4');
                        Swal.fire('Succès!', 'Le bloc a été modifié avec succès.', 'success');
                    } else {
                        messageDiv.classList.add('bg-red-100', 'border-l-4', 'border-red-500', 'text-red-700', 'p-4');
                        Swal.fire('Erreur!', 'Une erreur est survenue lors de la modification du bloc.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Erreur!', 'Une erreur est survenue lors de la communication avec le serveur.', 'error');
                });
            });
        }

        function validateForm() {
            const nom = document.getElementById('nom_bloc').value.trim();
            const description = document.getElementById('description').value.trim();

            if (nom === '') {
                Swal.fire('Erreur!', 'Le champ Nom est requis.', 'error');
                return false;
            }

            if (description === '') {
                Swal.fire('Erreur!', 'Le champ Description est requis.', 'error');
                return false;
            }

            return true;
        }
    });
    </script>
</body>
</html>