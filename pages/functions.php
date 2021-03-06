<?php

function var_dump_pre($var)
{
    echo '<pre>';
        echo var_dump($var);
    echo '</pre>';
}

function there_is_digit($str)
{
    $pathern = '#[^0-9]#';
    
    if(preg_match($pathern,$str))
    {
        return true;
    }
    else
    {
        return false;
    }
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

function split_spaces($str)
{
    $array = array();
    $str_2 = "";
    $i_index_str = 0;
    
    $i_index = 0;
    
    while(($i_index_str = strpos($str, ' ')) !== false)
    {
        for($i=0;$i<=$i_index_str;$i++)
        {
            if($i != $i_index_str && $str[$i] != '#')
            {
                $str_2 .= $str[$i];
            }
            
            $str[$i] = '#';
        }
        
        $array[$i_index] = $str_2;
        $i_index++;
        $str_2 = "";
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
    $return[0] = "";
    
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
            $return[0] = 'Dernier jour de l\'annonce';
        }
        else if($date->format('%R%a') == 1)
        {
            $return[0] = '1 jour restant';
        }
        else
        {
            $return[0] = $date->format('%a jours restants');
        }
        $return[1] = true;
    }
    else 
    {
        $return[0] = 'Annonce Expirée';
        $return[1] = false;
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

function copie_donnee_unique($array)
{
    //var_dump_pre($array);
    $array_result[0] = $array[0];
    
    for($i=0;$i<count($array);$i++)
    {
        $b_ajout = true;
        
        for($y=0;$y<count($array_result);$y++)
        {
            if($array[$i] == $array_result[$y])
            {
                $b_ajout = false;
            }
        }
        
        if($b_ajout)
        {
            $array_result[count($array_result)] = $array[$i];
        }
    }
    //var_dump_pre($array_result);
    return $array_result;
}

function supprimer_photo($nom_photo, $id_annonce)
{
    if(file_exists('../../img/annonces/' . $id_annonce . '/' . $nom_photo))
    {
        unlink('../../img/annonces/' . $id_annonce . '/' . $nom_photo);
    }
}

function get_max_nb_for_photo($id_annonce)
{
    $array = put_dirfile_array('../../img/annonces/' . $id_annonce . '/');
    $max_num = split_separator($array[0] . '.', '.')[0];
    
    for($i=0;$i<count($array);$i++)
    {
        $array[$i] = split_separator($array[$i] . '.', '.')[0];
        if($array[$i] > $max_num)
        {
            $max_num = $array[$i];
        }
    }
    
    return $max_num+1;
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

function search($array, $bdd)
{
    $id_annonces = array();
    $titre = array();
    $text = array();
    $photo = array();
    $date_debut = array();
    $array_text_gras = array();
    
    for($i=0;$i<count($array);$i++)
    {
        $request_annonces = $bdd->query('SELECT id_annonce FROM annonces WHERE titre like "%'.trim(strtolower($array[$i])).'%" OR text like "%'.trim(strtolower($array[$i])).'%"');
        $request_annonces = $request_annonces->fetchAll();
        
        for($y=0;$y<count($request_annonces);$y++)
        {
            $id_annonces[] = $request_annonces[$y][0];
        } 
    }
    
    if(isset($id_annonces) && !empty($id_annonces))
    {
        $annonces = copie_donnee_unique($id_annonces);
    }
    
    
    if(!empty($annonces) && $annonces != null)
    {
        $id_annonces = array();
        
        for($y=0;$y<count($annonces);$y++)
        {
            if($annonces[$y] != null)
            {
                $request_annonces = $bdd->query('SELECT id_annonce, titre, text, photos, date_debut FROM annonces WHERE id_annonce=' . $annonces[$y]);
                $request_annonces = $request_annonces->fetchAll();
                for($c=0;$c<count($request_annonces);$c++)
                {   
                    $id_annonces[] = $request_annonces[$c][0];
                    $titre[] = $request_annonces[$c][1];
                    $text[] = $request_annonces[$c][2];
                    $photo[] = $request_annonces[$c][3]; 
                    $date_debut[] = $request_annonces[$c][4]; 
                }
            }
            else
            {
                echo 'null';
            }
        }
    }
    
    for($i=0;$i<count($titre);$i++)
    {
        $array_text_gras[$i] = array();
        $array_text_gras[$i][0] = $id_annonces[$i];
        $array_text_gras[$i][1] = $titre[$i];
        $array_text_gras[$i][2] = $text[$i];
        $array_text_gras[$i][3] = $photo[$i];
        $array_text_gras[$i][4] = $date_debut[$i];
    }
    
    for($i=0;$i<count($array);$i++)
    {
        for($y=0;$y<count($array_text_gras);$y++)
        {
            for($z=0;$z<count($array_text_gras[$y]);$z++)
            {
                $array_text_gras[$y][$z] = mettre_text_en_gras(trim($array[$i]), $array_text_gras[$y][$z]);
            }
        }  
    }
    
    return $array_text_gras;
}

function mettre_text_en_gras($mot_rechercher,$plage)
{
    $array_tmp = array();
    
    $index = 0;
    $count_char = 0;
    $b_fin = false;

    $array_tmp[$index] = $plage;
    
    while($b_fin == false)
    {
        for($y=0;$y<strlen($array_tmp[$index]);$y++)
        {
            if(isset($mot_rechercher[0]) && $mot_rechercher[0] == $array_tmp[$index][$y])
            {
                $a = 0;
                $b = $y;

                for($v=0;$v<strlen($mot_rechercher);$v++)
                {
                    if
                    (
                        isset($mot_rechercher[$v + $a]) &&  
                        isset($array_tmp[$index][$v + $b]) && 
                        $mot_rechercher[$v + $a] == $array_tmp[$index][$v + $b]
                    )
                    {
                        $count_char++;
                       
                        if($count_char == strlen($mot_rechercher))
                        {
                            $b_fin = false;
                            $array_tmp[$index + 1] = "";

                            for($x=0;$x<$b;$x++)
                            {
                                $array_tmp[$index + 1] .= $array_tmp[$index][$x];
                            }
                            $array_tmp[$index + 1] .= '<span class="warning_message">' . strtoupper($mot_rechercher) . "</span>";

                            for($x=$b+strlen($mot_rechercher);$x<strlen($array_tmp[$index]);$x++)
                            {
                                $array_tmp[$index + 1] .= $array_tmp[$index][$x];
                            }

                            $index++;
                        }
                    }
                }
            }
            else
            {
                $count_char = 0;
                $b_fin = true;
            }
        }
    }
    
    return $array_tmp[$index];
}
/************************************************************************************************************************/

function display_last_insert_ads($array)
{
    $affichage = '';
    $nb_annonces = 0;
    
    if(!empty($array))
    {
        for($i=0;$i<4;$i++)
        {
            if(isset($array[$i]))
            {
                if(get_days_remaning($array[$i][2])[1])
                {
                    $affichage .= '<div class="titre_derniere_annonce">';
                    $affichage .= '<a href="pages/annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" >' . $array[$i][1] . '</a>';
                    $affichage .= '</div>';
                    $nb_annonces++;
                }
            }
        }

        if($nb_annonces == 0)
        {
            $affichage = '<p class="warning_message">Aucune annonce à afficher</p>';
        }
    }

    return $affichage;
}

function display_picture_last_insert_ads($array)
{  
    $affichage = '';
    $nb_annonces = 0;
    
    if(!empty($array))
    {
        for($i=0;$i<4;$i++)
        {//var_dump_pre($array);
            //echo $array[$i][2] . '<br/>';
            if(isset($array[$i]))
            {
                if(get_days_remaning($array[$i][2])[1])
                {
                    if(dir_exist('img/annonces/' . $array[$i][0])  && $array[$i][3] == 1)
                    {
                        $str = put_dirfile_array('img/annonces/' . $array[$i][0] . '/');

                        $file_type = split_separator($str[0] . '.', '.');

                        $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="img/annonces/' . $array[$i][0] . '/0.' . $file_type[1] .'"/></a></div>';

                    }
                    else
                    {
                        $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="img/image_site/No_Image_Available.png" width="100px" height="100px" /></a></div>';
                    }
                    $nb_annonces++;
                }
            }
        }

        if($nb_annonces == 0)
        {
            $affichage = '<p class="warning_message">Aucune annonce à afficher</p>';
        }
    }
    else
    {
       $affichage = '<p class="warning_message">Aucune annonce à afficher</p>'; 
    }
    
    
    return $affichage;
}

function display_photo_view_annonce($id_annonce)
{
    if(dir_exist('../../img/annonces/' . $id_annonce))
    {
        $a_images = put_dirfile_array('../../img/annonces/' . $id_annonce . '/');

        for($i=0;$i<count($a_images);$i++)
        {
            $photos[$i] = '<img src="../../img/annonces/' . $id_annonce . '/' . $a_images[$i] .'"/>';
        }
    }
    
    if(count($photos) > 1)
    {
        $photos[count($photos)] = 'multi';
    }
    else
    {
        $photos[count($photos)] = 'single';
    }
    
    return $photos;
}

function display_photo_miniatures($array)
{
    $affichage = '';
    
        for($i=1;$i<count($array)-1;$i++)
        {
            $affichage .= '<div class="img_miniature">';
                $affichage .= $array[$i];
            $affichage .= '</div>';
        }
    
    return $affichage;
}

function display_photo_miniatures_modify($array, $id_annonce)
{
    $affichage = '';
    if(dir_exist('../../img/annonces/' . $id_annonce))
    {
        $a_images = put_dirfile_array('../../img/annonces/' . $id_annonce . '/');
    }
    for($i=1;$i<count($array)-1;$i++)
    {
        $affichage .= '<div class="gp_miniature"><div class="modify_img_miniature">';
            $affichage .= $array[$i];
        $affichage .= '</div>';
        $affichage .= '<div class="supprimer_photo_miniature"><a href="modify_annonce.php?id_annonce='.$id_annonce.'&photo_supprimer='. $a_images[$i] . '">x</a></div></div>';
    }
    
    $affichage .=   '<div class="gp_miniature">' .
                        '<form action="modify_annonce.php?id_annonce='.$id_annonce.'" method="post" enctype="multipart/form-data">' .
                            '<input type="file" name="photos[]" multiple/><br/>' .
                            '<input type="submit" name="btn_ajout_photo" value"Ajouter" />' .
                        '</form>' .
                    '</div>';
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
                $file_type = split_separator($str[0] . '.', '.');

                $affichage .= '<a href="./view_annonce.php?id_annonce='. $array_id_annonces[$i][0] .'" ><img src="'. '../../img/annonces/' . $array_id_annonces[$i][0] . '/0.' . $file_type[1] .'" width="100px" height="100px" /></a>';
                        
            }
            else
            {
                $affichage .= '<a href="./view_annonce.php?id_annonce='. $array_id_annonces[$i][0] .'" ><img src="../../img/image_site/No_Image_Available.png" width="100px" height="100px" /></a>';
            }

                $affichage .=   '</div>'.
                                '<div class="menu_rapide">' .
                                    '<div><a href="?DELETE_FAVORIS='. $array_id_annonces[$i][0] .'">x</a></div>' .
                                '</div>' .
                                    '<div class="titre_favoris"><a href="./view_annonce.php?id_annonce='. $array_id_annonces[$i][0] .'" >'. $array[$i][1] .'</a></div>'.
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
                $file_type = split_separator($str[0] . '.', '.');

                $affichage .= '<a href="./view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="'. '../../img/annonces/' . $array[$i][0] . '/0.' . $file_type[1] .'" width="100px" height="100px" /></a>';
            }
            else
            {
                $affichage .= '<a href="./view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="../../img/image_site/No_Image_Available.png" width="100px" height="100px" /></a>';
            }

             $affichage .= '</div>'.
                     '<div class="menu_rapide">' .
                      '<div><a href="confirm_delete.php?id_ads='.$array[$i][0].'">x</a></div>' .
                        '<div><a href="modify_annonce.php?id_annonce='. $array[$i][0] .'">✍</a></div>' .
                      '</div>' .
                        '<div class="titre_user_annonce"><a href="./view_annonce.php?id_annonce='. $array[$i][0] .'" >'. $array[$i][1] .'</a></div>'.
                     
                        '<div class="date_user_annonces">'. $array[$i][2] .'</div>' .
                        '<div class="date_user_annonces">'. get_days_remaning($array[$i][2] . '-')[0] .'</div>' .
                        
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
    else if($mode == 2)
    {
        for($i=0;$i<count($array);$i++)
        {
            $affichage .= '<div class="display_categorie">';
            $affichage .= '<p><a href="recherche.php?index_categorie=' . $array[$i][1] . '">' . $array[$i][1] . '</a></p>';
            $affichage .= '</div>';
        }
    }
    
    return $affichage;
}

function display_annonces_search($array)
{
//    echo '<pre>';
//    var_dump($array);
//    echo '</pre>';
    
    $affichage = '<div id="annonce_trouvee">';
    $annonce = "";
   
    if(count($array) == 0)
    {
        
        $affichage = '<p class="warning_message">Aucune annonce à afficher</p>';
        
        $b_annonces = true;
    }
    else
    {   
        for($i=0;$i<count($array);$i++)
        {
            if(get_days_remaning($array[$i][4])[1])
            {
                $b_annonces = true;
                
                $annonce .= '<div id="annonces_recherche_photo">';
                
                if($array[$i][3] == 1)
                {
                    $str = put_dirfile_array('../img/annonces/' . $array[$i][0] . '/');
                    $file_type = split_separator($str[0] . '.', '.');

                    $annonce .= '<a href="./annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="'. '../img/annonces/' . $array[$i][0] . '/0.' . $file_type[1] .'" width="200" height="200"/></a>';
                }
                else
                {
                    $annonce .= '<a href="./annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" ><img src="../img/image_site/No_Image_Available.png" alt="" width="200" height="200"/></a>';
                }
                
                $annonce .= '</div>';
                $annonce .= '<div id="annonces_recherche_titre"><a href="./annonces/view_annonce.php?id_annonce='. $array[$i][0] .'" >' . $array[$i][1] . '</a></div>';
                $annonce .= '<div id="annonces_recherche_texte">' . $array[$i][2] . '</div>';
                $annonce .= '<div id="annonces_recherche_prix">Non Spécifié</div>';
            }
            else
            {
                $b_annonces = false;
            }
            
        }
        $annonce .= "</div>";
    }
    
    if(empty($annonce))
    {
        $affichage = '<p class="warning_message">Aucune annonce à afficher</p>';
    }
    else
    {
        $affichage .= $annonce;
    }
    
    return $affichage;
}
/************************************************************************************************************************/

function ajout_personne($user, $password, $mail, $bdd)
{
    $ajout = $bdd->prepare('insert into user(pseudo,mdp,mail) values("' . $user . '","' . $password . '","' . $mail . '")');
    $ajout->execute();
}

function ajout_favoris($id_user, $id_annonce, $bdd)
{
    $ajout = $bdd->prepare('insert into favoris(id_user,id_annonce) values("' . $id_user . '","' . $id_annonce . '")');
    $ajout->execute();
}

function select_favoris($bdd)
{
    $request = $bdd->query("select id_user, id_annonce from favoris ");
    $request = $request->fetchAll();
    return $request;
}

function select_favoris_from_id($id_user, $bdd)
{
    $request = $bdd->query("select id_user, id_annonce from favoris where id_user =  " . $id_user);
    $request = $request->fetchAll();
    return $request;
}

function enlever_favoris($id_user, $id_annonce, $bdd)
{
    $ajout = $bdd->prepare('DELETE FROM favoris WHERE id_user = ' . $id_user . ' && id_annonce = ' . $id_annonce);
    $ajout->execute();
}

function check_favoris($id_user, $id_annonce, $bdd)
{
    $favoris = select_favoris_from_id($id_user, $bdd);
    $result = true;
    
    for($i=0;$i<count($favoris);$i++)
    {
        if($favoris[$i][1] == $id_annonce)
        {
            $result = false;
        }
    }
    
    return $result;
}

function select_last_insert_ads($bdd)
{
    $request = $bdd->query("select id_annonce, titre, date_debut, photos from annonces order by date_debut desc");
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
    $titre = strtolower($titre);
    $text = strtolower($text);
    
    $sql = 'insert into annonces(titre, text, date_debut, id_user, id_categorie, active, photos) values("'.$titre.'","'.$text.'","'. $date .'",'. $id_user .','. $id_categorie .','. $active .','. $photos. ' )';
    
    $request = $bdd->prepare($sql);
    $request->execute();
    
    return $bdd->lastInsertId();
}

function select_annonces_from_categorie($nom_categorie, $bdd)
{
    $request = $bdd->query('select id_annonce, titre, text, photos, date_debut from annonces natural join categorie where nom_categorie = "' . $nom_categorie .'"');
    return $request->fetchAll(); 
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

function delete_ads($id_ads, $bdd)
{
    $ajout = $bdd->prepare('DELETE FROM annonces WHERE id_annonce = ' . $id_ads);
    $ajout->execute();
}

function update_ads($id_ads, $titre, $text, $date, $bdd)
{
    $ajout = $bdd->prepare('UPDATE annonces SET titre="'.$titre.'", text="'. $text .'", date_debut="'. $date.'" WHERE id_annonce=' . $id_ads);
    $ajout->execute();
}