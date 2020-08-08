<?php
include('config.php');
require './fb-auth.php';


$login_button = '';

if(isset($_GET["code"]))
{
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if(!isset($token['error']))
    {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();
        if(!empty($data['given_name']))
        {
            $_SESSION['user_first_name'] = $data['give_name'];
        }
        if(!empty($data['family_name']))
        {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if(!empty($data['email']))
        {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if(!empty($_SESSION['gender']))
        {
            $_SESSION['user_gender'] = $data['gender'];
        }
     
    }
}

if(!isset($_SESSION['access_token']))
{
    $login_button = '<a href="'.$google_client->createAuthUrl().'">
    <button class="btn btn-secondary">
    <img src="https://img.icons8.com/color/48/000000/google-logo.png"/>Sign In with Google
    </button>
    </a>';
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">


<?php if(isset($_SESSION['access_token'])) : ?>
<a href="logout.php">Logout</a>
<?php else: ?>
    <a href="<?php echo $login_url;?>">Login with facebook</a>
    
  <?php    echo '<div align="center">'.$login_button . '</div>'; ?>

<?php endif;?>


</div>
</body>
</html>