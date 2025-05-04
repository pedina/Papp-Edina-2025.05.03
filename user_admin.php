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
    <title>Felhasználók kezelése</title>
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
    <h2 class="voltaire-regular">Felhasználók kezelése</h2>

    <?php
        $mozi = new Mozi();
        $users = $mozi->osszes_felhasznalo();
        if(is_array($users)){
           echo '           
           <div class="d-flex justify-content-center"><table class="table w-75 "><thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Név</th>
              <th scope="col">Email cím</th>
              <th scope="col"></th>
            </tr>
          </thead><tbody>';
            foreach($users as $x){
                echo '<tr><td>'.$x['id'].'</td><td>'.$x['nev'].'</td><td>'.$x['email'].'</td><td><input type="button" class="btn btn-secondary" id="'.$x['id'].'" value="Törlés" onclick="userTorles(this)"></td></tr>';
            }
            echo '</tbody></table></div>';
        }
        else{
            echo 'Nincs találat';
        }
    ?>
</div>
</div>

<?php include './footer.php'; ?>
<script>
        async function userTorles(elem){
            var jovahagyas = confirm("Ezzel törli a felhasználó adatait is. Biztosan törli?");

            if (jovahagyas == true) {
                let valaszok = [];
                let ellenorzes = await fetch('class/index.class.php/admin_user_foglal_ellenorzes', {
                    method : 'POST',
                    body: JSON.stringify({
                        'userid': elem.id
                    })
                });
                let valasz = await ellenorzes.json();

                if(valasz['valasz'] != 'Nincs talalat'){
                    let torles = await fetch('class/index.class.php/admin_user_foglalasok_torles', {
                        method : 'DELETE',
                        body: JSON.stringify({
                            'userid': elem.id
                        })
                    });
                    let data = await torles.json();
                    valaszok.push(data);
                }

                let torles2 = await fetch('class/index.class.php/admin_user_torles', {
                    method : 'DELETE',
                    body: JSON.stringify({
                        'userid': elem.id
                    })
                });

                let data2 = await torles2.json();
                valaszok.push(data2);

                var mindenTorlesSikeres = valaszok.every(torles => torles == 'Sikeres művelet');

                if (mindenTorlesSikeres) {
                    window.location.href='user_admin.php';
                } else {
                    alert('A törlés sikertelen');
                }
            }
        }
    </script>
</body>
</html>