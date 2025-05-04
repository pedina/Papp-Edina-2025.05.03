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
    <title>Műsoron</title>
    <style>
        @media only screen and (max-width: 1920px) {
            .kepek{
                height: 320px;
            }
            .cimText{
                font-size:22px;
                max-width:210px;
            }
      }

        @media only screen and (max-width: 1200px) {
            .kepek{
                height: 250px;
            }
            .cimText{
                font-size:20px;
                max-width:160px;
            }
        }

        @media only screen and (max-width: 768px) {
            .kepek{
                height: 200px;
            }
            .cimText{
                font-size:20px;
                max-width:130px;
            }
        }

        .container{
            margin-bottom:100px!important;
            
            min-width:90%;
        }

        select{
            width:160px;
        }

        h5{
            text-transform:uppercase;
        }

        .cimText{
            text-align: center;
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
    ?>

    <div id="tartalom">
        <div id="main" class="container m-0">
        <div class="row px-2">
            <div class="col col-lg-2 col-md-3 col-sm-12" id="szurok">
                <h5 class="text-left voltaire-regular">Szűrés</h4>
                <div id="rendezoCont">
                    Rendező szerint<br> 
                    <select name="" id="rendezoLista" class="mb-3">
                        <option value="-1">Válasszon rendezőt</option>
                    </select>
                </div>
                <div id="mufajCont">
                    Műfaj szerint <br>  
                    <select name="" id="mufajLista" class="mb-3">
                        <option value="-1">Válasszon műfajt</option>
                    </select>
                </div>
                <div id="besorolasCont">
                    Korhatár szerint<br>    
                    <select name="" id="korLista" class="mb-3">
                        <option value="-1">Válasszon besorolást</option>
                    </select>
                </div>
                <input type="button" id="gombKereses" value="Keresés" class="btn btn-secondary">
                
            </div>
            <div class="col col-lg-10 col-md-9 col-sm-12">
                <div class="row d-flex justify-content-center" id="filmek"><?php
                $mozi = new Mozi();
                $movies = $mozi->filmek();
                if(is_array($movies)){
                    foreach($movies as $x){
                        echo '<div class="col col-lg-3 col-md-4 col-sm-12 d-flex justify-content-center" id="'.$x['id'].'"><a href="film.php?id='.$x['id'].'"><img src="./img/'.$x['url'].'" class="rounded border kepek" alt="'.$x['cim'].'" title="'.$x['cim'].'" height="250px"><p class="cimText">'.$x['cim'].'</p></a></div>';
                    }
                }

            ?>
            </div>
            </div>
        </div>
    </div>
    </div>
    <?php include './footer.php'; ?>

    <script>
        async function rendezoLeker(){
            try{
                let leker = await fetch('class/index.class.php/ossz_rendezo');
                let valasz = await leker.json();
                if(Array.isArray(valasz)){
                    for (var x of valasz) {
                        document.getElementById('rendezoLista').innerHTML+='<option value="'+x['id']+'"> '+x['nev']+'</option>';
                    }
                }
            }
            catch(error){
                console.log(error);
            }
        }

        async function mufajLeker(){
            try{
                let leker = await fetch('class/index.class.php/ossz_mufaj');
                let valasz = await leker.json();
                if(Array.isArray(valasz)){
                    for (var x of valasz) {
                        document.getElementById('mufajLista').innerHTML+='<option value="'+x['id']+'"> '+x['nev']+'</option>';
                    }
                }
            }
            catch(error){
                console.log(error);
            }
        }

        async function korLeker(){
            try{
                let leker = await fetch('class/index.class.php/ossz_besorolas');
                let valasz = await leker.json();
                if(Array.isArray(valasz)){
                    for (var x of valasz) {
                        document.getElementById('korLista').innerHTML+='<option value="'+x['id']+'"> '+x['kor']+'</option>';
                    }
                }
            }
            catch(error){
                console.log(error);
            }
        }

        async function kereses(){
            try{
                let rendezo = document.getElementById('rendezoLista').value;
                let mufaj = document.getElementById('mufajLista').value;
                let besorolas = document.getElementById('korLista').value;
                let criteria = {
                    rendezoId: rendezo,
                    mufajId: mufaj,
                    besorolasId: besorolas
                };

                let keres = await fetch('class/index.class.php/kereses_kriterium', {
                    method: 'POST',
                    body: JSON.stringify({ 'criteria': criteria })
                });
                let adatok = await keres.json();

                if(adatok['valasz']!='Nincs talalat'){
                    if(Array.isArray(adatok)){
                        document.getElementById('filmek').innerHTML='';
                        for (var x of adatok) {
                            document.getElementById('filmek').innerHTML+='<div class="col col-lg-3 col-md-4 col-sm-12 d-flex justify-content-center" id="'+x['id']+'"><a href="film.php?id='+x['id']+'"><img src="./img/'+x['url']+'" class="rounded kepek" alt="'+x['cim']+'" title="'+x['cim']+'" height="250px"><p class="cimText">'+x['cim']+'</p></a></div>';
                        }
                    }
                }
                else{
                    document.getElementById('filmek').innerHTML='Nincs találat';
                }
            }
            catch(error){
                console.log(error);
            }
            
        }

        window.addEventListener('load', () => {
            rendezoLeker();
            mufajLeker();
            korLeker();
        });

        document.getElementById('gombKereses').addEventListener('click',kereses);
    </script>
</body>
</html>