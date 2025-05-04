<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Voltaire&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" type="image/x-icon" href="./logo/favicon.jpg">
    <title>Főoldal</title>
    <style>
        #main{
            max-width:95%;
            overflow:hidden;
        }

        .card{
            height:170px;
            width: 210px;
        }

        p{
            font-size:20px;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        include './header_admin.php';
        include './mozi.class.php';
        include './adatbazis.class.php';

        if (!isset($_SESSION['admin_id'])) {
            header('location: login.php');
            exit();
        }  
        ?>

        <div id="tartalom">
            <div id="main" class="mt-5 mx-2">
                <div class="row">

        <?php
        $mozi = new Mozi();
        $user_db = $mozi->user_db();
            if (is_array($user_db)) {
                foreach($user_db as $x){
                    echo '<div class="col-lg-4 col-sm-12 mb-5"><div class="card">
                    <div class="card-body">
                      <h3 class="card-title voltaire-regular">Felhasználók</h3>
                      <p class="card-text">'.$x['db'].' db</p>
                    </div>
                  </div>
                  </div>';
                }
            }
        
            $film_db = $mozi->film_db();
            if (is_array($film_db)) {
                foreach($film_db as $x){
                    echo '<div class="col-lg-4 col-sm-12 mb-5"><div class="card">
                    <div class="card-body">
                      <h3 class="card-title voltaire-regular">Filmek</h3>
                      <p class="card-text">'.$x['db'].' db</p>
                    </div>
                  </div>
                  </div>';
                }
            }

            $vetites_db = $mozi->vetites_db();
            if (is_array($vetites_db)) {
                foreach($vetites_db as $x){
                    echo '<div class="col-lg-4 col-sm-12 mb-5"><div class="card">
                    <div class="card-body">
                      <h3 class="card-title voltaire-regular">Vetítések</h3>
                      <p class="card-text">'.$x['db'].' db</p>
                    </div>
                  </div>
                  </div>';
                }
            }

            $foglalas_db = $mozi->foglalas_db();
            if (is_array($foglalas_db)) {
                foreach($foglalas_db as $x){
                    echo '<div class="col-lg-4 col-sm-12 mb-5"><div class="card">
                    <div class="card-body">
                      <h3 class="card-title voltaire-regular">Foglalások</h3>
                      <p class="card-text">'.$x['db'].' db</p>
                    </div>
                  </div>
                  </div>';
                }
            }
        
        
    ?>
    </div>
    </div>
    </div>
    <?php include './footer.php'; ?>



</body>
</html>