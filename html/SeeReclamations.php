<?php /*
session_start();
require("connexion.php");
if (empty($_SESSION['connect'])) {
    header('location: login_as_an_influencer.php');
    exit;
}
$requete = $db->prepare('SELECT count(*) as count , (SELECT id FROM message_brands ) as last_id FROM message_brands');
$requete->execute();
while ($result = $requete->fetch()) {
    $count = $result['count'];
    $nbre_messages = $result['last_id'];
}*/
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> SEE MESSAGES </title>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="..\css\SeeReclamations.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php require("navBarAdmin.php"); ?>


<div class="home-content">
    <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="title">Communicate with a client</div>
            <div class="sales-details">

                <ul class="details">
                    <li class="topic">Clients</li>
                    <?php /*
                    for ($i = 1; $i <= $count; $i++) {
                        $requete = $db->prepare('SELECT b.name_brand, m.id_brand, b.id FROM brands as b INNER JOIN message_brands as m ON b.id = m.id_brand');
                        $requete->execute();
                        while ($result = $requete->fetch()) {
                            $name_brand  = $result['name_brand'];
                    ?>
                            <li><?php echo $name_brand; ?> </li>
                    <?php
                        }
                    }*/
                    ?>

                </ul>
                <ul class="details">
                    <li class="topic">Object of the message</li>
                    <?php /*
                    for ($i = 1; $i <= $nbre_messages; $i++) {
                        $requete = $db->prepare('SELECT subject FROM message_brands WHERE id = ?');
                        $requete->execute(array($i));
                        while ($result = $requete->fetch()) {
                            $subject   = $result['subject'];
                    ?>
                            <li><?php echo $subject; ?></li>
                    <?php }
                    }*/
                    ?>
                </ul>
                <ul class="details">
                    <li class="topic">Content</li>
                    <?php /*
                    for ($i = 1; $i <= $nbre_messages; $i++) {
                        $requete = $db->prepare('SELECT subject FROM message_brands WHERE id = ?');
                        $requete->execute(array($i));
                        while ($result = $requete->fetch()) {
                            $subject   = $result['subject'];
                    ?>
                            <li><?php echo $subject; ?></li>
                    <?php }
                    }*/
                    ?>
                </ul>
                <ul class="details">
                    <li class="topic">Action</li>
                    <?php /*
                    for ($i = 1; $i <= $nbre_messages; $i++) {
                        $requete = $db->prepare('SELECT id_brand FROM message_brands WHERE id = ?');
                        $requete->execute(array($i));
                        while ($result = $requete->fetch()) {
                            $id_brand   = $result['id_brand'];

                            echo '<li><a href="msg.php?id_brand=' . $id_brand . '">Reply</a></li>';
                        }
                    }*/
                    ?>

                </ul>
            </div>

        </div>

    </div>
</div>
</section>



</body>

</html>