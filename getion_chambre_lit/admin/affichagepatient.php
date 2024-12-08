<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_patient</title>

</head>
<body>
<?php
// include "Accueil.php";
include "connexion.php";
?>
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

$insertpatient="insert into patient(nom,prenom,date_naissance,contact_id,id_bloc,id_chambre,id_lit,id_employe) values ('$recupenom','$recupeprenom','$recupdate','$recupecontact','$recupsbloc','$recupchambre','$recupelit','$recupeemploye')";
$bdd->exec($insertpatient);
//header("location:affichagepatient.php");
}
?>
<table border=2 left=10px>
<tr>
<th>nom</th>
<th>prenom</th>
<th>date_naissance</th>
<th>contact_id</th>

<th colspan="1">actions</th>
</tr>
<?php 

$affichagepatient = $bdd->query("select * from patient as pt join bloc as bl on pt.id_bloc= bl.id_bloc join chambre as chamb on pt.id_chambre=chamb.id_chambre join lit as lt on pt.id_lit=lt.id_lit join employe as empl on pt.id_employe=empl.id_employe ;");


if(isset($_GET["sup"])){
$supression=$bdd->query("delete from patient where id_patient='".$_GET['sup']."'");
} 

while($datarecup=$affichagepatient->fetch())
{
?>
<tr>
<td><?php echo $datarecup["nom"]?></td>
<td><?php echo $datarecup["prenom"]?></td>
<td><?php echo $datarecup["date_naissance"]?></td>
<td><?php echo $datarecup["contact_id"]?></td>
<td><?php echo $datarecup["nom_bloc"]?></td>
<td><?php echo $datarecup["numero"]?></td>
<td><?php echo $datarecup["chambre_id"]?></td>
<td><?php echo $datarecup["nom"]?></td>
<td><a href="modifiepatient.php?mod=<?php echo $datarecup["id_patient"]; ?>">Modifier</a></td>
<td><a href="affichagepatient.php?sup=<?php echo $datarecup["id_patient"]; ?>">supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>

