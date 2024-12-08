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


<tr> <th>nom</th>
<td> <input type="text" name="nom" require autofocus pattern="[A-Za-zÀ-ÿ\s\[0-9]]{2,20}"/> </td>
</tr>
<tr> <th>description</th>
<td> <input type="text" name="description"require autofocus pattern="[A-Za-zÀ-ÿ\s{2,20}"/>  </td>
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

$recupnom=$_POST["nom"];
$recupdescr=$_POST["description"];

$Insertionbloc ="INSERT INTO bloc (nom,description) VALUES('$recupnom','$recupdescr')";
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