<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Voltaire&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="./logo/favicon.jpg">
    <title>Bejelentkezés</title>

    <style>
        body {
            background-color: #e3dd81;
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
            background-color: #929292;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #e3dd81;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #929292;
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
    </style>
</head>

<body>
    <form method="post">
        <h3 class="voltaire-regular">Bejelentkezés</h3>
        <input type="email" name="email" placeholder="Email cím">
        <input type="password" name="password" placeholder="Jelszó">
        <input type="submit" name="button_login" value="Bejelentkezés">
        <p><a href="register.php">Regisztráció</a></p>
        <?php
        include './mozi.class.php';
        include './adatbazis.class.php';

        if (isset($_POST['button_login'])) {
            if (empty($_POST['email']) || empty($_POST['password'])) {
                echo '<div class="error">Kérem töltse ki a megadott mezőket!</div>';
            } else {
                $mozi = new Mozi();
                $login_data = $mozi->login($_POST['email']);
                if (is_array($login_data)) {
                    session_start();
                    foreach ($login_data as $x) {
                        if (hash('sha256', $_POST['password']) === $x['jelszo']) {
                            if ($x['admin'] == 0) {
                                $_SESSION['user_id'] = $x['id'];
                                $_SESSION['user_name'] = $x['nev'];
                                $_SESSION['user_email'] = $x['email'];
                                header('location:home.php');
                            } else {
                                $_SESSION['admin_id'] = $x['id'];
                                $_SESSION['admin_name'] = $x['nev'];
                                $_SESSION['admin_email'] = $x['email'];
                                header('location:home_admin.php');
                            }
                        } else {
                            echo '<div class="error">Hibás jelszó!</div>';
                        }
                    }
                } else {
                    echo '<div class="error">Hibás email cím vagy jelszó!</div>';
                }
            }
        }
        ?>
    </form>
</body>

</html>
