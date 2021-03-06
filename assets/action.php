<?
// include database
include_once('db.php');

// register script
if (isset($_POST['register'])) {

    if (!empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password2'])) {

        if ($_POST['password'] === $_POST['password2']) {

            if (strlen($_POST['password'])<=20 && strlen($_POST['password2'])<=20 && strlen($_POST['name'])<=20 && strlen($_POST['email'])<=30) {

                $already_register = $db->getRow("SELECT * FROM athletes WHERE email = ?s", $_POST['email']);

                if ($already_register === NULL) {

                    $password = $_POST['password'];
                    $name = $_POST['name'];
                    $email = $_POST['email'];

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
                        "INSERT INTO athletes SET password=?s, name=?s, email=?s, salt=?s",
                        $password,
                        $name,
                        $email,
                        $salt
                    );

                    $time = $db->getOne("SELECT time FROM athletes WHERE email = ?s", $email);

                    $hash = md5($name . $time);

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
                            <title>?????????????????????? Email</title>
                            </head>
                            <body>
                            <p>
                                <a href="http://fit.loc/confirm.php?hash=' . $hash . '">
                                    ?????????????????????? Email
                                </a>
                            </p>
                            </body>
                            </html>
                            ';
                    
                    if (mail($email, "?????????????????????? Email ???? ??????????", $message, $headers)) {
                        echo '?????? ???? ?????????? ???????????????????? ????????????, ???????????????? ???? ???????????? ?? ???????? ????????????';
                    }

                } else {
                    echo '???????????????????????? ?? ?????????? ???????????????? ???????????? ?????? ????????????????????';
                }
            } else {
                echo '?????????????? ?????????????? ????????????';
            }
        } else {
            echo '???????????? ???? ??????????????????';
        }
    } else {
        echo '???? ?????? ???????? ??????????????????';
    }
}

// login script
if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        if (strlen($_POST['email'])<=30 && strlen($_POST['password'])<=20) {
            $user = $db->getRow("SELECT * FROM athletes WHERE email = ?s", $_POST['email']);

            if ($user) {
                if (md5(md5($_POST['password']) . $user['salt']) === $user['password']) {
                    if ($user['confirm']){
                        header("Location: https://".$_SERVER['HTTP_HOST'] . '/table.php');
                        session_start();
                        $_SESSION['user'] = $user;
                        $_SESSION['result']['squad'] = $db->getRow("SELECT * FROM squad WHERE email = ?s", $_SESSION['user']['email']);
                        $_SESSION['result']['dead_lift'] = $db->getRow("SELECT * FROM dead_lift WHERE email = ?s", $_SESSION['user']['email']);
                        $_SESSION['result']['bench_press'] = $db->getRow("SELECT * FROM bench_press WHERE email = ?s", $_SESSION['user']['email']);
                        $_SESSION['result']['front_squad'] = $db->getRow("SELECT * FROM front_squad WHERE email = ?s", $_SESSION['user']['email']);
                        $_SESSION['result']['jerk'] = $db->getRow("SELECT * FROM jerk WHERE email = ?s", $_SESSION['user']['email']);
                        $_SESSION['result']['push'] = $db->getRow("SELECT * FROM push WHERE email = ?s", $_SESSION['user']['email']);

                        $_SESSION['user']['admin'] = $db->getOne("SELECT is_admin FROM athletes WHERE email = ?s", $_POST['email']);
                    } else {
                        echo '?????????????????????? ??????????';
                    }
                } else {
                    echo '???????????????????????? Email ?????? ????????????';
                }
            } else {
                echo '???????????????????????? Email ?????? ????????????';
            }
        } else {
            echo '?????????????? ?????????????? ????????????';
        }
    } else {
        echo '?????????????????? ?????? ????????';
    }
}

// change value in result table
if (isset($_POST['change'])) {
    if (!empty($_POST['column']) && !empty($_POST['table']) && !empty($_POST['value'])) {
        $value = $_POST['value'];
        $table = $_POST['table'];
        $column = $_POST['column'];

        if (is_numeric($value)) {
            $change = $db->query("UPDATE ?n SET ?n = ?s WHERE email = ?s", $table, $column, $value, $_POST['user']);
            session_start();
            $_SESSION['result'][$table][$column] = $value;
            echo $value;
        } else {
            echo "???? ?????????? ???????????????????????? ????????????????";
        }
    }
}

