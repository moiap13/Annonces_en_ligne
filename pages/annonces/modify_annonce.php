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
$input_delete = '<input type="submit" name="btn_delete_ads" value="Supprimer Annonce"/>';
$input_modifier = '<input type="submit" name="btn_modifier" value="Modifier Annonce"/>';

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
    header('Location: ../../index.php');
}

if(isset($_REQUEST['photo_supprimer']))
{
    supprimer_photo($_REQUEST['photo_supprimer'], $_REQUEST['id_annonce']);
}

if(isset($_FILES['photos']['error'][0]) && $_FILES['photos']['error'][0] != 4)
{
    $nb = count($_FILES['photos']['name']);

    for($z=0;$z<$nb ;$z++)
    {
        move_uploaded_file($_FILES['photos']['tmp_name'][$z], '../../img/annonces/'. $_REQUEST['id_annonce'] . '/' . ($z + get_max_nb_for_photo($_REQUEST['id_annonce'])) . get_image_format_file($_FILES['photos']['type'][$z]));
    }
}

if(isset($_REQUEST["btn_modifier"]))
{
    update_ads($_REQUEST['id_annonce'], $_REQUEST["hidden_titre"], $_REQUEST["hidden_text"], $_REQUEST["hidden_date"], $bdd);
    header('Location: menu_annonces.php');
}

if(isset($_REQUEST['id_annonce']))
{
    $annonce = select_annonces_from_id($_REQUEST['id_annonce'], $bdd);
    
    if(!empty($annonce))
    {
        $date = $annonce[0][3];
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
    header('Location: ../../index.php');
}

if($annonce[0][4] != $_SESSION['ID'])
{
    header('Location: menu_annonces.php');
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
                            <input type="text" name="modify_titre" value="<?php echo $titre; ?>" id="modify_titre" onchange="copy_input_value(0);" />
                        </div>
                        <div id="photos">
                            <div id="photo_principale">
                                <?php echo $photos[0]; ?>
                            </div>
                            <div id="photos_miniatures">
                                <?php
                                    if($photos[count($photos)-1] == 'multi')
                                    {
                                        echo display_photo_miniatures_modify($photos, $_REQUEST['id_annonce']);
                                    }
                                ?>
                            </div>
                        </div>
                        <div id="enveloppe_text">
                            <div id="text">
                                <textarea rows="15" cols="40" name="modify_text" id="modify_text" onchange="copy_input_value(1);">
                                    <?php echo $text; ?>
                                </textarea>
                            </div>
                        </div>
                        <div id="va_menu">
                            <fieldset>
                                <legend>Menu</legend>
                                <div>
                                    <form action="confirm_delete.php?id_ads=<?php echo $_REQUEST['id_annonce']; ?>" method="post">
                                        <?php echo $input_delete; ?>
                                    </form>
                                </div>
                                <div>
                                    <form action="modify_annonce.php?id_annonce=<?php echo $_REQUEST['id_annonce']; ?>" method="post">
                                        <?php echo $input_modifier; ?>
                                        <input type="hidden" name="hidden_titre" value="" id="hidden_titre"/>
                                        <input type="hidden" name="hidden_text" value="" id="hidden_text"/>
                                        <input type="hidden" name="hidden_date" value="" id="hidden_date"/>
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
                                <input type='date' name='modify_date' value='<?php echo  $date; ?>' id="modify_date" onchange="copy_input_value(2);"/>
                            </div>
                        </div>
                    </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
        <script type="text/javascript">
            //Insere ton Javascript ;P
            
            var tbx_titre = document.getElementById("modify_titre");
            var hidden_titre = document.getElementById("hidden_titre");
            var txta_text = document.getElementById("modify_text");
            var hidden_text = document.getElementById("hidden_text");
            var tbx_date = document.getElementById("modify_date");
            var hidden_date = document.getElementById("hidden_date");
            
            function copy_input_value(mode)
            {
                switch(mode)
                {
                    case 0:
                    hidden_titre.value = tbx_titre.value;
                        break;
                    case 1:
                    hidden_text.value = txta_text.value;  
                        break;
                    case 2:
                    hidden_date.value = tbx_date.value;  
                        break;
                }
            }
            
            document.onload = copy_input_value(0);
            document.onload = copy_input_value(1);
            document.onload = copy_input_value(2);
        </script>
    </body>
</html>