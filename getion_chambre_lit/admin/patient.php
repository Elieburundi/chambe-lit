
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
<form method="POST" action="affichagepatient.php">
<table>
<tr>
<th>nom</th>
<th><input type="text" name="nom" required></th>
</tr>
<tr>
<th>prenom</th>
<th><input type="text" name="prenom" required></th>
</tr>
<th>date_naissance</th>
<th><input type="date" name="date_naissance" required></th>
</tr>
<th>contact_id</th>
<th><input type="text" name="contact_id" required></th>
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
  <th>chambre</th>
  <th>
            <select name="chambre" required>
            <option value="" disabled selected>Sélectionnez une chambre</option>
            <?php
            $affichagechamb = $bdd->query("select * from chambre");
            while ($datarecup = $affichagechamb->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_chambre"];?>">
            <?php echo $datarecup["numero"]; ?>
            </option>
            <?php
            }
            ?>
            </select>
  </th>
</tr>
<tr>
  <th>lit</th>
  <th>
            <select name="lit" required>
            <option value="" disabled selected>Sélectionnez un lit</option>
            <?php
            $affichagelit = $bdd->query("select * from lit");
            while ($datarecup = $affichagelit->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_lit"];?>">
            <?php echo $datarecup["chambre_id"]; ?>
            </option>
            <?php
            }
            ?>
            </select>
  </th>
</tr>
<tr>
  <th>employe</th>
  <th>
            <select name="employe" required>
            <option value="" disabled selected>Sélectionnez un employe</option>
            <?php
            $affichagemploye = $bdd->query("select * from employe");
            while ($datarecup = $affichagemploye->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_employe"];?>">
            <?php echo $datarecup["nom"]; ?>
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

