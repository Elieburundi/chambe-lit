<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_employe</title>

</head>
<body>
<?php
// include "Accueil.php";
include "connexion.php";
?>
<?php
if(isset($_POST["envoyer"])){
$recupenom=$_POST["nom"];
$recupprenom=$_POST["prenom"];
$recuprole=$_POST["role"];
$recupcontact=$_POST["contact"];
$recupbloc=$_POST["bloc"];
$recupechambre=$_POST["chambre"];
$recupelit=$_POST["lit"];
$insertemploye="insert into employe(nom,prenom,role,contact,id_bloc,id_ch,id_lit) values ('$recupenom','$recupprenom','$recuprole','$recupcontact','$recupbloc','$recupechambre','$recupelit')";
$bdd->exec($insertemploye);
//header("location:affichageemploye.php");
}
?>
<table border=2 left=10px>
<tr>
<th>nom</th>
<th>prenom</th>
<th>role</th>
<th>Contact</th>
<th>bloc</th>
<th>numero chambre</th>
<th>numero lit</th>
<th colspan="2">actions</th>
</tr>
<?php 


$affichageemploye = $bdd->query("select * from employe as emp join bloc as bl on emp.id_bloc= bl.id_bloc join lit as li on emp.id_lit=li.id_lit join chambre as ch on ch.id_chambre=emp.id_ch;");


if(isset($_GET["sup"])){
$supressionchambre=$bdd->query("delete from employe where id_employe='".$_GET['sup']."'");
} 

while($datarecup=$affichageemploye->fetch())
{
?>
<tr>
<td><?php echo $datarecup["nom"]?></td>
<td><?php echo $datarecup["prenom"]?></td>
<td><?php echo $datarecup["role"]?></td>
<td><?php echo $datarecup["contact"]?></td>
<td><?php echo $datarecup["nom_bloc"]?></td>
<td><?php echo $datarecup["numero"]?></td>
<td><?php echo $datarecup["numero_lit"]?></td>
<td><a href="modifieemploye.php?mod=<?php echo $datarecup["id_employe"]; ?>">Modifier</a></td>
<td><a href="affichageemploye.php?sup=<?php echo $datarecup["id_employe"]; ?>">supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>

