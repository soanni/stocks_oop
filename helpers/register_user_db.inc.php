<?php
    require_once(__DIR__.'/../classes/CheckPassword.php');
    $usernameMinChars = 6;
    $errors = array();
    if(strlen($username) < $usernameMinChars){
        $errors[] = "Username must be minimum $usernameMinChars characters length";
    }
    if(preg_match('/\s/',$username)){
        $errors[] = "Username must not contain spaces";
    }

    $checkPwd = new CheckPassword($password);
    $checkPwd->requireMixedCase();
    $checkPwd->requireNumbers(1);
    //$checkPwd->requireSymbols();
    $passwordOK = $checkPwd->check();
    if(!$passwordOK){
        $errors = array_merge($errors,$checkPwd->getErrors());
    }

    if($password != $retyped){
        $errors[] = "Your passwords don't match";
    }
    if(!$errors){
        require_once(__DIR__.'/db_new.inc.php');
        $salt = time();
        $pwd = sha1($password . $salt);
        try{
            $sql = "INSERT INTO users (username,email,pass,salt) VALUES(:username,:email,:pass,:salt)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username',$username,PDO::PARAM_STR);
            $stmt->bindParam(':salt',$salt,PDO::PARAM_INT);
            $stmt->bindParam(':pass',$pwd,PDO::PARAM_STR);
            $stmt->bindParam(':email',$email,PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $e){
            if($stmt->errorCode() == 23000){
                $errors[] = "$username is already in use. Please choose another username.";
            }else{
                $errors[] = "There is a problem with database.";
            }
        }

        if($stmt->rowCount() == 1){
            $result = "$username has been registered. You may now log in.";
        }
//        elseif($stmt->errorCode() == 23000){
//            $errors[] = "$username is already in use. Please choose another username.";
//        }else{
//            $errors[] = "There is a problem with database.";
//        }
    }