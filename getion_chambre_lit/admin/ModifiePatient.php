
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
<?php
 $affichagepatient = $bdd->query("select * from patient as pt join bloc as bl on pt.id_bloc= bl.id_bloc join chambre as chamb on pt.id_chambre=chamb.id_chambre join lit as lt on pt.id_lit=lt.id_lit join employe as empl on pt.id_employe=empl.id_employe where id_patient='".$_GET['mod']."'");
 $datarecup= $affichagepatient->fetch();
?>
</head>
<body>
    <?php include "Accueil.php";?>
<form method="POST" action="">
<table>
<tr>
<th>nom</th>
<th><input type="text" value="<?php echo $datarecup["nom"]?>" name="nom" required></th>
</tr>
<tr>
<th>prenom</th>
<th><input type="text" value="<?php echo $datarecup["prenom"]?>" name="prenom" required></th>
</tr>
<th>date_naissance</th>
<th><input type="date"value="<?php echo $datarecup["date_naissance"]?>" name="date_naissance" required></th>
</tr>
<th>contact_id</th>
<th><input type="text"value="<?php echo $datarecup["contact_id"]?>" name="contact_id" required></th>
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
<?php
if(isset($_POST["envoyer"])){
$recupenom=$_POST["nom"];
$recupeprenom=$_POST["prenom"];
$recupdate=$_POST["date_naissance"];
$recupecontact=$_POST["contact_id"];
$recupsbloc=$_POST["bloc"];
$recupchambre=$_POST["chambre"];
$recupelit=$_POST["lit"];
$recupeemploye=$_POST["employe"];

$insertpatient= "update patient set nom='$recupenom',prenom='$recupeprenom',date_naissance='$recupdate',contact_id='$recupecontact',id_bloc='$recupsbloc',id_chambre='$recupchambre',id_lit='$recupelit',id_employe='$recupeemploye'where id_chambre='".$_GET['mod']."'";
$bdd->exec($insertpatient);
header("location:affichagepatient.php");
}
?>
</body>
</html>

