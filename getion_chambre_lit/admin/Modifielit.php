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
$affichagelit = $bdd->query("select * from lit as li join bloc as bl on li.id_bloc= bl.id_bloc join chambre as chamb on chamb.id_chambre=li.id_chambre where id_lit='".$_GET['mod']."'");
$datarecup=$affichagelit->fetch();
?>

</head>
<body>
<form method="POST" action="">
<table>
<tr>
<th>numero_lit</th>
<th><input type="text" value="<?php echo $datarecup["numero_lit"]?>" name="numero_lit" required></th>
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
  <th>chambre</th>
        <th>
                <select name="chambre" required>
                    <option value="" disabled selected>Sélectionnez un employe</option>
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
<td><input type="submit" value="Envoyer" name="envoyer"></td>
</tr>
</table>
</form>
<?php
if(isset($_POST["envoyer"])){

$recupenum=$_POST["numero_lit"];
$recupstatut=$_POST["statut"];
$recupbloc=$_POST["bloc"];
$recupchambre=$_POST["chambre"];
$insertlit="insert into lit(chambre_id,numero_lit,statut,id_bloc,id_chambre) values ('$recupchamb','$recupenum','$recupstatut','$recupbloc','$recupchambre')";
$bdd->exec($insertlit);
header("location:affichagelit.php");
}
?>
</body>
</html>

