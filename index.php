<?php   
session_start();
require_once __DIR__ . '/vendor/autoload.php';

function takeUserName($email) 
{
    $result = "";
    for ($i = 0; $i < strlen($email); $i++) {
        if ($email[$i] != '@') {
            $result .= $email[$i];
        } else {
            break;
        }
    }
    return $result;
}

$client_id = '667087743943-59761k24ipapitsinj392vppgftvq5mb.apps.googleusercontent.com'; 
$client_secret = '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';
$redirect_uri = 'http://localhost:8080/index.php';
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

$dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $user = $service->userinfo->get();
    $stmt1 = $dbh->prepare('SELECT * FROM users WHERE id_email = :id_email');
    $stmt1->bindParam(':id_email', $user->id);
    $stmt1->execute();
    $row = $stmt1->fetch();
    $array = [
        'id_email' => $user->id,
        'gmail' => $user->email
    ];
    if (empty($row)) {
        $stmt = $dbh->prepare('INSERT INTO users(id_email, gmail, username, avatar) VALUES (:id_email, :gmail, :username, :avatar)');
        $stmt->bindParam(':id_email', $user->id);
        $stmt->bindParam(':gmail', $user->email);
        $stmt->bindParam(':username', takeUserName($user->email));
        $stmt->bindParam(':avatar', $user->picture);
        $stmt->execute();
        $array['fullname'] = "";
        $array['follow_number'] = 0;
        $array['avatar'] = $user->picture;
        $array['username'] = takeUserName($user->email);
    } else {
        $stmt = $dbh->prepare('SELECT follow_number, fullname, avatar, username FROM users WHERE id_email = :id_email');
        $stmt->bindParam(':id_email', $user->id);
        $stmt->execute();
        $res = $stmt->fetch();
        $array['follow_number'] =  (int)$res['follow_number'];
        $array['fullname'] =  $res['fullname'] == NULL ? "" : $res['fullname'];
        $array['avatar'] = $res['avatar'];
        $array['username'] = $res['username'];  
    }
    $_SESSION['user'] = $array;
    // echo $_SESSION['user']['id_email'];
}

if (!empty($_POST['submit-setting-account'])) {
    $fullname = $_POST['setting-fullname'];
    $username = $_POST['setting-username'];
    $stmt = $dbh->prepare('UPDATE users SET fullname = :fullname, username = :username WHERE id_email = :id_email');
    $stmt->bindParam(':id_email', $_SESSION['user']['id_email']);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $_SESSION['user']['fullname'] = $fullname;
    $_SESSION['user']['username'] = $username;
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.4.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.core.css">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <title>My Blogger</title>
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="header__left">
                <div class="my__blog" onclick="chooseHeader(this)">
                    <i class="my__blog-icon fa-solid fa-blog"></i>
                    Blog của tôi
                </div>
                <div class="home__page header__left-choose" onclick="chooseHeader(this)">
                    <i class="home__page-icon fa-solid fa-newspaper"></i>
                    Đọc
                </div>
            </div>
            <div class="header__right">
                <div class="create__post" onclick="chooseHeader(this)">
                    <i class="create__post-icon fa-solid fa-feather"></i>
                    Viết bài
                </div>
                <div class="personal__info" onclick="chooseHeader(this)">
                    <?php 
                    echo '<img src="' . $_SESSION['user']['avatar'] . '" alt="" class="personal__info-img">';
                    ?>
                </div>
            </div>
        </header>

        <div class="slidebar"></div>
        
        <div class="container"></div>
    </div>

    <?php 
        require_once __DIR__ . '/assets/js/main.php';
    ?>
</body>
</html>