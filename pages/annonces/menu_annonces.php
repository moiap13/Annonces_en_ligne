<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     * 
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : 25.09.14                              *
 * Modification         :                                       *
 ****************************************************************/



include '../functions.php';


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
 else 
{
    header("Location: not_connected.php");
}
//$test = select_categories($bdd);

if(isset($_REQUEST["btn_poster"]))
{
    if(isset($_REQUEST["tbx_titre_annonce"], $_REQUEST["text_annonce"],  
            $_REQUEST['date_debut'],$_REQUEST['categorie'] ))
    {
        $titre = $_REQUEST["tbx_titre_annonce"];
        $text = $_REQUEST["text_annonce"];
        $date = $_REQUEST["date_debut"];
        $id_categorie = $_REQUEST["categorie"];
        $lastinsertid = -1;
        
        if($id_categorie == "new" && isset($_REQUEST['tbx_autre']))
        {
            if(check_categorie($_REQUEST['tbx_autre'], $bdd))
            {
               $id_categorie = insert_categorie($_REQUEST['tbx_autre'], $bdd);
            }
            else 
            {
                $id_categorie = 1;
            }
        }
        
        if(isset($_FILES['photos']['error'][0]) && $_FILES['photos']['error'][0] != 4)
        {
            $photos = 1;
        }
        else 
        {
            $photos = 0;
        }
        
        $lastinsertid = ajout_annonce($titre, $text, $date, $_SESSION['ID'], $id_categorie, 1, $photos, $bdd);
        
        if($lastinsertid > -1 && $photos == 1)
        {
            $nb = count($_FILES['photos']['name']);
        
            mkdir('../../img/annonces/' . $lastinsertid);
            
            for($z=0;$z<$nb;$z++)
            {
                move_uploaded_file($_FILES['photos']['tmp_name'][$z], '../../img/annonces/'. $lastinsertid . '/' . $z . get_image_format_file($_FILES['photos']['type'][$z]));
            }
        }
    }
    else
    {
        echo 'Pas tous les champs ont été saisis';
    }
}

if(isset($_REQUEST["DELETE_FAVORIS"]))
{
    enlever_favoris($_SESSION["ID"], $_REQUEST["DELETE_FAVORIS"], $bdd);
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
        <link href="../../css/style_menu_annonces.css" rel="stylesheet" type="text/css" />
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
                </div>
            </div>
            <div id="contenent">
                <div id="favoris">
                    <div class="titre">Favoris</div>
                    <div class="contour">
                        <?php 
                            echo display_table_favoris(select_pseudo_titre_favoris($_SESSION['ID'], $bdd), select_id_annonce($_SESSION['ID'], $bdd));
                        ?>
                    </div>
                </div>
                <div id="inserer_annonce">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="titre">Inserer une annonce</div>
                        <div id="formulaire">
                            
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
                                    <textarea rows="15" cols="40" required name="text_annonce"></textarea>
                                </div>
                            </div>
                            <div class="ligne_petite" >
                                <div class="colonne_gauche">
                                    <p>Prix</p>
                                </div>
                                <div class="colonne_droite">
                                    <input type="text" name="tbx_prix" placeholder="Prix en CHF" class="grande_taille" required/>
                                </div>
                            </div>
                            <div class="ligne_petite" >
                                <div class="colonne_gauche">
                                    <p>Date début (aaaa-mm-jj)</p>
                                </div>
                                <div class="colonne_droite">
                                    <input type="date" name="date_debut" min="<?php echo $today; ?>" value="<?php echo $today; ?>" class="grande_taille" required/>
                                </div>
                            </div>
                            <div class="ligne_petite">
                                <div class="colonne_gauche">
                                    <p>Catégorie</p>
                                </div>
                                <div class="colonne_droite">
                                    <?php echo display_combobox_categories(select_categories($bdd)) ?>
                                    <input type="hidden" name="tbx_autre" id="tbx_autre" />
                                </div>
                            </div>
                            
                            <div class="ligne_petite">
                                <div class="colonne_gauche">
                                    <p>Ajouter des photos</p>
                                </div>
                                <div class="colonne_droite">
                                    <input type="file" name="photos[]"  class="grande_taille" multiple />
                                </div>
                            </div>
                            <div class="ligne_petite">
                                <input type="submit" name="btn_poster" value="Publier l'annonce" id="btn_envoyer" required/>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="user_annonces">
                    <div class="titre">Vos annonces</div>
                    <div class="contour">
                        <?php 
                            echo display_table_user_annonces(select_user_annonces($_SESSION['ID'], $bdd));
                        ?>
                    </div>
                </div>
            </div>
            <div id="pied_page">
            </div>
        </div>
        <script type="text/javascript">
            //Insere ton Javascript ;P
            
            
            function test()
            {
                var categorie = document.getElementById("cb_categorie");
                var tbx = document.getElementById("tbx_autre");

                if(categorie.value == "new")
                {
                    tbx.type = "text";
                    tbx.required = true;
                }
                else
                {
                    tbx.type = "hidden";
                    tbx.required = false;
                }
            }
            
            document.onload = test();
        </script>
    </body>
</html>