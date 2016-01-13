<?php
    require_once('db_new.inc.php');
    $sql = "SELECT userid,salt,pass FROM users WHERE username = :usr";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usr',$username,PDO::PARAM_STR);
    $stmt->bindColumn(1,$userid);
    $stmt->bindColumn(2,$salt);
    $stmt->bindColumn(3,$pass);
    $stmt->execute();
    $stmt->fetch();
    if(sha1($pwd . $salt) == $pass){
        $_SESSION['authenticated'] = $username;
        $_SESSION['id'] = $userid;
        $_SESSION['rememberme'] = $rememberMe;
        session_regenerate_id();
        header("Location: $redirect");
        exit;
    }else{
        $result = 'Incorrect username (or) password submitted';
    }
