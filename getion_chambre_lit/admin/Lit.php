<?php
include "connexion.php"; 

if (isset($_POST["envoyer"])) {
    $recupenum = $_POST["numero_lit"];
    $recupstatut = $_POST["statut"];
    $recupbloc = $_POST["bloc"];
    $recupchambre = $_POST["chambre"];
    
    $insertlit = "INSERT INTO lit (numero_lit, statut, id_bloc, id_chambre) 
                  VALUES ('$recupenum', '$recupstatut', '$recupbloc', '$recupchambre')";
    
    $bdd->exec($insertlit);
    header("Location: affichagelit.php");
    exit(); // It's a good practice to call exit after header redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>lit</title>
<style>
    form {
        margin-top: 100px;
    }
</style>
</head>
<body>
    <?php include "Accueil.php"; ?>
    <form method="POST" action="">
        <table>
            <tr>
                <th>numero_lit</th>
                <th><input type="text" name="numero_lit" required></th>
            </tr>
            <tr>
                <th>statut</th>
                <th><input type="text" name="statut" required></th>
            </tr>
            <tr>
                <th>bloc</th>
                <th>
                    <select name="bloc" required>
                        <option value="" disabled selected>Sélectionnez un bloc</option>
                        <?php
                        $affichagebloc = $bdd->query("SELECT * FROM bloc");
                        while ($datarecup = $affichagebloc->fetch()) {
                        ?> 
                        <option value="<?php echo $datarecup["id_bloc"]; ?>">
                            <?php echo $datarecup["nom_bloc"]; ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                </th>
            </tr>
            <tr>
                <th>chambre</th>
                <th>
                    <select name="chambre" required>
                        <option value="" disabled selected>Sélectionnez un employe</option>
                        <?php
                        $affichagechambre = $bdd->query("SELECT * FROM chambre");
                        while ($datarecup = $affichagechambre->fetch()) {
                        ?> 
                        <option value="<?php echo $datarecup["id_chambre"]; ?>">
                            <?php echo $datarecup["numero"]; ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                </th>
            </tr>
            <tr>
                <td><input type="submit" value="Envoyer" name="envoyer"></td>
            </tr>
        </table>
    </form>
</body>
</html>