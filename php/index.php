<?php



if (isset($_POST[Prenom])){
  $prenom = htmlspecialchars($_POST[Prenom]);
  echo'Bonjour'.$prenom.'!' ;
}
if (isset($_FILE['image'] )&& $_FILE['image']['error']==0) {                      //si le fichier est bien present et il ya pas d'erreur dans upload au serveur isset==existe
  $error = 1 ; 
    if($_FILE['image']['size'] <= 3000000) {                                      //si le size du fich <= 3mo
      $information_image = pathinfo($_FILE['image']['name'] );                    //Prendre les infos sous forme dun tableau du fich 
      $information_extension =  $information_image['extension'] ;                 //prendre juste l'extensin
      $array_info = array('png' , 'gif' , 'jpg' , 'jpeg') ;                       //creer un tableau des extension admissible 
      if (in_array($information_extension , $array_info)) {                       //si l'extension du fich est parmis l'un des array_info
        $addresse ='uploads/'.time().rand().'.'.$information_extension; 
      move_uploaded_file( $_FILE['image'] ['tmp_name'] , $address) ;             //move le fich de l'mplacement tempo a la destination voulue, avec des id unique
      $error = 0 ; 
     }
    }
}

if (isset($error) && $error==0) {
  echo ' <img src ="$address"  id =""> ' ; 
}elseif (isset($error) && $error ==1 ) {
  echo'Erreur extension'; 
}

 echo '  <form method="post" action=index.php"  >  
<table>
<tr>
<td>Prenom </td>
<td> <input type="text" name ="person" /></td>
</tr>
</table> ';

echo' <form method ="post " action ="index.php" enctype = multipart/form-data > 
<input name ="image" type ="file" > ';


//BASE DE DONNEE : 
try {
  $bdd = new PDO('mysql:host=localhost ; dbname =project; charset=ut8', 'root' ,'' ) ; 
  }catch (Exception $e ) { 
    die('Erreur : ' .$e->getMessage()) ; 
  }


$prenom = "mohamed" ; 
$nom = "fatehi " ; 
$requete =$bdd->exec('INSERT INTO brands(id , prenom , nom ) VALUES("1", "mohamed","fatehi") ');                 //INSERT--> exec     ,    $requete--> cursor 
$requete = $bdd->prepare('SELECT*FROM brands WHERE nom = "mohamed" ') ; 
$requete =$dbb->exec('UPDATE bradns SET nom = "mohamed" WHERE id = "1" ')  ;
$requete = $bdd-> exec('DELETE FROM brands WHERE nom = "mark"') or die (print_r($bdd->errorInfo()));         //Print l'erreur si jamais il en a une                                         //FETCH --> query 
$requete = $bdd-> prepare ('SELECT nom , prenom , u.serie_pref AS serie_pref , j.serie_pref AS metier from users as u  INNER JOIN jobs AS j  ON users.id = jobs.id WHERE prenom = ? && nom = ?') ;           // Si il ya 2 colonne de m nom, utiliser les alias 
$requete->execute(array($prenom , $nom ));

while ($donnees =$requete->fetch()) {           //si il ya une ligne me la stocker dans donnee                                                                //donnees est un tableau , tant que il ya une ligne a lire 
  echo $donnees['prenom'] ;
  echo $donnees['metier']  ; 
  echo $donnees['serie_pref']  ;
  echo sha1($donnees['mdp'] );   //crypter les donnes sha1
}
$requete->closeCursor();


$pseudo = (!empty($_POST['prenom'])) ? $_POST['prenom'] :'unkown user' ;  //condition ternaire. 
echo 'hello'. $pseudo ; 


//COOKIE
if(!empty($_POST['pseudo'])) { 
  $pseudo =$_POST['pseudo']; 
setcookie('pseudo ' , $pseudo , time() +324*24*3600 , null , null , false , true ) ;   // nomDuCookie , saValeur , dateDexpiration , httpOnly
echo'<h2>' .htmlspecialchars($_COOKIE['pseudo']) . '</h2>' ;                           //securiteContreLeXXS
}

//SESSION
SESSION_START() ;
if(!empty($_POST['pseudo'])) { 
  $pseudo =$_POST['pseudo']; 
  $_SESSION['pseudo '] = $pseudo ; 


  
}

    





?>