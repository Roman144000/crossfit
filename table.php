<?
session_start();
if (!isset($_SESSION['user'])) die();
$array_key  = array(
    'front_squad' => 'Фронтальный присед',
    'dead_lift'   => 'Становая тяга',
    'squad'       => 'Присед',
    'bench_press' => 'Жим лежа',
    'jerk'        => 'Рывок',
    'push'        => 'Толчок'
);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OurResults</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
</head>
<body>

<div id="main">

    <header class="header cont">
        <div class="header__logo img-contain"><img src="assets/img/logo.png" alt="logo"></div>
    </header>



    <div class="content cont">

        <div class="hello">Привет, <?=$_SESSION['user']['name']?></div>

        <div class="result">
            <div class="result__str">
                <div class="result__str-head"></div>
                <div class="result__str-head">5 x 5</div>
                <div class="result__str-head">5 x 10</div>
                <div class="result__str-head">5 x 15</div>
                <div class="result__str-head">max</div>
            </div>
            <?
                $result = $_SESSION['result'];

                foreach ($result as $key => $item) {?>
                    <div class="result__str">
                        <div class="str__name"><?=$array_key[$key]?></div>
                    
                <?
                    foreach ($item as $k => $i) {
                        if ($k != 'email') {?>
                            <div class="str__value"><a data-fancybox href="#change-value" data-table="<?=$key?>" data-column="<?=$k?>"><?=($i === null) ? 'Нет данных' : $i?></a></div>
                        <?
                        }
                    }
                    echo '</div>';
                }
            ?>
                    
        </div>
    </div>
    <div id="ajax-content" class="cont"></div>

    <footer class="footer cont">
        <div class="footer__date"><?=date('Y')?></div>
        <div class="footer__dev"><a href="mailto:work4roman@gmail.com">Разработчик: work4roman@gmail.com</a></div>
    </footer>

</div>

<div class="modal-change-value" id="change-value" style="display:none;">
    <form>
        <input type="hidden" name="change">
        <input type="hidden" name="table">
        <input type="hidden" name="column">
        <input type="hidden" name="user" value="<?=$_SESSION['user']['email']?>">

        <label>
            <input class="input" type="text" name="value" placeholder="Новое значение">
        </label>
        <div>
            <input class="button" type="submit" value="Сделано!">
        </div>
    </form>
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>