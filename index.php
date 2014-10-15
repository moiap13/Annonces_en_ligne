<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     * 
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : Vendredi, 4 MARS 2014                 *
 * Modification         :                                       *
 ****************************************************************/

/*echo '<pre>';
var_dump($_SESSION);
echo '</pre>';*/

include 'pages/functions.php';

$s_login = "Login";
$s_url = "login.php";
$pseudo = '';

$bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');

if(isset($_SESSION['conn']) && $_SESSION['conn'])
{
    $s_login = "unlog";
    $s_url = "disconnect.php";
    $pseudo = 'Bienvenue ' . $_SESSION['pseudo'];

    $lien_menu_annonces =  '<p><a href="pages/annonces/menu_annonces.php">Menu annonces</a></p>';
    $lien_inserer_annonces = '<p><a href="pages/annonces/ajouter_annonces.php">Insérer annonces</a></p>';
    $lien_favoris = '<p><a href="pages/annonces/favoris.php">Favoris</a></p>';
}
else
{
    $lien_menu_annonces = '<p class="disabled">Menu annonces</p>';
    $lien_inserer_annonces = '<p class="disabled">Insérer annonces</p>';
    $lien_favoris = '<p class="disabled">Favoris</p>'; 
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
        <link href="css/style.css" rel="stylesheet" type="text/css" />
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
                <div class="div_banniere"><p id="titre_site"><a href="#">AnnoLigne<br/>Site d'annonce en ligne</a></p></div>
                <div class="div_banniere">
                    <a href="pages/connection/<?php echo $s_url; ?>"><?php echo $s_login; ?></a>
                </div>
                <div class="div_banniere">
                    <?php
                        echo $lien_menu_annonces;
                        echo $lien_inserer_annonces;
                        echo $lien_favoris;
                    ?>
                </div>
            </div>
            <div id="categorie">
                <?php echo display_index_categorie(select_categories($bdd), 0); ?>
            </div>
            <div id="contenent">
                <div id='recherche'>
                    <label>Recherche :</label>
                    <input type="text" name="tbx_search" placeholder="Recherche..." id="tbx_search"/>
                    <input type="image" src="img/image_site/image_search.png" name="btn_search"  id="btn_search"/>   
                </div>
                <p>Dernières annonces :</p>
                <div id="derniere_annonces">
                    <?php echo display_picture_last_insert_ads(select_last_insert_ads($bdd)); ?>
                </div>
                <div id="titre_derniere_annonces">
                    <?php echo display_last_insert_ads(select_last_insert_ads($bdd)); ?>
                </div>
                <div id='explications'>
                    <p>Bonjour et bienvenue</p>
                    <p>Ce site a été crée par <a href='mailto:antonio.pisanello.cfpt.ei@gmail.com'>Antonio Pisanello</a>. 
                       Le but de ce site est de pouvoir publier des annonces et trouver les annonces qui vous intérressent.
                    </p>
                    <p>
                        Le principe est simple pour poster une annnce il faut être connécté avec un compte, 
                        pour lire une annonce un compte n'est pas nécessaire, mais on peut enregistrer les annonces qui nous
                        plaisent et le nottants favori, ainsi on peut retourner voir cette annonce ultérieurement.
                    </p>
                    <p>
                        Une annonce dure 15j mais on peut remettre a 0 ce compteur a l'aide du boutton republier, même si
                        les 15 jours ne sont pas passés
                    </p>
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