<?
session_start();
if (!isset($_SESSION['user'])) die();

// array with title for table
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

    <div class="result">
        <div class="result__str">
            <div class="result__str-head"></div>
            <div class="result__str-head">5 x 5</div>
            <div class="result__str-head">5 x 10</div>
            <div class="result__str-head">5 x 15</div>
            <div class="result__str-head">max</div>
        </div>
        <? //table with result
            $result = $_SESSION['result'];

            foreach ($result as $key => $item) {?>
                <div class="result__str">
                    <div class="str__name"><?=$array_key[$key]?></div>
                
            <?
                foreach ($item as $k => $i) {
                    if ($k !== 'email') {?>
                        <div class="str__value"><a data-hystmodal="#change-value" href="#" data-table="<?=$key?>" data-column="<?=$k?>"><?=($i === null) ? 'Нет данных' : $i?></a></div>
                    <?
                    }
                }
                echo '</div>';
            }
        ?>
                
    </div>
</div>
<!-- modal form for change value in table -->
<div class="hystmodal" id="change-value" aria-hidden="true">
    <div class="hystmodal__wrap">
        <div class="hystmodal__window" role="dialog" aria-modal="true">
            <button data-hystclose class="hystmodal__close">Закрыть</button>
            <form class="form">
                <input type="hidden" name="change">
                <input type="hidden" name="table">
                <input type="hidden" name="column">
                <input type="hidden" name="user" value="<?=$_SESSION['user']['email']?>">

                <label>
                    <input class="input" type="text" name="value" placeholder="Новое значение">
                </label>
                <div class="btn-wrap">
                    <input class="button" type="submit" value="Сделано!">
                </div>
            </form>
        </div>
    </div>
</div>

<? require_once('footer.php'); ?>