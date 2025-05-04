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
    <title>Jegyárak</title>
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

        #tartalom{
            margin-left:10px;
            margin-right:10px;
        }
        .voltaire-regular{
            font-size:45px;
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

        echo '<div id="tartalom">
                <div id="main">
                    <h3 class="voltaire-regular">Jegyárak</h3>';

        $mozi = new Mozi();
        $prices = $mozi->arazas();
        if(is_array($prices)){
            echo '<table class="table w-75"><thead>
            <tr>
              <th scope="col">Kategória</th>
              <th scope="col">Ár</th>
            </tr>
          </thead><tbody>';
            foreach($prices as $x){
                echo '<tr><td>'.$x['kategoria'].'</td><td>'.$x['ar'].' Ft</td></tr>';
            }
            echo '</tbody></table>';
        }
        echo '</div></div>';

    
        include './footer.php';
    ?>

    
</body>
</html>