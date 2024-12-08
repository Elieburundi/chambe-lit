<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_lit</title>

</head>
<body>
<?php
// include "Accueil.php";
include "connexion.php";
?>
<table border=2 left=10px>
<tr>
<th>numero_lit</th>
<th>statut</th>
<th>bloc</th>
<th>chambre</th>
<th colspan="2">actions</th>
</tr>
<?php 


$affichagelit = $bdd->query("select * from lit as li join bloc as bl on li.id_bloc= bl.id_bloc join chambre as chamb on chamb.id_chambre=li.id_chambre;");


if(isset($_GET["sup"])){
$supression=$bdd->query("delete from lit where id_lit='".$_GET['sup']."'");
} 

while($datarecup=$affichagelit->fetch())
{
?>
<tr>

<td><?php echo $datarecup["numero_lit"]?></td>
<td><?php echo $datarecup["statut"]?></td>
<td><?php echo $datarecup["nom_bloc"]?></td>
<td><?php echo $datarecup["numero"]?></td>
<td><a href="modifielit.php?mod=<?php echo $datarecup["id_lit"]; ?>">Modifier</a></td>
<td><a href="affichagelit.php?sup=<?php echo $datarecup["id_lit"]; ?>">supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>

