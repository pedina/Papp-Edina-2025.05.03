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
    <title>Filmek kezelése</title>

    <style>
        .leiras{
            text-align: justify !important;
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

    <h2 class="voltaire-regular">Filmek kezelése</h2>
    <div class="d-flex justify-content-end"><input type="button" class="btn btn-secondary mx-3" id="ujRendezoGomb" value="Új rendező hozzáadása"><input type="button" class="btn btn-secondary" id="ujFilmGomb" value="Új film hozzáadása"></div>

    <?php
        $mozi = new Mozi();
        $movies = $mozi->osszes_filmadat();
        if(is_array($movies)){
           echo '           
           <div class="d-flex justify-content-center text-center"><table class="table w-75 "><thead>
            <tr>
              <th scope="col">Kép</th>
              <th scope="col">Cím</th>
              <th scope="col">Leírás</th>
              <th scope="col">Hossz</th>
              <th scope="col">Rendező</th>
              <th scope="col">Műfaj</th>
              <th scope="col">Korhatár</th>
              <th scope="col">Év</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead><tbody>';
            foreach($movies as $x){
                echo '<tr class="align-middle text-center"><td><img src="./img/'.$x['url'].'" class="rounded border" alt="'.$x['cim'].'" title="'.$x['cim'].'" width="100"></td><td>'.$x['cim'].'</td><td class="leiras">'.$x['leiras'].'</td><td>'.$x['hossz'].' perc</td><td>'.$x['rendezo'].'</td><td>'.$x['mufaj'].'</td><td>'.$x['besorolas'].'</td><td>'.$x['ev'].'</td><td><input type="button" class="btn btn-secondary" id="'.$x['id'].'T" value="Törlés" onclick="filmTorles(this)"></td><td><input type="button" class="btn btn-secondary" id="'.$x['id'].'M" value="Módosítás" onclick="filmModositas(this)"></td></tr>';
            }
            echo '</tbody></table></div>';
        }
        else{
            echo 'Nincs találat';
        }
    ?>
</div>
    </div>
    </div>
    <?php include './footer.php'; ?>

    <script>
        async function filmTorles(elem){
            var jovahagyas = confirm("Ezzel törli a filmhez tartozó vetítéseket és foglalásokat. Biztos benne?");
            var valaszok = [];

            if (jovahagyas == true) {
                let ertek = elem.id;
                let filmid = ertek.substring(0,ertek.length-1);
                let eredmeny = await fetch('class/index.class.php/admin_torles_ellenorzes_vetites', {
                    method : 'POST',
                    body: JSON.stringify({
                        'filmid': filmid
                    })
                });
                let adatok = await eredmeny.json();
                console.log(adatok);

                if(adatok['valasz'] != 'Nincs talalat'){
                        let eredmeny2 = await fetch('class/index.class.php/admin_torles_ellenorzes_foglalas', {
                        method : 'POST',
                        body: JSON.stringify({
                            'filmid': filmid
                        })
                    });
                    let adatok2 = await eredmeny2.json();
                    if(adatok2['valasz'] != 'Nincs talalat'){
                        let torles = await fetch('class/index.class.php/admin_torles_foglalas', {
                            method : 'POST',
                            body: JSON.stringify({
                                'filmid': filmid
                            })
                        });
                        let data = await torles.json();
                        console.log(data);
                        valaszok.push(data);
                    }
                        let torles2 = await fetch('class/index.class.php/admin_torles_vetites', {
                        method : 'POST',
                        body: JSON.stringify({
                            'filmid': filmid
                        })
                    });
                    let data2 = await torles2.json();
                    console.log(data2);
                    valaszok.push(data2);
                }
                let torles3 = await fetch('class/index.class.php/admin_torles_film', {
                    method : 'POST',
                    body: JSON.stringify({
                        'filmid': filmid
                    })
                });
                let data3 = await torles3.json();
                console.log(data3);
                valaszok.push(data3);

                var mindenTorlesSikeres = valaszok.every(torles => torles == 'Sikeres művelet');

                if (mindenTorlesSikeres) {
                    window.location.href='movies_admin.php';
                } else {
                    alert('A törlés sikertelen');
                }

            }
        }

        

        function filmModositas(elem){
            let ertek = elem.id;
                let filmid = ertek.substring(0,ertek.length-1);
            window.location.href = "filmadat_modosit.php?gombnyomas=true&id=" + filmid;
        }

        function ujFilm(){
            window.location.href = "add_movie.php";
        }

        function ujRendezo(){
            window.location.href = "add_rendezo.php";
        }

        document.getElementById('ujFilmGomb').addEventListener('click',ujFilm);
        document.getElementById('ujRendezoGomb').addEventListener('click',ujRendezo);
    </script>
</body>
</html>