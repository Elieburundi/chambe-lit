<html>
<head>

</head>
<body bgcolor="green"> 
<?php
include"connexion.php";
include"Accueil.php";
$affichageRecl = $bdd->query("Select * from contact");
?> 

<h1>inscrivez-vous</h1>
<meta charset="utf_8"/>
</head>
<body>

<form method="POST" action="">
<table>


<tr> <th>nom_contact</th>
<td> <input type="text" name="nom_contact" require autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"/></td>
</tr>
<tr> <th>relation</th>
<td> <input type="text" name="relation" require pattern="[A-Za-zÀ-ÿ\s]{2,20}"/> </td>
</tr>
<tr> <th>telephone</th>
<td> <input type="text" name="telephone" require pattern="[0-9]*"/> </td>
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

$recupnom=$_POST["nom_contact"];
$recuprole=$_POST["relation"];
$recuppcontact=$_POST["telephone"];
$trouvecontact = $bdd->prepare("Select * from contact where telephone= :telephone");
$trouvecontact->bindParam(':telephone', $recuppcontact, PDO::PARAM_STR);
$trouvecontact->execute();
if($trouvecontact->rowCount() > 0){
    echo "ce contact existe deja";
    }
    else{
      $InsertionEmploye ="INSERT INTO contact (nom_contact,relation,telephone) VALUES('$recupnom','$recuprole','$recuppcontact')";
      $bdd->exec($InsertionEmploye ); 
      header("location:affichagecontacte.php");
    }
}
?>


<style>
h1,h2{
	color:aqua;

</style>


</body>
</html>