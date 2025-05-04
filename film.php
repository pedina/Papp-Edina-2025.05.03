<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Voltaire&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="./logo/favicon.jpg">
    <title>Adatlap</title>
    <style>
      

      @media only screen and (max-width: 1920px) {
        #tartalom {
            font-size: 22px;
        }
        .voltaire-regular {
          font-size: 55px;
        }
        
        .kepek{
            width: 280px;
        }
      }

@media only screen and (max-width: 1200px) {
  #tartalom {
      font-size: 20px;
    }
    .voltaire-regular {
          font-size: 35px;
        }
    .kepek{
        width: 250px;
    }
}

@media only screen and (max-width: 1100px) {
    .kepek{
        width: 230px;
    }
}

@media only screen and (max-width: 768px) {
  #tartalom {
      font-size: 14px;
    }
    .kepek{
        width: 170px;
    }
}

  #kulsoTarolo{
    margin-left:40px;
    margin-right:40px;
  }

    #leiras{
      text-align:justify;
    }

    .row{
      margin-top:25px;
    }

    #tartalom{
      margin-bottom:50px;
    }
    </style>
</head>
<body>
    <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
          include './header_logout.php';
      }
      else{
          include './header.php';
      }
      
        include './mozi.class.php';
        include './adatbazis.class.php';

        echo '<div id="tartalom">';
        echo '<div id="main">';
        $mozi = new Mozi();
        $info = $mozi->choosen_film($_GET['id']);
        if(is_array($info)){
            foreach($info as $x){
                echo '<div id="kulsoTarolo"><h2 class="voltaire-regular">'.$x['cim'].' ('.$x['ev'].')</h2>
                      <div class="row">
                        <div class="col col-lg-3 col-md-4 col-sm-12">
                          <img src="./img/'.$x['url'].'" class="rounded border kepek" alt="'.$x['cim'].'" title="'.$x['cim'].'" width="230px">
                        </div>
                        <div id="" class="col col-lg-9 col-md-8 col-sm-12 px-3">
                          <p>Játékidő: '.$x['hossz'].' perc</p>
                          <p>Rendező: '.$x['rendezo'].'</p>
                          <p id="leiras">'.$x['leiras'].'</p>
                        </div>
                      </div>
                      </div>';
            }
        }
        echo '</div>';
        echo '</div>';
        include './footer.php'; 
    ?>
</body>
</html>