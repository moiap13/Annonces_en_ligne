<?php
session_start();
session_destroy();
session_start();

include '../functions.php';

$login = false;

if(isset($_REQUEST["tbxusers"]) == true)
{
    $users = $_REQUEST["tbxusers"];
    $_SESSION["pseudo"] = $users;
}
else
{
    $users = "";
}
if(isset($_REQUEST["tbxpassword"]) == true)
{
    $password = $_REQUEST["tbxpassword"];
    $_SESSION["pwd"] = $password;
}
else
{
    $password = "";
}

if(isset($_REQUEST["tbxpassword"],$_REQUEST["tbxusers"]) == true)
{
    $_SESSION["conn"] = true;
    $bdd = connexion('annonces_en_ligne', 'localhost', 'root', 'root');

    $login = login_connection($users, $password, $bdd);
}
else
{
    $_SESSION["conn"] = false;
}
//******************************************************************************************************************************

if($login)
{
    header("Location: ../../index.php");
}

?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Login</title>
        <meta name="keywords" lang="fr" content="motcle1,mocle2" />
        <meta name="description" content="Description de ma page web." />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <link href="../../css/style_login.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="div_log">
            <form action="login.php" method="post">
                <table>
                    <tr><th colspan="3">Login</th></tr>
                    <tr><td>User ID / e-mail</td><td>:</td><td><input type="text" name="tbxusers" value="<?php echo "$users"; ?>" /></td></tr>
                    <tr><td>PassWord</td><td>:</td><td><input type="password" name="tbxpassword" value="" /></td></tr>
                    <tr><td colspan="3"><input type="submit" name="btnlogin" value="Login" /></td></tr>
                    <tr><td colspan="3"><a href="inscription.php">S'inscrire ici</a></td></tr>
                </table>
            </form>
        </div>
    </body>
</html>