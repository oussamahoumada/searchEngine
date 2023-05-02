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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <style>
        .content{
            border-style: solid;
            margin:20px 20%;
            border-color: lightblue;
            border-radius: 1%;
        }
        .row{
            padding:5% 25%;
        }

        u{
            margin-left: 1%;
        }
        #input{
            width: 250px;
        }
        .SearchImage{
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 30%;
        }
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 30%;
        }
    </style>
</head>
<body >
    <div class="content">
        <img src="../helpers/images.jpg" class="SearchImage">
        <form class="row">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Search</span>
                <input type="text" class="form-control" name="search" placeholder="Write something" aria-label="Username" aria-describedby="basic-addon1" value="<?php if(isset($_GET['search'])) echo $_GET['search'];?>">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>

        </form>
        <?php

            if(count($_GET)<=0){
                session_unset();
            }
            
            if(isset($_GET['search'])){
                session_unset();
                $search = "";
                $_SESSION["search"] = $_GET['search'];
                $search = $_SESSION["search"];
            }
            else{
                if(isset($_SESSION["search"])){
                    $search = $_SESSION["search"];
                }
                else{
                    $search = "";
                }
            }


            if($search != ""){

                //$search = $_GET['search'];
                $tab = explode(" ", $search);

                //$result = _getAllFrequency($search);
                $result = _getWord($search);

                $c = count($result);

                if(isset($_GET['p']) && $_GET['p']>0 && $_GET['p'] <= pagination($c)){
                    getData($_GET['p'],$result,$search,$c);
                }
                else{
                    getData(1,$result,$search,$c);
                }

                //_afficher($result);

                //Pagination
                echo ('<br>');
                echo '<div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                ';
                for($i=1;$i<=pagination($c);$i++){
                    echo '<li class="page-item"><a class="page-link" href="?p='.$i.'">'.$i.'</a></li>';
                }
                echo "      </ul>
                        </nav>
                    </div>";
            }
        ?>
    </div>
    
</body>
</html>
