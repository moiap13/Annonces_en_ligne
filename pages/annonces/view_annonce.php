<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     * 
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : 25.09.14                              *
 * Modification         :                                       *
 ****************************************************************/

/*echo '<pre>';
var_dump($_SESSION);
echo '</pre>';*/

include '../functions.php';

$s_login = "Login";
$s_url = "login.php";
$pseudo = '';

$bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');

if(isset($_SESSION['conn']) && $_SESSION['conn'])
{
    $s_login = "unlog";
    $s_url = "disconnect.php";
    $pseudo = 'Bienvenue ' . $_SESSION['pseudo'];

    $lien_menu_annonces =  '<p><a href="./menu_annonces.php">Menu annonces</a></p>';
}
else
{
    $lien_menu_annonces = '<p class="disabled">Menu annonces</p>';
}

if(isset($_REQUEST['id_annonce']))
{
    $annonce = select_annonces_from_id($_REQUEST['id_annonce'], $bdd);
    
    $titre = $annonce[0][0];
    $text = $annonce[0][1];
    $photos = $annonce[0][2];
    $date = $annonce[0][3];
    
    $user = select_user_from_id($annonce[0][4], $bdd) ;
    $pseudo = $user[0][0];
    $mail = $user[0][1];
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
        <link href="../../css/style_view_annonces.css" rel="stylesheet" type="text/css" />
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
                <div class="div_banniere"><p id="titre_site"><a href="../../index.php">AnnoLigne<br/>Site d'annonce en ligne</a></p></div>
                <div class="div_banniere">
                    <a href="../connection/<?php echo $s_url; ?>"><?php echo $s_login; ?></a>
                </div>
                <div class="div_banniere">
                    <?php
                        echo $lien_menu_annonces;
                    ?>
                </div>
            </div>
            <div id="categorie">
                <?php echo display_index_categorie(select_categories($bdd), 1); ?>
            </div>
            <div id="contenent">
                <div id="view_annonce">
                    <div id="titre">
                        <?php echo $titre; ?>
                    </div>
                    <div id="photos">
                        <div id="photo_principale">
                            
                        </div>
                        <div id="photos_miniatures">
                            
                        </div>
                    </div>
                    <div id="enveloppe_text">
                        <div id="text">
                            <?php echo $text; ?>
                        </div>
                    </div>
                    <div id="infos">
                        <div class="info">
                            Pseudo de l'annonceur : <span class="red">
                            <?php echo $pseudo; ?>
                            </span>
                        </div>
                        <div class="info">
                            <?php echo '<a href="mailto:' . $mail . '">Contacter l\'anonceur par mail</a>'; ?>
                        </div>
                        <div class="info">
                            <?php echo 'annonce parrue le : <span class="red">' . $date . '</span>'; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
        <script type="text/javascript">
            //Insere ton Javascript ;P
        </script>
    </body>
</html>