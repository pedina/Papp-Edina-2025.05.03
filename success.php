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
    <title>Sikeres foglalás</title>
    <style>
        .voltaire-regular{
            font-size:55px;
        }

        #main{
            text-align:center;
        }

        #warning{
            font-size:20px;
        }
    </style>
</head>
<body>
    <?php
        session_start();

        if(!isset($_SESSION['user_id'])){
           header('location:login.php');
        }
        else{
            include './header.php';
        }


    ?>

    <div id="tartalom">
        <div id="main">
            <h1 class="voltaire-regular">Sikeres foglalás!</h1>
            <p id="warning">Foglalt jegyeit megtekintheti a Profil menüpontban.</p>
            <p>A jegyeket az előadás kezdete előtt legkésőbb 15 perccel kell átvenni és kifizetni. Amennyiben ez nem történik meg, a jegyeket újra értékesítésre bocsátják.</p>
        </div>
    </div>
    
    <?php include './footer.php'; ?>
    
</body>
</html>