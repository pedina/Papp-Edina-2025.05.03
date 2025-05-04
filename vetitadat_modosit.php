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
    <title>Vetítés módosítása</title>
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

        if (isset($_GET['gombnyomas']) && $_GET['gombnyomas'] == "true" && isset($_GET['id'])) {
       ?>
            <div id="tartalom">
            <div id="main">
            <h2 class="voltaire-regular">Vetítés módosítása</h2>
            <table class="table">
                <tr>
                    <td>Cím</td>
                    <td><label id="cimMezo"></label></td>
                </tr>
                <tr>
                    <td>Dátum</td>
                    <td><input type="date" id="datumMezo"  min="<?php echo date('Y-m-d'); ?>"></td>
                </tr>
                <tr>
                    <td>Idő</td>
                    <td><input type="time" id="idoMezo" min="9:00" max="21:00"></td>
                </tr>
            </table>
            <input type="button" class="btn btn-secondary" id="modositGomb" value="Módosít">
        </div>
        </div>
    <?php              
        } else {
            header("location:home_admin.php");
            exit;
        }
    
    include './footer.php'; ?>
        <script>

            async function betolt(){
                let id = <?php echo $_GET['id']?>;
                let leker = await fetch('class/index.class.php/choosen_vetites',{
                    method: 'POST',
                    body: JSON.stringify({
                        'vetitesid':id
                    })
                });
                let adatok = await leker.json();
                
                if(Array.isArray(adatok)){
                    for (var x of adatok) {
                        document.getElementById('cimMezo').innerText=x['cim'];
                        document.getElementById('datumMezo').value=x['datum'];
                        document.getElementById('idoMezo').value=x['ido'];
                    }
                }
            }

            async function modositas(){
                let id = <?php echo $_GET['id']?>;
                let mezo1 = document.getElementById('datumMezo').value;
                let mezo2 = document.getElementById('idoMezo').value;
                if(mezo1!='' && mezo2!=''){
                    let eredmeny = await fetch('class/index.class.php/admin_vetites_modositas', {
                        method : 'PUT',
                        body: JSON.stringify({
                            'vetitesid':id,
                            'datum':mezo1,
                            'ido':mezo2                                
                        })
                    });
                    adatok = await eredmeny.json();
                    if(adatok=='Sikeres művelet'){
                        window.location.href='vetitesek_admin.php';
                    }
                    else{
                        alert('Sikertelen művelet');
                    }
                }
                else{
                    alert('Töltse ki az összes mezőt!');
                }
            }


            window.addEventListener('load',betolt);
            document.getElementById('modositGomb').addEventListener('click',modositas);
        </script>
</body>
</html>

    