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

require_once('header.php');
?>

<div class="content cont">

    <div class="hello">Привет, <?=$_SESSION['user']['name']?></div>

    <div><?echo $_SESSION['user']['admin'] ? 'У вас есть права администратора' : 'У вас нет прав администратора' ?></div>

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
                    if ($k !== 'email') {?>
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

<? require_once('footer.php'); ?>