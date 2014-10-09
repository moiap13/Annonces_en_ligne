<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     * 
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : 25.09.14                              *
 * Modification         :                                       *
 ****************************************************************/

include './functions.php';

$s_login = "Login";
$s_url = "login.php";
$pseudo = '';
$today = create_date_today();

$bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');

if(isset($_SESSION["conn"]) && $_SESSION["conn"])
{
    $s_login = "unlog";
    $s_url = "disconnect.php";
    $pseudo = 'Bienvenue ' . $_SESSION['pseudo'];
}

if(isset($_REQUEST['index_categorie']))
{
    
}
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>site annonces ligne</title>
        <meta name="keywords" lang="fr" content="motcle1,mocle2" />
        <meta name="description" content="Description de ma page web." />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <link href="../css/style_annonces.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
            // insère ton gros code ici Antonio ;P
        ?>
        <div id="principal">
            <div id="banniere">
                <div class="div_banniere"></div>
                <div class="div_banniere">
                    <p id="display_user"><?php echo $pseudo; ?></p>
                </div>
                <div class="div_banniere"><p id="titre_site"><a href="../index.php">AnnoLigne<br/>Site d'annonce en ligne</a></p></div>
                <div class="div_banniere">
                    <a href="../connection/<?php echo $s_url; ?>"><?php echo $s_login; ?></a>
                </div>
                <div class="div_banniere">
                    <p><a href="./menu_annonces.php">Menu annonces</a></p>
                    <p><a href="./ajouter_annonces.php">Insérer annonces</a></p>
                    <p><a href="./favoris.php">Favoris</a></p>
                </div>
            </div>
            <div id="contenent">
                
            </div>
            <div id="pied_page">
                
            </div>
        </div>
        <script type="text/javascript">
            //Insere ton Javascript ;P
        </script>
    </body>
</html>