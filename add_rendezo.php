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
    <title>Rendező hozzáadása</title>
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
    <h2 class="voltaire-regular">Új rendező hozzáadása</h2>
    <table class="table">
        <tr>
            <td>Név</td>
            <td><input type="text" id="nevMezo"></td>
        </tr>
    </table>
    <input type="button" class="btn btn-secondary" id="mentGomb" value="Mentés">
    </div></div>
    <?php include './footer.php'; ?>
    <script>

        async function mar_letezik(){
            try{
                let rendNev = document.getElementById('nevMezo').value;
                let eredmeny = await fetch('class/index.class.php/admin_rendezo_mar_letezike',{
                    method : 'POST',
                    body: JSON.stringify({
                        'rendezonev': rendNev
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
            catch(error){
                console.log(error);
            }
            
        }

        function helytelen_kitoltes(){
            let mezo1 = document.getElementById('nevMezo').value;
            if (mezo1!='') {
                return false;
            } else {
                return true;
            }
        }

        async function mentes(){
            try{
                if(helytelen_kitoltes()==false){
                    if(await mar_letezik()==false){
                        let mezo1 = document.getElementById('nevMezo').value;
                        let eredmeny = await fetch('class/index.class.php/admin_ujrendezo', {
                            method : 'POST',
                            body: JSON.stringify({
                                'rendezonev': mezo1
                            })
                        });
                        adatok = await eredmeny.json();
                        if(adatok=='Sikeres művelet'){
                            window.location.href='movies_admin.php';
                        }
                    }
                    else{
                        alert('Ilyen nevű rendező már van!');
                    }
                }
                else{
                    alert('Töltsön ki minden mezőt!');
                }
            }
            catch(error){
                console.log(error);
            }
        }

        document.getElementById('mentGomb').addEventListener('click',mentes);
    </script>
</body>