<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création des publications</title>
    <p><img src="choix.jpg" height="400px" width="1700px"> </p>
</head>
<body class="bg-gray-100" bgcolor=chocolate>
    <?php include "Accueil.php"; ?>

    <div class="container mx-auto px-4 py-8">
        <section id="comment-form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold text-chocolate mb-6">Publier un message</h2>
            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block text-blue-500 text-sm font-bold mb-2" for="titre">
                        Titre
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="titre" id="titre" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="block text-blue-500 text-sm font-bold mb-2" for="date_publication">
                        Date de publication
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date" name="date_publication" id="date_publication" required>
                </div>
                <div class="mb-6">
                    <label class="block text-blue-500 text-sm font-bold mb-2" for="contenu">
                        Contenu
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="contenu" id="contenu" rows="5"></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="Envoyer" value="Publier">
                </div>
            </form>
        </section>

        <?php
        if(isset($_POST["Envoyer"])) {
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=gestion_chambre_lit;charset=utf8', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $bdd->prepare("INSERT INTO publication (titre, date_publication, contenu) VALUES (:titre, :date_publication, :contenu)");
                $stmt->execute([
                    ':titre' => $_POST["titre"],
                    ':date_publication' => $_POST["date_publication"],
                    ':contenu' => $_POST["contenu"]
                ]);

                echo "<p class='text-green-500 font-bold mt-4'>Publication ajoutée avec succès!</p>";
            } catch(PDOException $e) {
                echo "<p class='text-red-500 font-bold mt-4'>Erreur : " . $e->getMessage() . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>