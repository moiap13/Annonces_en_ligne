<?php

function var_dump_pre($var)
{
    echo '<pre>';
        echo var_dump($var);
    echo '</pre>';
}

function split_separator($str, $separator)
{
    $array = array();
    $str_2 = "";
    
    $i_index = 0;
    
    if($str != "" && strlen($str) > 0)
    {
        for($i=0;$i< strlen($str) ;$i++)
        {
            if($str[$i] != $separator)
            {
                $str_2 .= $str[$i];
            }
            else
            {
                $array[$i_index] = $str_2;
                $str_2 = "";
                $i_index++;
            }
        }
    }
    
    return $array;
}

function create_date_today()
{
    $date_test = localtime(time());

    $month = $date_test[4]+1;
    $year = $date_test[5] + 1900;

    $today = mktime(0,0,0,$month,$date_test[3],$year,-1);
    return date('Y-m-d', $today);
}

function get_days($date_user)
{
    /*
    $date = array();
    $date[0] = "";
    $date[1] = "";
    $date[2] = "";
    */
    
    $date = split_separator($date_user,'-');
    
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];

    $date = mktime(0,0,0,$month,$day,$year,-1);
    $date = date('Y-m-d', $date);

    $date = new DateTime($date);
    $today = new DateTime(create_date_today());

    $date = $today->diff($date,1);
    return $date->format('%a jours');
}

function get_days_remaning($date_user)
{
    $a_day_month = array(31,28,31,30,31,30,31,31,30,31,30,31);
    $return = "";
    
    $date = split_separator($date_user . '-','-');
    
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    
    $year += 0;
    $month += 0;
    $day += 0;
    
    if(($year - 2012)%4==0)
    {
        $a_day_month[1] = 29;
    }
    
    $day += 15;
    
    if($day > $a_day_month[$month-1])
    {
        $day -= $a_day_month[$month-1];
        $month++;
    }
    
    $date = mktime(0,0,0,$month,$day,$year,-1);
    $date = date('Y-m-d', $date);

    $date = new DateTime($date);
    
    $today = create_date_today();
    $today = new DateTime($today);
    
    $date = $today->diff($date);
    
    if($date->format('%R%a') >= 0)
    {
        if($date->format('%R%a') == 0)
        {
            $return = 'Dernier jour de l\'annonce';
        }
        else if($date->format('%R%a') == 1)
        {
            $return = '1 jour restant';
        }
        else
        {
            $return = $date->format('%a jours restants');
        }
    }
    else 
    {
        $return = 'Annonce Expirée';
    }
    
    return $return;
}
function get_image_format_file($type)
{
    $format = "";
    
    switch ($type)
    {
        case 'image/png':
            $format = '.png';
            break;
        case 'image/jpeg':
            $format = '.jpg';
            break;
        case 'image/gif':
            $format = '.gif';
            break;
        case 'image/bmp':
            $format = '.bmp';
            break;
        case 'image/vnd.microsoft.icon':
            $format = '.ico';
            break;
        case 'image/tiff':
            $format = '.tif';
            break;
        case 'image/svg+xml':
            $format = '.svg';
            break;
    }
     
    return $format;
}

function put_dirfile_array($path)
{
    $array = "";
    $i =0;
    
    if ($dossier = opendir($path)) 
    {
        while (false !== ($file = readdir($dossier))) 
        {
            if ($file != "." && $file != ".." && $file != ".DS_Store") 
            {
                $array[$i] = $file;
                $i++;
            }
        }
        
        closedir($dossier);
    }
    
    return $array;
}

function dir_exist($dir)
{
    $result = false;
    
    if(file_exists($dir) && is_dir($dir))
        $result = true;
    
    return $result;
}

/*
* Debug function
* 
* Affichage pour debuggage du contenu passé en parametre
* 
* @param mixed $sObj element à afficher optionnel
* @return null
*/
function debug($sObj = NULL) {
echo '<pre>';
 
if (is_null($sObj)) 
{
    echo '|Object is NULL|' . "\n";
} else if(is_array($sObj) || is_object($sObj)) 
{
    var_dump($sObj);
} else 
{
    echo '|' . $sObj . '|' . "\n";
}

echo '</pre>';
}

function display_last_insert_ads($array)
{
    $affichage = '';
    
    for($i=0;$i<4;$i++)
    {
        $affichage .= '<div class="titre_derniere_annonce">';
            $affichage .= $array[$i][1];
        $affichage .= '</div>';
    }
    
    return $affichage;
}

