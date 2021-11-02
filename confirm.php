<?php
// include database
include_once('assets/db.php');

// script for confirm email
if (!empty($_GET['hash'])) {
    $hash = $_GET['hash'];
    $exist_user = $db->getRow("SELECT * FROM athletes_hash WHERE hash = ?s", $hash);
    if ($exist_user !== NULL) {

        $email = $exist_user['email'];
        $change = $db->query("UPDATE athletes SET confirm = 1 WHERE email = ?s", $email);

        $query = $db->query("INSERT INTO squad SET email=?s", $email);
        $query = $db->query("INSERT INTO dead_lift SET email=?s", $email);
        $query = $db->query("INSERT INTO bench_press SET email=?s", $email);
        $query = $db->query("INSERT INTO front_squad SET email=?s", $email);
        $query = $db->query("INSERT INTO jerk SET email=?s", $email);
        $query = $db->query("INSERT INTO push SET email=?s", $email);

        header("Location: https://".$_SERVER['HTTP_HOST']."/table.php");
        session_start();
        $user = $db->getRow("SELECT * FROM athletes WHERE email = ?s", $email);
        $_SESSION['user'] = $user;
        $_SESSION['result']['squad'] = $db->getRow("SELECT * FROM squad WHERE email = ?s", $email);
        $_SESSION['result']['dead_lift'] = $db->getRow("SELECT * FROM dead_lift WHERE email = ?s", $email);
        $_SESSION['result']['bench_press'] = $db->getRow("SELECT * FROM bench_press WHERE email = ?s", $email);
        $_SESSION['result']['front_squad'] = $db->getRow("SELECT * FROM front_squad WHERE email = ?s", $email);
        $_SESSION['result']['jerk'] = $db->getRow("SELECT * FROM jerk WHERE email = ?s", $email);
        $_SESSION['result']['push'] = $db->getRow("SELECT * FROM push WHERE email = ?s", $email);

        $query = $db->query("DELETE FROM athletes_hash WHERE email=?s", $email);
    } else {
        header("Location: https://".$_SERVER['HTTP_HOST']);
        die();
    }
} else {
    header("Location: https://".$_SERVER['HTTP_HOST']);
    
}
die();