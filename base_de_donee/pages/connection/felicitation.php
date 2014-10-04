<?php
session_start();
?> 
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Bravo <?php echo $_SESSION["UID"]; ?></title>
        <meta name="keywords" lang="fr" content="motcle1,mocle2" />
        <meta name="description" content="Description de ma page web." />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <link href="../../css/style_login.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <h1>Félicitation <span class="color_red"><?php echo $_SESSION["pseudo"]; ?></span> vous vous êtes bien inscrit cliquer <a href="login.php?tbxusers=<?php echo $_SESSION["pseudo"]; ?>&tbxpassword=<?php echo $_SESSION["pwd"]; ?>">ici</a> pour vous logger</h1>
    </body>
</html>