<?php
session_start();    // INITIALISE THE SESSION 
session_unset();    //DESACTIVER LA SESSION 
session_destroy();  //LA DETRUIRE 
setcookie('connect', '', time() - 3444, '/', null, false, true);       // time- x seconde va detruire votre cookie  
if (isset($_SESSION['connect'])) {
    $_SESSION['connect'] = "";
}
header('location: acceuil.php');
exit;
