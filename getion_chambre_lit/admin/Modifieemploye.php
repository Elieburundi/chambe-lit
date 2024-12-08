
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>employe</title>
<style>
    form{
        margin-top:100px;
    }
</style>
<?php

include "connexion.php"; 
?>
<?php
$affichageemploye = $bdd->query("select * from employe as emp join bloc as bl on emp.id_bloc= bl.id_bloc join lit as li on emp.id_lit=li.id_lit join chambre as ch on ch.id_chambre=emp.id_ch where id_employe='".$_GET['mod']."'");
$datarecup=$affichageemploye->fetch();
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
<th>prenom</th>
<th><input type="text" value="<?php echo $datarecup["prenom"]?>" name="prenom" required></th>
</tr>
<th>role</th>
<th><input type="text" value="<?php echo $datarecup["role"]?>" name="role" required></th>
</tr>
<th>contact</th>
<th><input type="text" value="<?php echo $datarecup["contact"]?>" name="contact" required></th>
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
                    $affichagechambre = $bdd->query("select * from chambre");
                    while ($datarecup = $affichagechambre->fetch()) {
                    ?> 
                    <option value="<?php echo $datarecup["id_chambre"]; ?>" >
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
                    <option value="<?php echo $datarecup["id_lit"]; ?>" >
                    <?php echo $datarecup["chambre_id"]; ?>
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
$recupprenom=$_POST["prenom"];
$recuprole=$_POST["role"];
$recupcontact=$_POST["contact"];
$recupbloc=$_POST["bloc"];
$recupechambre=$_POST["chambre"];
$recupelit=$_POST["lit"];
$updateemploye="update employe set nom='$recupenom',prenom='$recupprenom',role='$recuprole',contact='$recupcontact',id_bloc='$recupbloc',id_ch='$recupechambre',id_lit='$recupelit'where id_employe='".$_GET['mod']."'";
$bdd->exec($updateemploye);
header("location:affichageemploye.php");
}
?>
</body>
</html>

