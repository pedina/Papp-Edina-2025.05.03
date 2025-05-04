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
            td,th{
                padding: 6px;
            }
        }

        @media only screen and (max-width: 720px) {
            #tartalom {
                font-size: 15px;
            }
            td,th{
                padding: 5px;
            }
        }

        @media only screen and (max-width: 540px) {
            #tartalom {
                font-size: 13px;
            }
            td,th{
                padding: 4px;
            }
        }

        #tartalom{
            margin-left:10px;
            margin-right:10px;
        }

        
        .voltaire-regular{
                font-size: 42px;
            }
        
    </style>
</head>
<body>
    <?php
        session_start();

        if(!isset($_SESSION['user_id'])){
           header('location:login.php');
        }
        
        
        include './header.php';
        include './mozi.class.php';
        include './adatbazis.class.php';

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

        $prices = $mozi->arazas();
        $kategoriak = array();
        
        if(is_array($prices)){
            echo '<form action="./reservation.php?id='.$_GET['id'].'" method="post"><table class="table"><thead>
            <tr>
              <th>Kategória</th>
              <th>Ár</th>
              <th>Mennyiség</th>
            </tr>
          </thead>';
            foreach($prices as $x){
                echo '<tr><td>'.$x['kategoria'].'</td><td>'.$x['ar'].' Ft</td><td><select name="'.$x['id'].'">';
                
                    for ($i = 0; $i < 6; $i++) {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                echo '</select></td></tr>';
                array_push($kategoriak,$x['id']);
            }
            
            echo '</table>';
            echo '<input type="hidden" name="select_db" value="' . count($kategoriak) . '">';
        }
        

        echo '<br><input type="submit" id="foglalas_jegykivalasztas" name="foglalas_jegykivalasztas" value="Tovább" class="btn btn-secondary"></form></div></div>';

        include './footer.php'; 
        $eddig_foglalt_db = $mozi->vetites_foglalas_dbszam($_GET['id']);
        if(is_array($eddig_foglalt_db)){
            foreach($eddig_foglalt_db as $x){
                $sum_marfoglalt = $x['osszdb'];
            }
        }

        $sum_foglalna=0;
            for ($i=0; $i < count($kategoriak); $i++) { 
                if(isset($_POST[$kategoriak[$i]])){
                    $sum_foglalna += $_POST[$kategoriak[$i]];
                }
            }
    ?>
    <script>
        function elemek(){
            let selectek = document.getElementsByTagName('select');
            document.getElementById('foglalas_jegykivalasztas').disabled = true;
            let ertek = false;
            for (let i = 0; i < selectek.length; i++) {
                selectek[i].addEventListener('change', ellenorzes);
            }
        }

        function ellenorzes(){
            let selectek = document.getElementsByTagName('select');
            let ertek = false;
            let foglalna = 0; 
            for (var x of selectek) {
                if(x.value > 0){
                    ertek = true;
                    foglalna += parseInt(x.value);
                }    
            }

            let mar_foglalt = <?php echo $sum_marfoglalt; ?>;
            let ossz_hely = <?php echo $sum_ferohely; ?>;

            if(ossz_hely-mar_foglalt<foglalna){
                document.getElementById('uzenet').innerHTML='Sajnáljuk, de az ön által kiválasztott darabszám meghaladja az előadásra még elérhető helyek számát.<br>Elérhető helyek száma:'+ossz_hely-mar_foglalt;
                document.getElementById('foglalas_jegykivalasztas').disabled = true;
            }
            else if(foglalna==0){
                document.getElementById('uzenet').innerHTML='Kérem válasszon darabszámot mielőtt továbblépne!';
                document.getElementById('foglalas_jegykivalasztas').disabled = true;
            }
            else{
                document.getElementById('foglalas_jegykivalasztas').disabled = false;
                document.getElementById('uzenet').innerHTML='';
            }
        }

        
        window.addEventListener('load', elemek);
    
    </script>

    
    <p id="uzenet"></p>
    
</body>
</html>

