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
    <title>Jegyfoglalás</title>
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

        h3.voltaire-regular{
            font-size:42px;
        }

        h5.voltaire-regular{
            font-size:32px;
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

        $mozi = new Mozi();
        $info = $mozi->choosen_vetites($_GET['id']);
        echo '<div id="tartalom">';
        echo '<div id="main">';
        if(is_array($info)){
            foreach($info as $x){
                echo '<h3 class="voltaire-regular">'.$x['cim'].' jegyfoglalás</h3>';
                echo '<h6>'.$x['datum'].' '.$x['ido'].'</h6>';
                $sum_ferohely=$x['ferohely'];
            }
        }
    ?>
    <br>
    <h5 class="voltaire-regular">Összegzés</h5>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST as $kategoria => $szek) {
                if($kategoria!='veglegesit' && $kategoria!='Tovább'){
                    
                $osszegzes[$kategoria] = $szek;
                }
            }
        }  
            $_SESSION['osszegzes'] = $osszegzes;

         
        $prices = $mozi->arazas();
        $vegosszeg = 0;
        if(is_array($prices)){
            echo '<table class="table w-75"><thead>
                    <tr>
                    <th scope="col">Kategória</th>
                    <th scope="col">Székszám</th>
                    <th scope="col">Ár</th>
                    </tr>
                </thead><tbody>';
            foreach($prices as $x){
                foreach($_SESSION['osszegzes'] as $kategoria => $szek){
                    if($x['kategoria'][0]==$kategoria[0]){
                        echo '<tr><td>'.$x['kategoria'].'</td><td>'.$szek.'</td><td>'.$x['ar'].' Ft</td></tr>';
                        $vegosszeg+=$x['ar'];
                    }
                }
            }
            echo '<tr><td colspan="2">Végösszeg:</td><td>'.$vegosszeg.' Ft</td></tr></tbody></table>';
        }
    ?>

        <input type="submit" name="veglegesit" id='gomb' value="Foglalás véglegesítése" class="btn btn-secondary">
    <p id="kiir"></p></div></div>

    <?php include './footer.php'; ?>

    <script>
        async function foglalas(){
            try{
                var osszegzes = <?php echo json_encode($_SESSION['osszegzes']); ?>;
                var prices = <?php echo json_encode($prices); ?>;
                var userId = <?php echo $_SESSION['user_id']; ?>;
                var vetites_id = <?php echo $_GET['id']; ?>;

                let foglalt_szekek = [];
                for (var key in osszegzes) {
                    if (osszegzes.hasOwnProperty(key)) {
                        let eredmeny = await fetch('class/index.class.php/eddigfoglalt', {
                            method : 'POST',
                            body: JSON.stringify({
                                'vetitid': vetites_id,
                                'szekszam': osszegzes[key]
                            })
                        });
                        let adatok = await eredmeny.json();
                        foglalt_szekek.push(adatok['valasz']);
                    }
                }

                osszes_szek_szabad = true;
                for (let i = 0; i < foglalt_szekek.length; i++) {
                    if(foglalt_szekek[i]!='Nincs talalat'){
                        osszes_szek_szabad = false;
                    }
                }

                if(!osszes_szek_szabad){
                    alert('Hiba történt a foglalás során');
                }
                else{
                    let sikeres_feltoltes_szamlalo = [];
                    for (var x of prices) {
                        for (var key in osszegzes) {
                            if (osszegzes.hasOwnProperty(key)) {
                                if(x['kategoria'][0]==key[0]){
                                    let keres = await fetch('class/index.class.php/foglalas', {
                                        method: 'POST',
                                        body: JSON.stringify({
                                            'userid': userId,
                                            'vetitid': vetites_id,
                                            'szekszam': osszegzes[key],
                                            'jegytipus': x['id']
                                        })
                                    });
                                    let adatok = await keres.json();
                                    sikeres_feltoltes_szamlalo.push(adatok);
                                }
                            }
                        }
                    }

                    let success = true;
                    for (let i = 0; i < sikeres_feltoltes_szamlalo.length; i++) {
                        if(sikeres_feltoltes_szamlalo[i]!='Sikeres művelet'){
                            success = false;
                        }
                        
                    }
                    if(success){
                        window.location.href = "success.php";
                    }else{
                        alert('Hiba történt a foglalás során');
                    }
                }

            }catch(error){
                console.log(error);
            }
        }

        document.getElementById('gomb').addEventListener('click', foglalas);
    </script>
</body>
</html>