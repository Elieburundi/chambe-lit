
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>chambre</title>
<style>
    form{
        margin-top:100px;
    }
</style>
<?php

include "connexion.php"; 
?>
</head>
<body>
    <?php include "Accueil.php";?>
<form method="POST" action="affichagechambre.php">
<table>
<tr>
<th>numero</th>
<th><input type="text" name="numero" required></th>
</tr>
<th>type</th>
<th><input type="text" name="type" required></th>
</tr>
<th>statut</th>
<th><input type="text" name="statut" required></th>
</tr>
<tr>
  <th>bloc</th>
  <th>
            <select name="bloc" required>
            <option value="" disabled selected>Sélectionnez un bloc</option>
            <?php
            $affichagebloc = $bdd->query("select * from bloc");
            while ($datarecup = $affichagebloc->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_bloc"];?>">
            <?php echo $datarecup["nom_bloc"]; ?>
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

