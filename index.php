<? require_once('header.php'); ?>
<!-- login form -->
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

        <span class="forget"><a href="change_pass.php">Забыли пароль?</a></span>

        <div class="button-wrap">
            <input type="submit" class="button" value="Жми!">
        </div>
    </form>
    
</div>
<!-- registration form -->
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
            <input class="input" type="password" name="password2" placeholder="Пароль еще раз*">
        </label>

        <label>
            <input class="input" type="text" name="name" placeholder="Ваше имя*">
        </label>

        <div class="button-wrap">
            <input type="submit" class="button" value="Жми!">
        </div>
    </form>
</div>
<? require_once('footer.php'); ?>