function display_picture_last_insert_ads($array)
{  
    $affichage = '';
    
    for($i=0;$i<4;$i++)
    {
        if(dir_exist('img/annonces/' . $array[$i][0]))
        {
            $str = put_dirfile_array('img/annonces/' . $array[$i][0] . '/');
            
            $file_type = split_separator($str[0] . '.', '.');

            $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="img/annonces/' . $array[$i][0] . '/0.' . $file_type[1] .'"/></a></div>';

        }
        else
        {
            $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="img/image_site/No_Image_Available.png" width="100px" height="100px" /></a></div>';
        }
    }
    
    return $affichage;
}

function display_table_favoris($array, $array_id_annonces)
{
    $affichage = '';
    
    if(!empty($array))
    {
        for($i=0;$i<count($array);$i++)
        {
            $affichage .=   '<div class="favoris_table">' . 
                                '<div class="photo_favoris">';
            if($array[$i][3] == 1)
            {
                $str = put_dirfile_array('../../img/annonces/' . $array_id_annonces[$i][0] . '/');
                $file_type = split_separator($str[2] . '.', '.');

                $affichage .= '<img src="'. '../../img/annonces/' . $array_id_annonces[$i][0] . '/0.' . $file_type[1] .'" width="100px" height="100px" />';
                        
            }
            else
            {
                $affichage .= '<img src="../../img/image_site/No_Image_Available.png" width="100px" height="100px" />';
            }

                $affichage .= '</div>'.
                                    '<div class="titre_favoris">'. $array[$i][1] .'</div>'.
                                    '<div class="text_favoris">'. $array[$i][2] .'</div>' .
                                '</div>';
        }
    }
    else
    {
        $affichage = '<p class="warning_message">Vous n\'avez aucun favoris</p>';
    }
    
    return $affichage;
}



function display_table_user_annonces($array)
{
    /*echo '<pre>';
      var_dump_pre($array);
    echo '</pre>';*/
                        
    $affichage = '';
    
    if(!empty($array))
    {
        for($i=0;$i<count($array);$i++)
        {
            $affichage .=   '<div class="user_annonces_table">' . 
                                '<div class="photo_user_annonce">';
            if($array[$i][4] == 1)
            {
                $str = put_dirfile_array('../../img/annonces/' . $array[$i][0] . '/');
                $file_type = split_separator($str[2] . '.', '.');

                $affichage .= '<img src="'. '../../img/annonces/' . $array[$i][0] . '/0.' . $file_type[1] .'" width="100px" height="100px" />';
            }
            else
            {
                $affichage .= '<img src="../../img/image_site/No_Image_Available.png" width="100px" height="100px" />';
            }

             $affichage .= '</div>'.
                        '<div class="titre_user_annonce">'. $array[$i][1] .'</div>'.
                        '<div class="date_user_annonces">'. $array[$i][2] .'</div>' .
                        '<div class="date_user_annonces">'. get_days_remaning($array[$i][2] . '-') .'</div>' .
                    '</div>';
        }
    }
    else
    {
        $affichage = '<p class="warning_message">Vous n\'avez aucune annonces postée</p>';
    }
    
    return $affichage;
}

function display_combobox_categories($array)
{
    $affichage = '';
         
    $affichage = '<select name="categorie" id="cb_categorie" onchange="test(this.value)">';

    for ($i=0;$i < count($array);$i++)
    {
        $affichage .= '<option value="' . $array[$i][0] . '">'. $array[$i][1] .'</option>';
    }
     
    $affichage .= '<option value="new">Autre</option>';
    $affichage .= '</select>';
    
    return $affichage;
}
function display_index_categorie($array, $mode)
{
    $affichage = "";
    
    if($mode == 0)
    {
        for($i=0;$i<count($array);$i++)
        {
            $affichage .= '<div class="display_categorie">';
            $affichage .= '<p><a href="pages/recherche.php?index_categorie=' . $array[$i][1] . '">' . $array[$i][1] . '</a></p>';
            $affichage .= '</div>';
        }
    }
    else if($mode == 1)
    {
        for($i=0;$i<count($array);$i++)
        {
            $affichage .= '<div class="display_categorie">';
            $affichage .= '<p><a href="../recherche.php?index_categorie=' . $array[$i][1] . '">' . $array[$i][1] . '</a></p>';
            $affichage .= '</div>';
        }
    }
    
    return $affichage;
}

/************************************************************************************************************************/

/*
 * @param type $db_name : the name of the database where you want to connect
 * @param type $host : the adress from the host
 * @param type $user : the user who want to connect to the database
 * @param type $pwd : the password
 * @return type : return an connection PDO
 */
