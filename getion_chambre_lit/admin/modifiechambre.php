
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>chambre</title>
<?php
include "connexion.php"; 
?>
<?php
$affichagechambre = $bdd->query("select * from chambre as ch join bloc as bl on ch.id_bloc= bl.id_bloc where id_chambre='".$_GET['mod']."'");
$datarecup=$affichagechambre->fetch();
?>

</head>
<body>
<form method="POST" action="">
<table>
<tr>
<th>numero</th>
<th><input type="text" value="<?php echo $datarecup["numero"]?>" name="numero" required></th>
</tr>
<th>type</th>
<th><input type="text" value="<?php echo $datarecup["type"]?>" name="type" required></th>
</tr>
<th>statut</th>
<th><input type="text" value="<?php echo $datarecup["statut"]?>" name="statut" required></th>
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
<?php
if(isset($_POST["envoyer"])){
$recupenum=$_POST["numero"];
$recuptype=$_POST["type"];
$recupstatut=$_POST["statut"];
$recupbloc=$_POST["bloc"];

$insertchambre="update chambre set numero='$recupenum',type='$recuptype',statut='$recupstatut',id_bloc='$recupbloc' where id_chambre='".$_GET['mod']."'";
$bdd->exec($insertchambre);
header("location:affichagechambre.php");
}
?>
</body>
</html>

