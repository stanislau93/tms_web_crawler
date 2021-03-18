<?php

session_start();

const PEPPER = 'egorletov';

# Создаём уникальный токен, который не сможет угадать хакер
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$_SESSION['errors'] = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # проверяем правильность введённых данных
    # предположим, мы уже санировали и валидировали их

    $tokenFromInput = $_POST['csrf'];
    $unameFromInput = $_POST['uname'];
    $pwdFromInput = $_POST['pwd'];

    if (empty($tokenFromInput)) {
        $_SESSION['errors'][] = "csrf token missing!";
    } elseif (!hash_equals($tokenFromInput, $_SESSION['csrf_token'])) {
        $_SESSION['errors'][] = "csrf token invalid!";
    }

    if (empty($unameFromInput) || empty($pwdFromInput)) {
        $_SESSION['errors'][] = "username or password empty!";
    }

    if (empty($_SESSION['errors'])) {
        $usersTable = mb_substr(file_get_contents('users'),0,-1);

        $usersEntries = array_map(
            function (string $s) {
                $parts = explode(' ', $s);
                var_dump("P", $parts);
                return [
                    'username' => $parts[0],
                    'hash' => $parts[1],
                    'salt' => $parts[2],
                ];
            },
            explode(PHP_EOL, $usersTable)
        );

        foreach ($usersEntries as $entry) {
            if ($entry['username'] === $unameFromInput) {
                $fullPassword = $pwdFromInput.$entry['salt'].PEPPER;

                $passwordCorrect = password_verify($fullPassword, $entry['hash']);

                if ($passwordCorrect) {
                    session_regenerate_id();

                    $_SESSION['identity'] = $unameFromInput;

                    header('Location: /');
                    die();
                } else {
                    break;
                }
            }
        }

        $_SESSION['errors'][] = "username or password invalid!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>LogIn</title>
</head>

<body>
    <div class="wrapper">
        <div class="content">
            <h2>У Вас нет доступа к нашему <span>"Краулеру"</span></h2>
            <p>Чтобы получить доступ, войдите в свою учетную запись</p>

            <div class="wrapper-form">
                <form class="form" action="/login.php" method="POST">
                    <div class="wrapper-flex">
                        <div class="login">
                            <label for="uname">username</label><br>
                            <input type="text" id="uname" name="uname" placeholder="login: admin" />
                        </div>
                        <div class="password">
                            <label for="pwd">password</label><br>
                            <input type="password" id="pwd" name="pwd" placeholder="password: root" />
                        </div>
                    </div>
                    <input type="hidden" id="csrf" name="csrf" value="<?php echo $_SESSION['csrf_token'] ?>" />

                    <button class="btn" type="submit">LOG IN</button>
                </form>
                <br/>
                <a href="/register.php" class="btn_register">REGISTER</button>
            </div>

        </div>
    </div>

    <div class="errors">
        <?php
        if (!empty($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<p>$error</p>";
            }
        }
        ?>
    </div>
</body>

</html>