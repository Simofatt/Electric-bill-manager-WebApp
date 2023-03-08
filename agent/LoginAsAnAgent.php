<?php
session_start();
if (isset($_SESSION['connect'])) {
    header('location: AgentDashboard.php?succes=1');
    exit;
} else {
    require("../commun/connexion.php");
    if (isset($_POST['submit'])) {
        if (isset($_POST['pseudo']) &&  isset($_POST['password'])) {
            if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
                $pseudo   =  $_POST['pseudo'];
                $password =  $_POST['password'];
                $error = 1;
                //HASH PASSWORD 
                $password = "aq1" . sha1($password . "1234") . "25";

                $requete = $db->prepare("SELECT * FROM agent WHERE pseudo=?");
                $requete->execute(array($pseudo));
                $user = $requete->fetch();
                if ($user) {
                    if ($password == $user['motDePasse']) {
                        $error = 0;
                        $_SESSION['connect'] = 1;
                        $_SESSION['pseudo']  = $user['pseudo'];
                        $_SESSION['idAgent'] = $user['idAgent'];
                        if (isset($_POST['connect'])) {
                            setcookie('connect', $user['secret'], time() + 365 * 24 * 3600, '/', null, false, true);
                        }
                        header('location: AgentDashboard.php?success=1');
                        exit();
                    }
                }
                if ($error == 1) {
                    header('location: loginAsAnAgent.php?error=1');
                    exit();
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>LoginAsAnAgent</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Square+Peg&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=<?php echo time(); ?>">
</head>

<body>
    <nav>
        <a href="../commun/index.php">
            <h2 class="logo">L'Y<span>DEC</span></h2>
        </a>
    </nav>

    <div class="title">
        <h2>Log in to L'Y<span>DEC</span></h2>
    </div>

    <div class="container">
        <form method="post" action="loginAsAnAgent.php">
            <?php
            if (isset($_GET['error'])) { ?>
                <div>
                    <p>Email ou mot de passe incorrect!</p>
                </div>
            <?php
            }
            ?>
            <div class="txt-field">
                <input type="psuedo" name="pseudo" class="txt-css" required>
                <label>Pseudo</label>
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


        </form>
    </div>

</body>

</html>