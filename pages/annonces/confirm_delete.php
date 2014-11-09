<?php
session_start();

include '../functions.php';



$bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');

if(!isset($_SESSION['conn']) && !$_SESSION['conn'])
{
    header('Location: ../../index.php');
}

if(isset($_REQUEST['id_ads']))
{
    $annonce = select_annonces_from_id($_REQUEST['id_ads'], $bdd);
    $titre = $annonce[0][0];
}
 
if($annonce[0][4] != $_SESSION['ID'])
{
    header('Location: menu_annonces.php');
}
    
if(isset($_REQUEST['btn_non']))
{
    header('Location: menu_annonces.php');
}

if(isset($_REQUEST['btn_oui']))
{
    delete_ads($_REQUEST['id_ads'], $bdd);
    header('Location: menu_annonces.php');
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div>
            <form action="confirm_delete.php?id_ads=<?php echo $_REQUEST['id_ads']; ?>" method="post">
                <h1>Voulez vous vraiment supprimer l'annonce suivante</h1><br/>
                titre : <?php echo $titre; ?> <br/>
                <input type="submit" value='oui' name='btn_oui'/>
                <input type="submit" value='non' name='btn_non'/>
            </form>
        </div>
    </body>
</html>
