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



    <div id="login" class="cont form-wrapper">

        <h2>Авторизация</h2>

        <form action="assets/action.php" method="post" class="form">

            <input type="hidden" name="login">

            <label>
                <input class="input" type="email" name="email" placeholder="Email">
            </label>

            <label>
                <input class="input" type="password" name="password" placeholder="Пароль">
            </label>

            <div class="button-wrap">
                <input type="submit" class="button" value="Жми!">
            </div>
        </form>
        
    </div>

    <div id="registration" class="cont form-wrapper">

        <h2>Регистрация</h2>

        <form action="assets/action.php" method="post" class="form">

            <input type="hidden" name="register">

            <label>
                <input class="input" type="email" name="email" placeholder="Email*">
            </label>

            <label>
                <input class="input" type="password" name="password" placeholder="Пароль*">
            </label>

            <label>
                <input class="input" type="text" name="name" placeholder="Ваше имя*">
            </label>

            <div class="button-wrap">
                <input type="submit" class="button" value="Жми!">
            </div>
        </form>
    </div>






    <footer class="footer cont">
        <div class="footer__date"><?=date('Y')?></div>
        <div class="footer__dev"><a href="mailto:work4roman@gmail.com">Разработчик: work4roman@gmail.com</a></div>
    </footer>

</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>