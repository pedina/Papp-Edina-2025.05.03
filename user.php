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
    <title>Profil</title>
    <style>
        @media only screen and (max-width: 1920px) {
            #tartalom {
                font-size: 18px;
            }
            table{
                font-size: 16px;
            }

            
            
        }

        @media only screen and (max-width: 720px) {
            #tartalom {
                font-size: 15px;
            }
            table{
                font-size: 13px;
            }
            .btn{
                font-size:15px;
                height:25px;
                padding-left:6px;
                padding-right:6px;
                padding-top:0px;
                padding-bottom:3px;
            }
        }

        @media only screen and (max-width: 540px) {
            #tartalom {
                font-size: 13px;
            }
            table{
                font-size: 10px;
            }
            .datum{
                font-size: 9px;
            }
            .btn{
                height:20px;
                font-size:11px;
                padding-left:4px;
                padding-right:4px;
                padding-top:0px;
                padding-bottom:1px;
            }
        }

        #tartalom{
            margin-left:10px;
            margin-right:10px;
        }

        table{
            margin-bottom:100px!important;
        }

    </style>
</head>
<body>
    <?php
        session_start();
        include './header.php';
        include './mozi.class.php';
        include './adatbazis.class.php';

        if(!isset($_SESSION['user_id'])){
           header('location:login.php');
        }
    ?>

        <?php
           echo '<div id="tartalom">';
           echo '<div id="main">';
           echo '<h3>Adatok</h3>';
           echo '<p>Név: '.$_SESSION['user_name'].'</p>';
           echo '<p>Email: '.$_SESSION['user_email'].'</p>';
           echo '<h4>Foglalások</h4>';
           $mozi = new Mozi();
           $fogl = $mozi->user_foglalasok($_SESSION['user_id']);
           if(is_array($fogl)){
            echo '<table class="table w-70"><thead>
            <tr>
              <th scope="col">Film</th>
              <th scope="col">Dátum</th>
              <th scope="col">Terem</th>
              <th scope="col">Székszám</th>
              <th scope="col">Foglalás dátuma</th>
              <th scope="col">Ár</th>
              <th scope="col"></th>
            </tr>
          </thead><tbody>';
            foreach($fogl as $x){
                echo '<tr><td>'.$x['cim'].'</td><td class="datum"><span class="dateCheck" id="D'.$x['fogid'].'">'.$x['datum1'].'</span> '.$x['ido'].'</td><td>'.$x['teremId'].'</td><td>'.$x['szekszam'].'</td><td class="datum">'.$x['datum2'].'</td><td>'.$x['ar'].' Ft</td><td><input type="button" id='.$x['fogid'].' value="Törlés" onclick="foglalasTorles(this)" class="btn btn-secondary"></td></tr>';
            }
            echo '</tbody></table>';
           }
           else{
            echo 'Még nincsen foglalás';
           }
           echo '</div></div>';
        ?>
    
  
    <?php include './footer.php'; ?>

    <script>
        window.addEventListener('load', () => {
            const currentDate = new Date();
            let elements = document.getElementsByClassName('dateCheck');
            for (var x of elements) {
                var vetitDate = new Date(x.innerText);
                if(vetitDate < currentDate){
                    document.getElementById(x.id.substr(1)).disabled=true;

                }
            }
        });


        async function foglalasTorles(elem){
            var jovahagyas = confirm("Biztos benne, hogy lemondja foglalását?");

            if (jovahagyas == true) {
                let eredmeny = await fetch('class/index.class.php/torles', {
                    method : 'POST',
                    body: JSON.stringify({
                        'vetitid': elem.id
                    })
                });
                let adatok = await eredmeny.json();
                if(adatok=='Sikeres művelet'){
                    window.location.href = "user.php";
                }
            }
        }
    </script>
</body>
</html>