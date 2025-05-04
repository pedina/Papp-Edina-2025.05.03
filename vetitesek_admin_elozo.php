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
    <title>Vetítések kezelése</title>
    <style>
        a{
            text-decoration: underline;
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
    <div id="main">
    <h2 class="voltaire-regular">Vetítések kezelése</h2>
    <a href="vetitesek_admin.php" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Aktuális vetítések</a>

    <?php
        $mozi = new Mozi();
        $movies = $mozi->elozo_vetitesek_admin();
        if(is_array($movies)){
           echo '           
           <div class="d-flex justify-content-center"><table class="table w-75"><thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Cím</th>
              <th scope="col">Dátum</th>
              <th scope="col">Idő</th>
            </tr>
          </thead><tbody>';
            foreach($movies as $x){
                echo '<tr class="align-middle"><td><img src="./img/'.$x['url'].'" class="rounded border" alt="'.$x['cim'].'" title="'.$x['cim'].'" width="80"></td><td>'.$x['cim'].'</td><td>'.$x['datum'].'</td><td>'.$x['ido'].'</td></tr>';
            }
            echo '</tbody></table></div>';
        }
        else{
            echo 'Nincs találat';
        }
    ?>
</div></div>
<?php include './footer.php'; ?>

</body>
</html>