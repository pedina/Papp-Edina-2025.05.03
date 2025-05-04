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
            .cella{
                font-size: 10px;
                height: 38px;
                width: 38px;
            }
            #vaszon {
                width: 380px;
                height: 15px;
            }
            #ures{
                width: 380px;
                height: 25px;
            }
        }

        @media only screen and (max-width: 720px) {
            #tartalom {
                font-size: 15px;
            }
            .cella{
                font-size: 9px;
                height: 33px;
                width: 33px;
            }
            #vaszon {
                width: 330px;
                height: 13px;
            }
            #ures{
                width: 330px;
                height: 20px;
            }
        }

        @media only screen and (max-width: 540px) {
            #tartalom {
                font-size: 13px;
            }
            .cella{
                font-size: 7px;
                height: 27px;
                width: 27px;
            }
            #vaszon {
                width: 270px;
                height: 10px;
            }
            #ures{
                width: 270px;
                height: 15px;
            }
        }

        table {
        border-collapse: separate;
        border-spacing: 5px;
        border: 0.5px solid black;
        padding: 5px;
    }

    .cella{
        border: 1px solid;
        text-align: center;
        padding: 5px;
    }

    #vaszon {
        border: 1px solid;
        text-align: center;
    }

    h3,h6{
        margin-left:10px;
    }

    .container{
            margin-bottom:50px!important;
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

        echo '<div id="tartalom">';
        echo '<div id="main">';
        $mozi = new Mozi();
        $info = $mozi->choosen_vetites($_GET['id']);
        if(is_array($info)){
            foreach($info as $x){
                echo '<h3 class="voltaire-regular">'.$x['cim'].' jegyfoglalás</h3>';
                echo '<h6>'.$x['datum'].' '.$x['ido'].'</h6>';
                $sum_ferohely=$x['ferohely'];
            }
        }

        $szekek = $mozi->mar_foglalt($_GET['id']);
        $foglalt_szekek = array();
        if(is_array($szekek)){
            foreach($szekek as $x){
                array_push($foglalt_szekek,$x['szekszam']);
            }
        }

        
        echo '<div class="container container-fluid mt-3">
        <div class="row">
          <div class="col col-lg-6 col-md-8 col-sm-12 col-12 d-flex justify-content-center">';
        echo '<table><tr>
        <td colspan="10" id="vaszon">vászon</td></tr><tr><td colspan="10" id="ures"></td></tr>';
        $x=1;
        for ($i=0; $i < $sum_ferohely/10; $i++) { 
            echo '<tr>';
            for ($j=0; $j < 10; $j++) { 
                echo '<td class="cella">'.$x.'</td>';
                $x++;
            }
            echo '</tr>';
        }
        echo '</table></div>
        <div class="col col-lg-6 col-md-4 col-sm-12 col-12">';

        $prices = $mozi->arazas();
        $kategoriak = array();
        if(is_array($prices)){
            foreach($prices as $x){
                array_push($kategoriak,$x['kategoria']);
            }
        }
        
        echo '<form action="osszegzes.php?id='.$_GET['id'].'" method="post">';
        if(count($kategoriak)==$_POST['select_db']){
            for ($i=1; $i <= $_POST['select_db']; $i++) { 
                if($_POST[$i]>0){
                    echo $kategoriak[$i-1].'<br>';
                    for ($j=0; $j < $_POST[$i]; $j++) { 
                        echo '<select name="'.$kategoriak[$i-1][0].''.$j.'" id="'.$kategoriak[$i-1][0].''.$j.'"><option value=' . -1 . '>választás</option>';
                        for ($k=1; $k <= $sum_ferohely; $k++) {
                            if(!in_array($k,$foglalt_szekek)){
                                echo '<option value=' . $k . '>' . $k . '</option>';
                            }
                        }
                        echo '</select><br>';
                    }
                }
            }
            echo '<input type="submit" class="btn btn-secondary mt-3" id="elkuld" value="Tovább"></form>';
        }

        echo '<p id="eredm"></p></div></div></div>';
        echo '</div>';
        echo '</div>';
        include './footer.php'; 
        
    ?>
    
    <script>
        function foglaltSzek(){
            let szekszamok = <?php echo json_encode($foglalt_szekek); ?>;

            let cells = document.getElementsByClassName('cella');
            document.getElementById('vaszon').style.backgroundColor = '#f2f2f2';
            document.getElementById('vaszon').style.color = '#999999';
            for (var x of cells) {
                x.style.backgroundColor = '#82e382';
            }
            for (var x of cells) {
                for(var szam of szekszamok){
                    if(x.innerText==szam){
                        x.style.backgroundColor = '#f2f2f2';
                        x.style.color = '#999999';
                    }
                }
            }

            document.getElementById('elkuld').disabled = true;
            let selectElemek = document.getElementsByTagName('select');
            for (let i = 0; i < selectElemek.length; i++) {
                selectElemek[i].addEventListener('change', valaszt);
            }
        }

        function valaszt(){
            let selectek = document.getElementsByTagName('select');
            document.getElementById('eredm').innerHTML='';
            let van = [];
            let i=0;
            let ertek = false, nincs = false;
            for (var x of selectek) {
                van[i]=x.value;
                i++;
            }
            for (i = 0; i < van.length-1; i++) {
                for (let j = i + 1; j < van.length; j++) {
                    if(van[i]==van[j]){
                        ertek=true;
                    }
                    if(van[j]==-1 || van[i]==-1){
                        nincs=true;
                    }
                }
            }

            if(nincs==true){
            document.getElementById('elkuld').disabled = true;
            }
            else
            if(ertek==true){
                document.getElementById('eredm').innerHTML='Eltérő székszámokat adjon meg!';
                document.getElementById('elkuld').disabled = true;
            }
            else{
                document.getElementById('elkuld').disabled = false;
            }

            let cells = document.getElementsByClassName('cella');
            let selectElemek = document.getElementsByTagName('select');
            let szekszamok = <?php echo json_encode($foglalt_szekek); ?>;
            for (var x of cells) {
                x.style.backgroundColor = '#82e382';
            }

            for (var x of cells) {
                for(var szam of szekszamok){
                    if(x.innerText==szam){
                        x.style.backgroundColor = '#f2f2f2';
                        x.style.color = '#999999';
                    }
                }
            }

            for (var select of selectElemek) {
                for (var x of cells) {
                    if(select.value==x.innerText){
                        x.style.backgroundColor = '#f7f76e';
                    }
                }
            }

        }
       


        window.addEventListener('load',foglaltSzek);
    </script>
</body>
</html>