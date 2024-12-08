<?php
// Start output buffering
ob_start();
?>

<html>
<head>
    <meta charset="utf-8"/>
    <style>
        body {
            background-color: darksalmon;
        }
        .container {
            background-color: #4CAF50;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body class="container">
<?php
include "connexion.php";
include "Accueil.php";

$pdo = new PDO('mysql:host=localhost;dbname=gestion_chambre_lit;charset=utf8', 'root', '');
?>

<h1>Voici nos chambres</h1>
 <p><img src="lit_vip.jpeg" height="700px" width="1500px"> </p>

<form method="POST" action="">
    <table>
        <tr>
            <th>num_chambre</th>
            <td><input type="text" name="numero_chambre" required pattern="[0-9]*"/></td>
        </tr>
        <tr>
            <th>num_lit</th>
            <td><input type="text" name="numero_lit" required pattern="[0-9]*"/></td>
        </tr>
        <tr>
            <th>statut</th>
            <td><input type="text" name="statut" required autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"/></td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input type="submit" name="Envoyer" value="valider"/>
                <input type="reset" value="supprimer"/>
            </td>
        </tr>
    </table>
</form>

<div class="center">
    <?php
    if (isset($_POST["Envoyer"])) {
        $recuppnumchambre = $_POST["numero_chambre"];
        $recuppnunmlit = $_POST["numero_lit"];
        $recupstatut = $_POST["statut"];

        $Insertionlit = "INSERT INTO lit (chambre_id, numero_lit, statut) VALUES ('$recuppnumchambre', '$recuppnunmlit', '$recupstatut')";
        $pdo->exec($Insertionlit);
        
        // Redirect after data insertion
        header("Location: affichagelit.php");
        exit(); // Always call exit after header redirection
    }
    ?>
</div>

</body>
</html>

<?php
// Flush the output buffer
ob_end_flush();
?>
