<?php
    require_once(str_replace("\\views","",__DIR__)."/helpers/helper.php");
    require_once(str_replace("\\views","",__DIR__) ."/helpers/LireRecursDir.php");
    explorerDir(str_replace("\\views","",__DIR__)."/txtFiles");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body >
    <h1 style="text-align:center;">Content</h1>
    <div style="margin:0 10%;">
        <?php
            if(isset($_GET['url']))
                echo file_get_contents( "../".$_GET['url'] );
        ?>
    </div>
    
</body>
</html>
