<?php

# База данных с паролями
# В реальности пароли НИКОГДА не сохраняются простым текстом
$database = [
    'admin' => 'root',
    'user' => 'dummy',
];

session_start();

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

    if (!isset($database[$unameFromInput]) || $database[$unameFromInput] !== $pwdFromInput) {
        $_SESSION['errors'][] = "username or password invalid!";
    }

    if (empty($_SESSION['errors'])) {
        # изменить айди сессии - для безопасности
        # а также уничтожь предыдущую сессию (это не обязательно)
        session_regenerate_id();
        $_SESSION['identity'] = $unameFromInput;
        header('Location: /');
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