<html>
<head>

</head>
<body bgcolor="blue"> 
<?php
include"connexion.php";
?>

<h1>inscrivez-vous</h1>
<meta charset="utf_8"/>
</head>
<body>
<?php include 'Accueil.php';?>;
<form method="POST" action="">
<table>
<tr>
<th>nom_bloc</th>
<th><input type="text" name="nom_bloc" required></th>
</tr>
<th>description</th>
<th><input type="text" name="description" required></th>
</tr>
<tr> <th> </th>
<td> <input type="submit" name="envoyer" value ="enregistrer"/>
   <input type="reset" value="supprimer"/>
   </td>
 </tr>
 </table>
 </from>

</body>
</html>
<?php
if(isset($_POST["envoyer"]))
{

$recupnom=$_POST["nom_bloc"];
$recupdescr=$_POST["description"];

$Insertionbloc ="INSERT INTO bloc (nom_bloc,description) VALUES('$recupnom','$recupdescr')";
$bdd->exec($Insertionbloc ); 
header("location:affichagebloc.php");
}
?>


<style>
h1,h2{
	color:aqua;

</style>


</body>
</html>