<?php
session_start(); //Session should be active

$app_id             = '1561113514156663';  //Facebook App ID
$app_secret         = '3d45badd58f6bd043c1e6c7e2843cee6'; //Facebook App Secret
$required_scope     = 'public_profile, publish_actions, email'; //Permissions required
$redirect_url       = 'http://localhost/connect.php'; //FB redirects to this page with a code

//include autoload.php from SDK folder, just point to the file like this:
require_once __DIR__ . "/facebook-php-sdk-v4-4.0-dev/autoload.php";

//import required class to the current scope
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRedirectLoginHelper;

FacebookSession::setDefaultApplication($app_id , $app_secret);
$helper = new FacebookRedirectLoginHelper($redirect_url);

//try to get current user session
try {
  $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
    die(" Error : " . $ex->getMessage());
} catch(\Exception $ex) {
    die(" Error : " . $ex->getMessage());
}

if ($session){ //if we have the FB session
    $user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
    //do stuff below, save user info to database etc.
    
    echo '<pre>';
    print_r($user_profile); //Or just print all user details
    echo '</pre>';
    
}else{ 

    //display login url 
    $login_url = $helper->getLoginUrl( array( 'scope' => $required_scope ) );
    echo '<a href="'.$login_url.'">Login with Facebook</a>'; 
}
?>