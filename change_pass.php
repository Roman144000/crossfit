<? require_once('header.php'); 
// change password
if (isset($_GET['hash']) && !empty($_GET['hash'])) {?>

<div class="cont form-wrapper">

    <h2>Введите новый пароль</h2>

    <form action="" method="post" class="form">
        <input type="hidden" name="change_pass">

        <label>
            <input class="input" type="password" name="password" placeholder="Пароль*">
        </label>

        <label>
            <input class="input" type="password" name="password2" placeholder="Пароль еще раз*">
        </label>

        <div class="button-wrap">
            <input type="submit" class="button" value="Изменить пароль">
        </div>
    </form>
    
</div>

<?} else {?>

<div class="cont form-wrapper">

    <h2>Восстановление пароля</h2>

    <form action="" method="post" class="form">
        <input type="hidden" name="forget">

        <label>
            <input class="input" type="email" name="email" placeholder="Email">
        </label>

        <div class="button-wrap">
            <input type="submit" class="button" value="Восстановить пароль">
        </div>
    </form>
    
</div>

<?
}

require_once('footer.php');

if (isset($_POST['forget']) && isset($_POST['email']) && !empty($_POST['email'])) {

    include_once('assets/db.php');

    $email = $_POST['email'];

    $user = $db->getRow("SELECT * FROM athletes WHERE email = ?s", $email);

    if ($user !== null) {
        $salt = $db->getOne("SELECT salt FROM athletes WHERE email = ?s", $email);

        $hash = md5($salt . $email);
    
        $query = $db->query(
            "INSERT INTO athletes_hash SET email=?s, hash=?s",
            $email,
            $hash
        );
    
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <no-reply@fit.loc>\r\n";
    
        $message = '
                <html>
                <head>
                <title>Изменение пароля</title>
                </head>
                <body>
                <p>
                    <a href="http://fit.loc/change_pass.php?hash=' . $hash . '&email='.$email.'">
                        Заменить пароль
                    </a>
                </p>
                </body>
                </html>
                ';
        
        if (mail($email, "Изменение пароля", $message, $headers)) {
            echo 'Вам на почту отправлено письмо, пройдите по ссылке в этом письме';
        }
    } else {
        echo 'Такой почты не существует';
        die();
    }

}

if (isset($_POST['change_pass']) && isset($_GET['hash']) && !empty($_GET['hash'])) {
    if (!empty($_POST['password']) && !empty($_POST['password2']) && ($_POST['password'] === $_POST['password2'])) {

        include_once('assets/db.php');

        $password = $_POST['password'];

        $email = $_GET['email'];

        function generateSalt() {
            $salt = '';
            $length = rand(5,10);
            for($i=0; $i<$length; $i++) {
                $salt .= chr(rand(33,126));
            }
            return $salt;
        }

        $salt = generateSalt();

        $password = md5(md5($password) . $salt);

        $query = $db->query(
            "UPDATE athletes SET password=?s, salt=?s WHERE email = ?s",
            $password,
            $salt,
            $email
        );

        $query = $db->query("DELETE FROM athletes_hash WHERE email=?s", $email);

        header("Location: https://".$_SERVER['HTTP_HOST']);

        die();
    } else {
        echo 'Пароли не совпадают';
    }
}

die();