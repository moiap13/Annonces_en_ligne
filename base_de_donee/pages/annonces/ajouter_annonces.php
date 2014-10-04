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
$today = create_date_today();
//$bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');

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
        <link href="../../css/style_annonces.css" rel="stylesheet" type="text/css" />
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
                <form action="#" method="post" enctype="multipart/form-data">
                    <div id="titre">Insérer une nouvelle annonce</div>
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
                            <textarea rows="18" cols="70" required></textarea>
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
                            <input type="file" name="photos"  class="grande_taille" multiple/>
                        </div>
                    </div>
                    <div class="ligne_petite">
                        <input type="submit" name="btn_poster" value="Publier l'annonce" id="btn_envoyer" required/>
                    </div>
                </form>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
        <script type="text/javascript">
            //Insere ton Javascript ;P
        </script>
    </body>
</html>