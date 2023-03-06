<?php
session_start();
if (isset($_SESSION['connect'])) {
    header('location: clientDashboard.php?success=1');
    exit;
}
require("../commun/connexion.php");
if (isset($_POST['submit'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email    =  htmlspecialchars($_POST['email']);
            $password =  htmlspecialchars($_POST['password']);
            $error = 1;
            //HASH PASSWORD 
            $password = "aq1" . sha1($password . "1234") . "25";    //aq1 et 1234 25 sont des grain de sels

            $requete = $db->prepare("SELECT * FROM clients WHERE email=?");
            $requete->execute(array($email));
            while ($user = $requete->fetch()) {
                if ($password == $user['motDePasse']) {
                    $error = 0;

                    $_SESSION['fullName'] = $user['fullName']; // c'est pour ca quand a fetch tout
                    $_SESSION['idClient'] = $user['idClient'];
                    $_SESSION['email']    = $user['email'];
                    $_SESSION['adresse']  = $user['adresse'];
                    $_SESSION['idZoneGeo']  = $user['idZoneGeographique'];
                    $_SESSION['connect']  = 1;

                    if (isset($_POST['connect'])) {
                        setcookie('connect', $user['secret'], time() + 365 * 24 * 3600, '/', null, false, true);
                    }
                    header('location: clientDashboard.php?success=1');
                    exit();
                }
            }
            if ($error == 1) {
                header('location: LoginAsAClient.php?error=1');
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>LoginAsAClient</title>
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
        <form method="post" action="LoginAsAClient.php">
            <?php
            if (isset($_GET['error'])) { ?>
                <div>
                    <p>Email ou mot de passe incorrect!</p>
                </div>
            <?php
            }
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
                <input class="login-btn" type="submit" value="Log in" name="submit">
            </div>

            <div class=" P1">
                <p>Don't you have an account? <a href="JoinAsAClient.php" class="sign-in"> Sign in </a> </p>
            </div>

        </form>
    </div>

</body>

</html>