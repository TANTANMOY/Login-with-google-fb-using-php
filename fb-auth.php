<?php 


require_once 'vendor/autoload.php';


$fb = new Facebook\Facebook([
    'app_id' => 'xxxxxxxxxxxxxx',
    'app_secret' => 'xxxxxxxxxxxxxxxxxxxxxxx',
    'default_graph_version' => 'v2.10'
]);

$helper = $fb->getRedirectLoginHelper();
$login_url = $helper->getLoginUrl("http://localhost/login/");

try{
    $accessToken = $helper->getAccessToken();
    if(isset($accessToken)){
        $_SESSION['access_token'] = (string)$accessToken;

        // if sessign is set then redirect to the user to landing page
        header("Location:index.php");
    }
}catch (Exception $exc){
    echo $exc->getTraceAsString();
}




?>