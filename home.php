<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Voltaire&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="./logo/favicon.jpg">
    <title>Főoldal</title>
    <style>
        @media only screen and (max-width: 1920px) {
            #tartalom {
                font-size: 18px;
            }
        }

        @media only screen and (max-width: 720px) {
            #tartalom {
                font-size: 15px;
            }
        }

        @media only screen and (max-width: 540px) {
            #tartalom {
                font-size: 13px;
            }
        }
        #main{
            min-width:100%;
            height:100%;
        }

        .navbar{
            margin-bottom: 0px !important;
        }

        .reklam{
            width: 100%;
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
        
        
    ?>

    <div id="tartalom">
        <div id="main">
        <div class="row">
                <div class="col col-md-1 col-0 p-0" id="oszlopElso">
                <img src="./img/border.png"  width="100%" height="auto">
                </div>
                <div class="col col-md-10 col-12 p-0">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="./img/carousel2.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="./img/carousel45.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="./img/carousel1.png" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    </div>
                </div>
                <div class="col col-md-1 col-0 p-0" id="oszlopMasodik">
                <img src="./img/border.png"  width="100%" height="auto">
                </div>
            </div>
        </div>
    </div>
    <?php include './footer.php'; ?>

    
</body>
</html>