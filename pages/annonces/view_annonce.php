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
$input_favoris = '<input type="submit" name="btn_favoris" value="ajouter aux favoris" disabled/>';

$bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');

if(isset($_SESSION['conn']) && $_SESSION['conn'])
{
    $s_login = "unlog";
    $s_url = "disconnect.php";
    $pseudo = 'Bienvenue ' . $_SESSION['pseudo'];

    $lien_menu_annonces =  '<p><a href="./menu_annonces.php">Menu annonces</a></p>';
    
    $input_favoris = '<input type="submit" name="btn_favoris" value="ajouter aux favoris" />';
    
    if(check_favoris($_SESSION["ID"], $_REQUEST['id_annonce'], $bdd) == false)
    {
        $input_favoris = '<input type="submit" name="btn_enlever_favoris" value="enlever des favoris" />';
    }
}
else
{
    $lien_menu_annonces = '<p class="disabled">Menu annonces</p>';
}

if(isset($_REQUEST['id_annonce']))
{
    $annonce = select_annonces_from_id($_REQUEST['id_annonce'], $bdd);
    
    /*echo '<pre>';
    var_dump($annonce);
    echo '</pre>';*/
    if(!empty($annonce))
    {
        $date = $annonce[0][3];

        if(get_days_remaning($date)[1] == false)
        {
            $titre = '<p class="warning_message">Cette annonce n\'est plus disponible...</p>';
            $text = "";
            $photos[0] = "";
        }
        else
        {
            $titre = $annonce[0][0];
            $text = $annonce[0][1];
            $photo = $annonce[0][2];

            if($photo == 1)
            {
                $photos = display_photo_view_annonce($_REQUEST['id_annonce']);
            }
            else
            {
                $photos[0] = '<img src="../../img/image_site/No_Image_Available.png" alt="no_image" />';
            }
        }

        $user = select_user_from_id($annonce[0][4], $bdd) ;
        $pseudo_annonceur = $user[0][0];
        $mail = $user[0][1];
    }
    else
    {
        $titre = '<p class="warning_message">Cette annonce est indisponible...</p>';
        $text = "";
        $photos[0] = "";
        $pseudo_annonceur = 'Indisponible';
        $pseudo_annonceur = "Indisponible";
        $mail = "";
        $date = "Indisponible";
    }
}


if(isset($_REQUEST["btn_favoris"]))
{   
    if(check_favoris($_SESSION["ID"], $_REQUEST['id_annonce'], $bdd))
    {
        ajout_favoris($_SESSION["ID"], $_REQUEST['id_annonce'], $bdd);
        $input_favoris = '<input type="submit" name="btn_enlever_favoris" value="enlever des favoris" />';
    }
}

if(isset($_REQUEST["btn_enlever_favoris"]))
{   
    enlever_favoris($_SESSION["ID"], $_REQUEST['id_annonce'], $bdd);
    $input_favoris = '<input type="submit" name="btn_favoris" value="ajouter aux favoris" />';
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
                            <?php echo $photos[0]; ?>
                        </div>
                        <div id="photos_miniatures">
                            <?php
                                if($photos[count($photos)-1] == 'multi')
                                {
                                    echo display_photo_miniatures($photos);
                                }
                            ?>
                        </div>
                    </div>
                    <div id="enveloppe_text">
                        <div id="text">
                            <?php echo $text; ?>
                        </div>
                    </div>
                    <div id="va_menu">
                        <fieldset>
                            <legend>Menu</legend>
                            <div>
                                <form action="#" method="post">
                                    <?php echo $input_favoris; ?>
                                </form>
                            </div>
                        </fieldset>
                    </div>
                    <div id="infos">
                        <div class="info">
                            Pseudo de l'annonceur : <span class="red">
                            <?php echo $pseudo_annonceur; ?>
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