function connexion($db_name, $host, $user, $pwd)
{
    try {
        $bdd = new PDO('mysql:dbname=' . $db_name . ';host=' . $host, $user, $pwd);
        $bdd ->exec("SET CHARACTER SET utf8");
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        $bdd = $e->getMessage();
    }
    
    return $bdd;
}

function count_nb_user($bdd)
{
    $request = $bdd->query("select count(pseudo) from user");
    $request = $request->fetchAll();
    return $request[0][0];
}

function recuperer_id()
{
    $request = $bdd->query("select id_user from user");
    $request = $request->fetchAll();
    return $request[0][0];
}

function login_connection($users, $password, $bdd)
{
    $return = false;
    
    $nb_entite = count_nb_user($bdd);
    
    $request_pseudo = $bdd->query("select pseudo from user");
    $request_pseudo = $request_pseudo->fetchAll();
    
    $request_mail = $bdd->query("select mail from user");
    $request_mail = $request_mail->fetchAll();
    
    $request_pwd = $bdd->query("select mdp from user");
    $request_pwd = $request_pwd->fetchAll();
    
    $request_id = $bdd->query("select id_user from user");
    $request_id = $request_id->fetchAll();
    
    for($i=0;$i<$nb_entite;$i++)
    {
        $data_user = $request_pseudo[$i][0];
        
        $data_mail = $request_mail[$i][0];

        $data_pwd = $request_pwd[$i][0];

        if(($users == $data_user || $users == $data_mail ) && $password == $data_pwd)
        {
            $return = true;
            $_SESSION['ID'] = $request_id[$i][0];
        }
    } 
    
    return $return;
}

function ajout_personne($user, $password, $mail, $bdd)
{
    $ajout = $bdd->prepare('insert into user(pseudo,mdp,mail) values("' . $user . '","' . $password . '","' . $mail . '")');
    $ajout->execute();
}

function select_last_insert_ads($bdd)
{
    $request = $bdd->query("select id_annonce,titre from annonces order by date_debut desc");
    $request = $request->fetchAll();
    return $request;
}

function select_pseudo_titre_favoris($id, $bdd)
{
    $request_sql = 'SELECT pseudo,titre,text, photos '
                    . 'FROM favoris as f '
                    . 'JOIN user as u ON u.id_user = f.id_user '
                    . 'JOIN annonces as a ON a.id_annonce = f.id_annonce '
                    . 'where u.id_user = ' . $id;
    
    $request = $bdd->query($request_sql);
    $request = $request->fetchAll();
    return $request;
}
function select_id_annonce($id, $bdd)
{
    $request_sql = 'SELECT id_annonce FROM favoris where id_user = ' . $id;
    
    $request = $bdd->query($request_sql);
    $request = $request->fetchAll();
    return $request;
}

function select_user_annonces($id, $bdd)
{
    $request_sql = 'select id_annonce, titre, date_debut, active, photos FROM annonces where id_user='.$id;
    
    $request = $bdd->query($request_sql);
    $request = $request->fetchAll();
    return $request;
}

function select_categories($bdd)
{
    $request = $bdd->query('select * from categorie group by(nom_categorie)');
    $request = $request->fetchAll();
    
    return $request;
}

function check_categorie($name, $bdd)
{
    $array = select_categories($bdd);
    $return = true;
    
    for($i=0;$i<count($array);$i++)
    {
        if($array[$i][1] == $name)
        {
            $return = false;
        }
    }
    
    return $return;
}
function insert_categorie($nom_categorie, $bdd)
{
    $request = $bdd->prepare('insert into categorie(nom_categorie) values("'. $nom_categorie .'")');
    $request->execute();
    
     return $bdd->lastInsertId();
}

function ajout_annonce($titre, $text, $date,$id_user,$id_categorie,$active, $photos, $bdd)
{
    $sql = 'insert into annonces(titre, text, date_debut, id_user, id_categorie, active, photos) values("'.$titre.'","'.$text.'","'. $date .'",'. $id_user .','. $id_categorie .','. $active .','. $photos. ' )';
    
    $request = $bdd->prepare($sql);
    $request->execute();
    
    return $bdd->lastInsertId();
}

function select_annonces_from_categorie($name_categorie, $bdd)
{
    
}

function select_annonces_from_id($id, $bdd)
{
    $request = $bdd->query('select titre, text, photos, date_debut, id_user from annonces where id_annonce = ' . $id);
    return $request->fetchAll();
    
     
}

function select_user_from_id($id, $bdd)
{
   $request = $bdd->query('select pseudo, mail from user where id_user = ' . $id);
   return $request->fetchAll(); 
}