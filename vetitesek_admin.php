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
    <a href="vetitesek_admin_elozo.php" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Korábbi vetítések</a>
    <div class="d-flex justify-content-end"><input type="button" class="btn btn-secondary" id="ujvetitesGomb" value="Új vetítés hozzáadása"></div>

    <?php
        $mozi = new Mozi();
        $movies = $mozi->akt_vetitesek_admin();
        if(is_array($movies)){
           echo '           
           <div class="d-flex justify-content-center"><table class="table w-75 "><thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Cím</th>
              <th scope="col">Dátum</th>
              <th scope="col">Idő</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead><tbody>';
            foreach($movies as $x){
                echo '<tr class="align-middle"><td><img src="./img/'.$x['url'].'" class="rounded border" alt="'.$x['cim'].'" title="'.$x['cim'].'" width="80"></td><td>'.$x['cim'].'</td><td>'.$x['datum'].'</td><td>'.$x['ido'].'</td><td><input type="button" class="btn btn-secondary" id="'.$x['id'].'T" value="Törlés" onclick="vetitesTorles(this)"></td><td><input type="button" class="btn btn-secondary" id="'.$x['id'].'M" value="Módosítás" onclick="vetitesModositas(this)"></td></tr>';
            }
            echo '</tbody></table></div>';
        }
        else{
            echo 'Nincs találat';
        }
    ?>
</div></div>
<?php include './footer.php'; ?>

    <script>
        async function vetitesTorles(elem){
            var jovahagyas = confirm("Ezzel törli a vetítéshez tartozó foglalásokat. Biztos benne?");

            if (jovahagyas == true) {
                let valaszok = [];
                let ertek = elem.id;
                let vetitid = ertek.substring(0,ertek.length-1);
                let eredmeny2 = await fetch('class/index.class.php/admin_torles_ellenorzes_foglalas_v', {
                    method : 'POST',
                    body: JSON.stringify({
                    'vetitid': vetitid
                    })
                });
                let adatok2 = await eredmeny2.json();

                if(adatok2['valasz'] != 'Nincs talalat'){
                    let torles = await fetch('class/index.class.php/admin_torles_foglalas_v', {
                        method : 'DELETE',
                        body: JSON.stringify({
                            'vetitid': vetitid
                        })
                    });
                    let data = await torles.json();
                    valaszok.push(data);
                }

                    let torles2 = await fetch('class/index.class.php/admin_torles_vetites_v', {
                        method : 'DELETE',
                        body: JSON.stringify({
                            'vetitid': vetitid
                        })
                    });
                    let data2 = await torles2.json();
                    valaszok.push(data2);
                    
                    var mindenTorlesSikeres = valaszok.every(torles => torles == 'Sikeres művelet');

                    if (mindenTorlesSikeres) {
                        window.location.href='vetitesek_admin.php';
                    } else {
                        alert('A törlés sikertelen');
                    }
                }
            }
        

        

        function vetitesModositas(elem){
            let ertek = elem.id;
                let vetitid = ertek.substring(0,ertek.length-1);
            window.location.href = "vetitadat_modosit.php?gombnyomas=true&id=" + vetitid;
        }

        function ujvetites(){
            window.location.href = "add_vetites.php";
        }

        document.getElementById('ujvetitesGomb').addEventListener('click',ujvetites);
    </script>
</body>
</html>