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

if($_SESSION["conn"])
{
    $s_login = "unlog";
    $s_url = "disconnect.php";
    $pseudo = 'Bienvenue ' . $_SESSION['pseudo'];
}
 else 
{
    header("Location: not_connected.php");
}

$today = create_date_today();

$test = select_user_annonces(2, $bdd);

//echo get_days($test[0][1] . '-');

get_days_remaning('2014-09-18');

if(isset($_REQUEST["btn_poster"]))
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
        <link href="../../css/style_annonces_2.css" rel="stylesheet" type="text/css" />
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
                    <p><a href="./menu_annonces.php">Menu annonces</a></p>
                    <p><a href="./ajouter_annonces.php">Insérer annonces</a></p>
                    <p><a href="./favoris.php">Favoris</a></p>
                </div>
            </div>
            <div id="contenent">
                <div id="favoris">
                    <div class="titre">Favoris</div>
                    <div class="contour">
                        <?php 
                            echo display_table_favoris(select_pseudo_titre_favoris($_SESSION['ID'], $bdd), '../../img/image_site/No_Image_Available.png');
                        ?>
                    </div>
                </div>
                <div id="inserer_annonce">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="titre">inserer une annonce</div>
                        <div class="ligne_petite">
                            <div class="colonne_gauche">
                                <p>Titre de l'annonce</p>
                            </div>
                            <div class="colonne_droite">
                                <input type="text" name="tbx_titre_annonce" placeholder="Titre de l'annonce" class="grande_taille" require/>
                            </div>
                        </div>
                        <div id="ligne_grande">
                            <div class="colonne_gauche">
                                <p>Texte de l'annonce</p>
                            </div>
                            <div class="colonne_droite">
                                <textarea rows="18" cols="40" required></textarea>
                            </div>
                        </div>
                        <div class="ligne_petite">
                            <div class="colonne_gauche">
                                <p>Date début (aaaa-mm-jj)</p>
                            </div>
                            <div class="colonne_droite">
                                <input type="date" name="date_debut" min="<?php echo $today; ?>" class="grande_taille" required/>
                            </div>
                        </div>
                        <div class="ligne_petite">
                            <div class="colonne_gauche">
                                <p>Ajouter des photos</p>
                            </div>
                            <div class="colonne_droite">
                                <input type="file" name="photos[]"  class="grande_taille" multiple/>
                            </div>
                        </div>
                        <div class="ligne_petite">
                            <input type="submit" name="btn_poster" value="Publier l'annonce" id="btn_envoyer" required/>
                        </div>
                    </form>
                </div>
                <div id="user_annonces">
                    <div class="titre">Vos annonces</div>
                    <div class="contour">
                        <?php  
                            echo display_table_user_annonces(select_user_annonces($_SESSION['ID'], $bdd), '../../img/image_site/No_Image_Available.png', $test)
                        ?>
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