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
    <title>Vetítés hozzáadása</title>
    <style>
    #cimMezo{
        width:300px;
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
    <h2 class="voltaire-regular">Új vetítés</h2>
    <table class="table">
        <tr>
            <td>Cím</td>
            <td><select id="cimMezo"></select></td>
        </tr>
        <tr>
            <td>Dátum</td>
            <td><input type="date" id="datumMezo"  min="<?php echo date('Y-m-d'); ?>"></td>
        </tr>
        <tr>
            <td>Idő</td>
            <td><input type="time" id="idoMezo"></td>
        </tr>
        <tr>
            <td>Férőhely</td>
            <td><select id="teremMezo"></select></td>
        </tr>
    </table>
    <input type="button" class="btn btn-secondary" id="mentGomb" value="Mentés">
    </div></div>
    <?php include './footer.php'; ?>

    <script>
        async function betoltes(){
            try{
                let keres = await fetch('class/index.class.php/ossz_terem');
                let valasz = await keres.json();
                if(Array.isArray(valasz)){
                    for (var x of valasz) {
                        document.getElementById('teremMezo').innerHTML+='<option value="'+x['id']+'">'+x['ferohely']+' fő</option>';
                    }
                }
                let keres2 = await fetch('class/index.class.php/ossz_film');
                let valasz2 = await keres2.json();
                if(Array.isArray(valasz2)){
                    for (var x of valasz2) {
                        document.getElementById('cimMezo').innerHTML+='<option value="'+x['id']+'">'+x['cim']+'</option>';
                    }
                }

            }
            catch(error){
                console.log(error);
            }
        }

        async function mar_letezik(){
            let film = document.getElementById('cimMezo').value;
            let vetitDatum = document.getElementById('datumMezo').value;
            let vetitIdo = document.getElementById('idoMezo').value;
            let eredmeny = await fetch('class/index.class.php/admin_vetites_mar_letezike',{
                method : 'POST',
                body: JSON.stringify({
                    'filmid': film,
                    'datum': vetitDatum,
                    'ido': vetitIdo
                })
            });
            let adat = await eredmeny.json();

            if(adat['valasz'] == 'Nincs talalat'){
                return false;
            }
            else{
                return true;
            }
        }

        function helytelen_kitoltes(){
            let mezo1 = document.getElementById('datumMezo').value;
            let mezo2 = document.getElementById('idoMezo').value;
            if(mezo1!='' && mezo2!='' && mezo2.split(':')[0]>9 && mezo2.split(':')[0]<22){
                return false;
            } else {
                return true;
            }

        }


        async function mentes(){
            try{
                if(helytelen_kitoltes()==false){
                    if(await mar_letezik()==false){
                        let mezo1 = document.getElementById('cimMezo').value;
                        let mezo2 = document.getElementById('datumMezo').value;
                        let mezo3 = document.getElementById('idoMezo').value;
                        let mezo4 = document.getElementById('teremMezo').value;
                        
                        let terem = await fetch('class/index.class.php/admin_vetites_terem_idosav', {
                            method : 'POST',
                            body: JSON.stringify({
                                'datum':mezo2,
                                'ora':mezo3,
                                'teremid':mezo4
                            })
                        });


                        let data = await terem.json();
                        if(data['valasz']=='Nincs talalat'){
                            let eredmeny = await fetch('class/index.class.php/admin_ujvetites', {
                                method : 'POST',
                                body: JSON.stringify({
                                    'filmid':mezo1,
                                    'datum':mezo2,
                                    'ido':mezo3,
                                    'teremid':mezo4
                                })
                            });
                            let adatok = await eredmeny.json();
                            if(adatok=='Sikeres művelet'){
                                window.location.href='vetitesek_admin.php';
                            }
                        }
                        else{
                            alert('Ebben az idősávban foglalt ez a terem');
                        }

                        
                    }
                    else{
                        alert('Már van ilyen vetítés!');
                    }
                }
                else{
                    alert('Hibás kitöltés');
                }
            }
            catch(error){
                console.log(error);
            }
        }
        
        window.addEventListener('load',betoltes);
        document.getElementById('mentGomb').addEventListener('click',mentes);
    </script>
</body>