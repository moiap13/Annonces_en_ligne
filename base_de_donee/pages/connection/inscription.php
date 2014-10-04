<?php
session_start();

include '../functions.php';

if (isset($_REQUEST["tbxuser"], $_REQUEST["tbxpwd"]) == true) 
{
    $user = $_REQUEST["tbxuser"];
    $_SESSION["pseudo"] = $user;
    
    $mail = $_REQUEST["tbxemail"];
    $_SESSION["mail"] = $mail;
    
    $password = $_REQUEST["tbxpwd"];
    $_SESSION['pwd'] = $password;
    
    $bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');
    
    ajout_personne($user, $password, $mail, $bdd);
    
    header("Location: felicitation.php");
}

//$type = (isset($_REQUEST["btnvpwd"]) == true ? "text" : "password");
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Inscris toi</title>
        <meta name="keywords" lang="fr" content="motcle1,mocle2" />
        <meta name="description" content="Description de ma page web." />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <link href="../../css/style_login.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="inscription">
            <form action="inscription.php" method="post">
                <table>
                    <tr><th colspan="4">Inscription</th></tr>
                    <tr>
                        <td>User ID</td>
                        <td>:</td>
                        <td colspan="2"><input type="text" name="tbxuser" value="" required/></td>
                    </tr>
                    <tr>
                        <td>E-Mail</td>
                        <td>:</td>
                        <td colspan="2"><input type="email" name="tbxemail" required/></td></tr>
                    <tr>
                        <td>PassWord</td>
                        <td>:</td>
                        <td colspan="2"><input type="password" name="tbxpwd" value="" id="tbx_pwd" required/></td>
                    </tr>
                    
                    <tr>
                        <td>ShowPwd</td><td>:</td><td><input type="checkbox" name="ckb_show_pwd" id="ckb" onclick="showPwd();"/></td><td><input type="submit" name="btninscr" value="S'inscrire" /></td>
                    </tr>
                    <tr><td colspan="4"><a href="login.php">Retourner au login</a></td></tr>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            function showPwd()
            {
                var tbx_pwd = document.getElementById('tbx_pwd');
                var ckb_show_pwd = document.getElementById('ckb');
                
                if(ckb_show_pwd.checked)
                {
                    tbx_pwd.type = "text";
                }
                else
                {
                    tbx_pwd.type = "password";
                }
                
                tbx_pwd.focus();
            }
        </script>
    </body>
</html>