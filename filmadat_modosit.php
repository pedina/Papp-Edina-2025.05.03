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
    <title>Filmadat módosítása</title>
    <style>
    #cimMezo{
        width:300px;
    }

    #modositGomb{
        margin-bottom:20px;
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

        if (isset($_GET['gombnyomas']) && $_GET['gombnyomas'] == "true" && isset($_GET['id'])) {
                ?>
                <div id="tartalom">
                <div id="main">
                <h2 class="voltaire-regular">Film módosítása</h2>
                    <table class="table">
                        <tr>
                            <td>Kép</td>
                            <td><input type="file" accept="image/*" id="kepMezo"> Eredeti: <label id="kepUrl"></label></td>
                        </tr>
                        <tr>
                            <td>Cím</td>
                            <td><input type="text" id="cimMezo"></td>
                        </tr>
                        <tr>
                            <td>Leírás</td>
                            <td><textarea id="leirasMezo" cols="50" rows="10"></textarea></td>
                        </tr>
                        <tr>
                            <td>Hossz</td>
                            <td><input type="number" id="idoMezo" min="5" max="240"></td>
                        </tr>
                        <tr>
                            <td>Rendező</td>
                            <td><select id="rendezoMezo"></select></td>
                        </tr>
                        <tr>
                            <td>Műfaj</td>
                            <td><select id="mufajMezo"></select></td>
                        </tr>
                        <tr>
                            <td>Besorolás</td>
                            <td><select id="korMezo"></select></td>
                        </tr>
                        <tr>
                            <td>Év</td>
                            <td><input type="number" id="evMezo" min="1900" max="2024"></td>
                        </tr>
                    </table>
                    
            <input type="button" class="btn btn-secondary" id="modositGomb" value="Módosít">
            </div>
            </div>
                <?php                
            include './footer.php';
        } else {
            header("location:home_admin.php");
            exit;
        }
    ?>
    <script>
        async function betoltes(){
            try{
                let eredmenyRen = await fetch('class/index.class.php/ossz_rendezo');
                let rendezo = await eredmenyRen.json();
                if(Array.isArray(rendezo)){
                    for (var x of rendezo) {
                        document.getElementById('rendezoMezo').innerHTML+='<option value="'+x['id']+'">'+x['nev']+'</option>';
                    }
                }

                let eredmenyMufaj = await fetch('class/index.class.php/ossz_mufaj');
                let mufaj = await eredmenyMufaj.json();
                if(Array.isArray(mufaj)){
                    for (var x of mufaj) {
                        document.getElementById('mufajMezo').innerHTML+='<option value="'+x['id']+'">'+x['nev']+'</option>';
                    }
                }

                let eredmenyKor = await fetch('class/index.class.php/ossz_besorolas');
                let kor = await eredmenyKor.json();
                if(Array.isArray(kor)){
                    for (var x of kor) {
                        document.getElementById('korMezo').innerHTML+='<option value="'+x['id']+'">'+x['kor']+'</option>';
                    }
                }

                var selectRendezo = document.getElementById("rendezoMezo");
                var selectMufaj = document.getElementById("mufajMezo");
                var selectKor = document.getElementById("korMezo");

                let id = <?php echo $_GET['id']?>;
                let eredmeny = await fetch('class/index.class.php/choosen_film', {
                    method : 'POST',
                    body: JSON.stringify({
                        'filmid': id
                    })
                });
                let adatok = await eredmeny.json();
                if(Array.isArray(adatok)){
                    for (var x of adatok) {
                        for (var y of selectRendezo) {
                            if(y.innerText==x['rendezo']){
                                y.selected=true;
                            }
                        }
                        for (var y of selectMufaj) {
                            if(y.innerText==x['mufaj']){
                                y.selected=true;
                            }
                        }
                        for (var y of selectKor) {
                            if(y.innerText==x['besorolas']){
                                y.selected=true;
                            }
                        }
                        document.getElementById('cimMezo').value=x['cim'];
                        document.getElementById('leirasMezo').value=x['leiras'];
                        document.getElementById('idoMezo').value=x['hossz'];
                        document.getElementById('evMezo').value=x['ev'];
                        document.getElementById('kepUrl').innerText=x['kepurl'];
                        console.log();

                    }
                }
            }
            catch(error){
                console.log(error);
            }
        }

        async function modositasElkuld(){
            try{
                let mezo1 = document.getElementById('cimMezo').value;
                let mezo2 = document.getElementById('leirasMezo').value;
                let mezo3 = document.getElementById('idoMezo').value;
                let mezo4 = document.getElementById('evMezo').value;
                let mezo5 = document.getElementById('kepMezo').value;
                let kepurl = mezo5.split('\\')[mezo5.split('\\').length-1];
                let id = <?php echo $_GET['id']?>;
                let adatok='';
                if(mezo1!='' && mezo2!='' && mezo3 != '' && mezo4 != ''){
                    if(mezo5 != ''){
                        console.log(mezo5.split('\\')[mezo5.split('\\').length-1]);

                        let eredmeny = await fetch('class/index.class.php/admin_film_modositas', {
                            method : 'PUT',
                            body: JSON.stringify({
                                'cim':mezo1,
                                'leiras':mezo2,
                                'hossz':mezo3,
                                'url':kepurl,
                                'rendezoid':document.getElementById('rendezoMezo').value,
                                'mufajid':document.getElementById('mufajMezo').value,
                                'besorolasid':document.getElementById('korMezo').value,
                                'ev':mezo4,
                                'filmid': id
                            })
                        });
                        adatok = await eredmeny.json();
                    }
                    else{
                        let eredmeny = await fetch('class/index.class.php/admin_film_modositas', {
                            method : 'PUT',
                            body: JSON.stringify({
                                'cim':mezo1,
                                'leiras':mezo2,
                                'hossz':mezo3,
                                'url':document.getElementById('kepUrl').innerText,
                                'rendezoid':document.getElementById('rendezoMezo').value,
                                'mufajid':document.getElementById('mufajMezo').value,
                                'besorolasid':document.getElementById('korMezo').value,
                                'ev':mezo4,
                                'filmid': id
                            })
                        });
                        adatok = await eredmeny.json();
                        console.log(adatok);
                    }
                    if(adatok=='Sikeres művelet'){
                        window.location.href='movies_admin.php';
                    }
                    else{
                        alert('Sikertelen művelet');
                    }
                }
                else{
                    alert('Töltse ki az összes mezőt!');
                }
            }
            catch(error){
                console.log(error);
            }
        }


        window.addEventListener('load',betoltes);
        document.getElementById('modositGomb').addEventListener('click',modositasElkuld);
    </script>
</body>
</html>