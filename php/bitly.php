<?php 
// IS RECEIVED SHORTCUT
if(isset($_GET['q'])){

	// VARIABLE
	$shortcut = htmlspecialchars($_GET['q']);

	// IS A SHORTCUT ?
	$bdd = new PDO('mysql:host=localhost;dbname=bitly;charset=utf8', 'root', '');
	$req =$bdd->prepare('SELECT COUNT(*) AS x FROM links WHERE shortcut = ?');
	$req->execute(array($shortcut));

	while($result = $req->fetch()){

		if($result['x'] != 1){
			header('location: ../?error=true&message=Adresse url non connue');
			exit();
		}

	}

	// REDIRECTION
	$req = $bdd->prepare('SELECT * FROM links WHERE shortcut = ?');
	$req->execute(array($shortcut));

	while($result = $req->fetch()){

		header('location: '.$result['url']);
		exit();

	}

}
if (isset($_POST['url'])) {
    $url = $_POST['url '];

//VERIFICATION DE LURL :

   if (!filter_var($url, FILTER_VALIDATE_URL)) {                     //si ce n'est pas un url >>
    header ('location : ../?error=true&message=url non valide' ) ;   //url et parametre.      
    exit() ; 
}
}
//SHORTCUT 
$shortcut = crypt($url,rand()) ; 

//HAS BEEN ALREADY SENT ? 
try {
    $bdd = new PDO('mysql:host=localhost ; dbname =project; charset=ut8', 'root' ,'' ) ; 
    }catch (Exception $e ) { 
      die('Erreur : ' .$e->getMessage()) ; 
    }
   $requete = $bdd -> prepare('SELECT COUNT() AS x   FROM xxx WHERE url = ?') ;     //Toujours utilise les ? ne pas entrer les info a la main
   $requete->execute(array($url)) ;   

   while ( $result = $requete-> fetch()) { 
     if ($result['x'] !=0) {                                                        //if count !=0 //result c'est une array 
        header('location : ../?error=true&&message=Adresse deja utilise') ; 
     }

     //SENDING 

      $requete = $dbb-> prepare('INSERT INTO links(url , shortcut ) VALUES (? ,? ) ' ) ; 
      $requete -> execute(array($url , $shortcut)) ; 
      header('location: ../?short=' .$shortcut) ; 
      exit() ; 


   }

?>


<form method ="post" action ="../"> 
   <input type="url"  name="url"> 
</form>

<?php 
if(isset($_GET['error']) && isset($_GET['message'])) {  ?>
   <div class = "center" > 
       <div class = "result " > 
          <?php  echo htmlspecialchars($_GET['message'] )  ;   ?>           // pour securise l'envoie des urls
       </div>
    </div>
<?php } else if (isset($_GET['short'])) { ?>
    <div class = "center" > 
       <div class = "result " > 
        <p>L'URL RACCOURCIE EST :    </p>
          http://localhost/?q=<?php  echo htmlspecialchars($_GET['short'] )  ;   ?>        
       </div>
    </div>
<?php }?>