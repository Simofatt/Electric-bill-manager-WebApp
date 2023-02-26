<?php
/*
session_start();
if (isset($_SESSION['connect'])) {
    header('location: dashboard.php?succes=1');
    exit;
}
require("connexion.php");
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email    =  $_POST['email'];
    $password =  $_POST['password'];
    $error = 1;
    //HASH PASSWORD 
    $password = "aq1" . sha1($password . "1234") . "25";    //aq1 et 1234 25 sont des grain de sels

    $requete = $db->prepare("SELECT *  FROM brands WHERE email=? ");
    $requete->execute(array($email));
    while ($user = $requete->fetch()) {
        if ($password == $user['password']) {
            $error = 0;
            $_SESSION['connect'] = 1;
            $_SESSION['name_brand']  = $user['name_brand']; // c'est pour ca quand a fetch tout
            $_SESSION['id_brand'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['instagram_account'] = $user['instagram_account'];

            if (isset($_POST['connect'])) {
                setcookie('connect', $user['secret'], time() + 365 * 24 * 3600, '/', null, false, true);
            }
            header('location: dashboard.php?succes=1');
            exit();
        }
    }
    if ($error == 1) {
        header('location: login_as_a_brand.php?error=1');
        exit();
    }
}
*/
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>LoginAsAnAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Square+Peg&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=<?php echo time(); ?>">
</head>

<body>
    <nav>
        <a href="acceuil.html">
            <h2 class="logo">L'Y<span>DEC</span></h2>
        </a>
    </nav>

    <div class="title">
        <h2>Log in to L'Y<span>DEC</span></h2>
    </div>

    <div class="container">
        <form method="post" action="LoginAsAnAdmin.php">
            <?php /*
            if (isset($_GET['error'])) { ?>
                <div>
                    <p>Email ou mot de passe incorrect!</p>
                </div>
            <?php
            }*/
            ?>
            <div class="txt-field">
                <input type="email" name="email" class="txt-css" required>
                <label>Email</label>
            </div>

            <div class="txt-field">
                <input type="password" name="password" class="txt-css" required>
                <label>Password</label>
            </div>
            <div>
                <label><input id="checkbox" type="checkbox" name="connect">Auto login </label>
            </div>

            <div>
                <input class="login-btn" type="submit" value="Log in">
            </div>


        </form>
    </div>

</body>

</html>