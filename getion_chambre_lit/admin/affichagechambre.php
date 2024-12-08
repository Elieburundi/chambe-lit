<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_chambre</title>

</head>
<body>
<?php
// include "Accueil.php";
include "connexion.php";
?>
<?php
if(isset($_POST["envoyer"])){
$recupenum=$_POST["numero"];
$recuptype=$_POST["type"];
$recupstatut=$_POST["statut"];
$recupbloc=$_POST["bloc"];
//$recupemploye=$_POST["employe"];
$insertchambre="insert into chambre(numero,type,statut,id_bloc) values ('$recupenum','$recuptype','$recupstatut','$recupbloc')";
$bdd->exec($insertchambre);
//header("location:affichagechambre.php");
}
?>
<table border=2 left=10px>
<tr>
<th>numero</th>
<th>type</th>
<th>statut</th>
<th>bloc</th>

<th colspan="2">actions</th>
</tr>
<?php

$affichagechambre = $bdd->query("select * from chambre as ch join bloc as bl on ch.id_bloc= bl.id_bloc ;");


if(isset($_GET["sup"])){
$supressionchambre=$bdd->query("delete from chambre where id_chambre='".$_GET['sup']."'");
} 

while($datarecup=$affichagechambre->fetch())
{
?>
<tr>
<td><?php echo $datarecup["numero"]?></td>
<td><?php echo $datarecup["type"]?></td>
<td><?php echo $datarecup["statut"]?></td>
<td><?php echo $datarecup["nom_bloc"]?></td>
<td><a href="modifiechambre.php?mod=<?php echo $datarecup["id_chambre"]; ?>">Modifier</a></td>
<td><a href="affichagechambre.php?sup=<?php echo $datarecup["id_chambre"]; ?>">supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>

