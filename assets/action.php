<?

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include_once('db.php');

if (isset($_POST['register'])) {

    if (!empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['email'])) {

        if (strlen($_POST['password'])<=20 && strlen($_POST['name'])<=20 && strlen($_POST['email'])<=30) {

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

                $query = $db->query("INSERT INTO squad SET email=?s", $email);
                $query = $db->query("INSERT INTO dead_lift SET email=?s", $email);
                $query = $db->query("INSERT INTO bench_press SET email=?s", $email);
                $query = $db->query("INSERT INTO front_squad SET email=?s", $email);
                $query = $db->query("INSERT INTO jerk SET email=?s", $email);
                $query = $db->query("INSERT INTO push SET email=?s", $email);

            	header("Location: https://".$_SERVER['HTTP_HOST']."/table.php");
                session_start();
                $user = $db->getRow("SELECT * FROM athletes WHERE email = ?s", $_POST['email']);
                $_SESSION['user'] = $user;
                $_SESSION['result']['squad'] = $db->getRow("SELECT * FROM squad WHERE email = ?s", $_SESSION['user']['email']);
                $_SESSION['result']['dead_lift'] = $db->getRow("SELECT * FROM dead_lift WHERE email = ?s", $_SESSION['user']['email']);
                $_SESSION['result']['bench_press'] = $db->getRow("SELECT * FROM bench_press WHERE email = ?s", $_SESSION['user']['email']);
                $_SESSION['result']['front_squad'] = $db->getRow("SELECT * FROM front_squad WHERE email = ?s", $_SESSION['user']['email']);
                $_SESSION['result']['jerk'] = $db->getRow("SELECT * FROM jerk WHERE email = ?s", $_SESSION['user']['email']);
                $_SESSION['result']['push'] = $db->getRow("SELECT * FROM push WHERE email = ?s", $_SESSION['user']['email']);

            } else {
                echo 'Пользователь с таким почтовым ящиком уже существует';
            }
        } else {
            echo 'Слишком длинный запрос';
        }
    } else {
        echo 'Все поля обязательны к заполнению';
    }
}

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        if (strlen($_POST['email'])<=30 && strlen($_POST['password'])<=20) {
            $user = $db->getRow("SELECT * FROM athletes WHERE email = ?s", $_POST['email']);

            if ($user) {
                if (md5(md5($_POST['password']) . $user['salt']) === $user['password']) {
                    header("Location: https://".$_SERVER['HTTP_HOST'] . '/table.php');
                    session_start();
                    $_SESSION['user'] = $user;
                    $_SESSION['result']['squad'] = $db->getRow("SELECT * FROM squad WHERE email = ?s", $_SESSION['user']['email']);
                    $_SESSION['result']['dead_lift'] = $db->getRow("SELECT * FROM dead_lift WHERE email = ?s", $_SESSION['user']['email']);
                    $_SESSION['result']['bench_press'] = $db->getRow("SELECT * FROM bench_press WHERE email = ?s", $_SESSION['user']['email']);
                    $_SESSION['result']['front_squad'] = $db->getRow("SELECT * FROM front_squad WHERE email = ?s", $_SESSION['user']['email']);
                    $_SESSION['result']['jerk'] = $db->getRow("SELECT * FROM jerk WHERE email = ?s", $_SESSION['user']['email']);
                    $_SESSION['result']['push'] = $db->getRow("SELECT * FROM push WHERE email = ?s", $_SESSION['user']['email']);
                } else {
                    echo 'Неправильный Email или пароль';
                }
            } else {
                echo 'Неправильный Email или пароль';
            }
        } else {
            echo 'Слишком длинный запрос';
        }
    } else {
        echo 'Заполните все поля';
    }
}

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
            echo "Вы ввели некорректное значение";
        }
    }
}

