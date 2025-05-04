<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Voltaire&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./logo/favicon.jpg">
    <title>Regisztráció</title>

    <style>
        body {
            background-color: #929292;
            font-family: 'PT Sans Narrow', sans-serif;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }

        h3 {
            color: #4f4d2d;
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #e3dd81;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #d0c75f;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #e3dd81;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <form method="post">
        <h3 class="voltaire-regular">Regisztráció</h3>
        <input type="text" name="name" placeholder="Teljes név"><br>
        <input type="email" name="email" placeholder="Email cím"><br>
        <input type="password" name="password" placeholder="Jelszó"><br>
        <input type="password" name="password_check" placeholder="Jelszó újra"><br>
        <input type="submit" name="button_reg" value="Regisztráció"><br>
        <p><a href="login.php">Bejelentkezés</a></p>
        <p id="visszajelzes">
        <?php
        include './adatbazis.class.php';
        include './mozi.class.php';

        if (isset($_POST['button_reg'])) {
            if (empty($_POST['name']) || empty($_POST['password']) || empty($_POST['password_check']) || empty($_POST['email'])) {
                echo '<span class="error">Kérem töltse ki a megadott mezőket!</span>';
            } else {
                $error = 0;
                if (!strpos($_POST['name'], ' ')) {
                    echo '<span class="error">A teljes nevét adja meg!<br></span>';
                    $error++;
                }
                if ($_POST['password'] != $_POST['password_check']) {
                    echo '<span class="error">A megadott jelszavak nem egyeznek!<br></span>';
                    $error++;
                }
                if (strlen($_POST['password']) < 8) {
                    echo '<span class="error">A jelszó hossza minimum 8 karakter!<br></span>';
                    $error++;
                }

                if ($error == 0) {
                    $mozi = new Mozi();

                    $check = $mozi->email_check($_POST['email']);
                    if ($check == 'Nincs találat') {
                        $new_user = $mozi->register($_POST['name'], $_POST['email'], $_POST['password']);
                        
                        if($new_user=='Sikeres művelet'){
                            echo '<span class="success">Sikeres regisztráció!</span>';
                        }
                    } else {
                        echo '<span class="error">Ezzel az email címmel már létezik felhasználó!</span>';
                    }
                }
            }
        }
        ?>
        </p></form>
</body>

</html>
