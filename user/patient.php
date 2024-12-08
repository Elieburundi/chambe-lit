<html>
<head>

</head>
<body> 
<?php
include"connexion.php";
include"Accueil.php";
$affichageRecl = $bdd->query("Select * from patient");
?>
<?php

$pdo = new PDO('mysql:host=localhost;dbname=gestion_chambre_lit;charset=utf8', 'root', '');
	
?> 


<h1>inscrivez-vous</h1>
<meta charset="utf_8"/>
</head>
<body bgcolor="">
<?php include 'Accueil.php';?>;

<form method="POST" action="">
<table>


<tr> <th>nom</th>
<td> <input type="text" name="nom" require autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"/> </td>
</tr>
<tr> <th>date_naissance</th>
<td> <input type="date" name="date_naissance"  require pattern="[0-9]*"/> </td>
</tr>
<tr> <th>Contact_id</th>
<td> <input type="text" name="contact_id" require pattern="[A-Za-zÀ-ÿ\s]{2,20}"/> </td>
</tr>

<tr> <th>contact</th>
<td> <input type="text" name="contact" require pattern="[0-9]*"/> </td>
</tr>

<tr> <th> </th>
<td> <input type="submit" name="envoyer" value ="enregistrer"/>
   <input type="reset" value="supprimer"/>
   </td>
 </tr>
 </table>
 </from>

</body>

<?php
if(isset($_POST["envoyer"]))
{
//$recupId=$_POST["numero_patient"];
$recupnom=$_POST["nom"];
$recupprenom=$_POST["prenom"];
$recuprole=$_POST["role"];
$recuppcontact=$_POST["contact"];
$trouveemploye = $bdd->prepare("Select * from employe where contact= :contact");
$trouveemploye->bindParam(':contact', $recuppcontact, PDO::PARAM_STR);
$trouveemploye->execute();
if($trouveemploye->rowCount() > 0){
    echo "Personnes existe deja";
    }
    else{
        $InsertionEmploye ="INSERT INTO Employe (nom,prenom,role,contact) VALUES('$recupnom','$recupprenom','$recuprole','$recuppcontact')";
        $bdd->exec($InsertionEmploye );

        header("location:affichageemploye.php");
        }
}
?>
<style>
    .center {
        text-align:center;
    }
    </style>
    <div class="center">

<style>
h1,h2{
	color:aqua;

</style>


</body>
</html>
