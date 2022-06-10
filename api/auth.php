<?php

global $user;

function __auth() {
    header('WWW-Authenticate: Basic realm="Login, please!"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Надо залогиниться';
    exit;
}

if (isset($_SESSION['my_user']) && (intval($_SESSION['my_user'])) ) {
    $user = true;
} else {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        __auth();
    } else {
        $users = explode("\n",file_get_contents('.users'));

        $logins = array();
        foreach($users as $user) {
            if (!empty($user)) {
                $u = explode(":", $user);
                $logins[$u[0]] = array(
                    "pass" => $u[1],
                    "access" => $u[2],
                );
            }
        }

        $login = $_SERVER['PHP_AUTH_USER'];
        $pass = md5 ( md5 ( $_SERVER['PHP_AUTH_PW'] ) );
        if ( isset($logins[$login]) && $logins[$login]['pass'] === $pass) {
            $_SESSION['my_user'] = 1;
            $_SESSION['access'] = $logins[$login]['access'];
            header("Location: ".$_SERVER['REQUEST_URI']);
        } else {
            __auth();
        }
    }
}

?>
