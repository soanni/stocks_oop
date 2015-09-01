<?php
    session_name('stockLogin');
    session_start();
    if(!isset($_SESSION['id'])){
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-86400, '/');
        }
        session_destroy();
    }

    $redirect = 'index.php';

    if(isset($_POST['submit']) && $_POST['submit'] == 'Register'){
        $username = trim($_POST['signup']);
        $password = trim($_POST['password']);
        $retyped = trim($_POST['retyped']);
        $email = trim($_POST['email']);
        require_once('helpers/register_user_db.inc.php');
    }
    if(isset($_POST['submit']) && $_POST['submit'] == 'Login'){
        session_name('stockLogin');
        session_start();
        $username = trim($_POST['log']);
        $pwd = trim($_POST['pwd']);
        $rememberMe = isset($_POST['rememberme']);
        require_once('helpers/authenticate_db.inc.php');
    }

    if(isset($_GET['logoff']))
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-86400, '/');
        }
        session_destroy();
        header("Location: $redirect");
        exit;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Stock Exchanges Management System</title>
        <meta charset="utf-8"/>
        <!--<link rel="stylesheet" href="css/stylee.css" type="text/css"/>-->
        <link rel="stylesheet" href="css/slide.css" type="text/css"/>
        <link href = "css/style.css" rel = "stylesheet" type = "text/css"/>
        <link href = "css/960.css" rel = "stylesheet" type = "text/css"/>
        <link href = "css/sunny/jquery-ui-1.8.17.custom.css" rel = "stylesheet" type = "text/css"/>
    </head>
    <body>
        <div id="toppanel">
            <div id="panel">
                <div class="content clearfix">
                    <?php if(!isset($_SESSION['id'])):?>
                        <div class="left">
                            <form class="clearfix" action="#" method="post">
                                <h1>Member Login</h1>
                                <label class="grey" for="log">Username:</label>
                                <input class="field" type="text" name="log" id="log" value="" size="23" />
                                <label class="grey" for="pwd">Password:</label>
                                <input class="field" type="password" name="pwd" id="pwd" size="23" />
                                <label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Remember me</label>
                                <div class="clear"></div>
                                <input type="submit" name="submit" value="Login" class="bt_login" />
                                <a class="lost-pwd" href="#">Lost your password?</a>
                            </form>
                        </div>
                        <div class="left right">
                            <form action="#" method="post">
                                <h1>Not a member yet? Sign Up!</h1>
                                <label class="grey" for="signup">Username:</label>
                                <input class="field" type="text" name="signup" id="signup" value="" size="23" />
                                <label class="grey" for="email">Email:</label>
                                <input class="field" type="email" name="email" id="email" size="23" />
                                <label class="grey" for="password">Password:</label>
                                <input class="field" type="password" name="password" id="password" size="23" />
                                <label class="grey" for="retyped">Retyped password:</label>
                                <input class="field" type="password" name="retyped" id="retyped" size="23" />
                                <input type="submit" name="submit" value="Register" class="bt_register" />
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="left">
                            <h1>Members panel</h1>
                            <p>You can put member-only data here</p>
                            <a href="registered.php">View a special member page</a>
                            <p>- or -</p>
                            <a href="?logoff">Log off</a>
                        </div>
                        <div class="left right">
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="tab">
                <ul class="login">
                    <li class="left">&nbsp;</li>
                    <li>Hello Guest!</li>
                    <li class="sep">|</li>
                    <li id="toggle">
                        <a id="open" class="open" href="#">Log In | Register</a>
                        <a id="close" style="display: none;" class="close" href="#">Close Panel</a>
                    </li>
                    <li class="right">&nbsp;</li>
                </ul>
            </div>
        </div>

        <div class="container_16">
            <?php
                if(isset($result) || isset($errors) || isset($error)){
                    echo '<ul>';
                    if(!empty($errors)){
                        foreach($errors as $item){
                            echo "<li>$item</li>";
                        }
                    }else{
                        echo "<li>$result</li>";
                    }
                    echo '</ul>';
                }
            ?>
            <h2>Welcome</h2>
            <div id="navigation" class="grid_5 suffix_1">
                <div>
                    <h3><a href = "#">Content management</a></h3>
                    <ul>
                        <li id = "exchange"><a href = "exchanges/">Exchanges</a></li>
                        <li id = "country"><a href = "countries/">Countries</a></li>
                        <li id = "currency"><a href = "currencies/">Currencies</a></li>
                        <li id = "company"><a href = "companies/">Companies</a></li>
                        <li id = "quote"><a href = "quotes/">Quotes</a></li>
                        <li id = "index"><a href = "indices/">Indices</a></li>
                        <li id = "rate"><a href = "rates/">Rates</a></li>
                    </ul>
                </div>
                <div>
                    <h3><a href = "#">Information</a></h3>
                    <ul>
                        <li><a href = "traders">Leading traders</a></li>
                        <li><a href = "working_hours">Current working exchanges worldwide</a></li>
                    </ul>
                </div>
                <div>
                    <h3><a href = "#">Public section</a></h3>
                    <ul>
                        <li><a href = "indicators">Indicators</a></li>
                        <li><a href = "charts">Charts</a></li>
                    </ul>
                </div>

                <div>
                    <h3><a href = "#">Restricted area</a></h3>
                    <ul>
                        <li><a href = "dashboard">Dashboard</a></li>
                    </ul>
                </div>
            </div>

            <div id="exchanges" class="grid_10">
                <ul>
                    <li><a href = "micex.php?ind=1">RTSSTD</a></li>
                    <li><a href = "micex.php?ind=2">MICEX</a></li>
                </ul>
            </div>
            <?php
                if(isset($_SESSION['id'])){
                // portfolio output
                }
            ?>
         </div>

        <script src="js/jquery-1.7.1.min.js" type="text/javascript" ></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.17.custom.min.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
    </body>
</html>