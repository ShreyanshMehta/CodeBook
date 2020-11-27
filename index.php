<?php

session_start();

require 'vendor/autoload.php';

$app = new \Slim\App();

$container = $app->getContainer();

$container['view'] = function($container){
    $view = new \Slim\Views\Twig('views', [
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    return $view;
};


//Routing the default page
$app->get('/', function($request, $response, $arg){
    require_once 'config.php';
    
    $Tags = array();
    
    $sql = "SELECT * FROM all_tags LIMIT 1000";
    $result = mysqli_query($conn, $sql);
    $rows = $result->fetch_all();

    $pt = 0;
    foreach($rows as $key => $val){
        $rows[$key][0] = ++$pt;
    }

    $arr = [
        'isLoggedin' => 0,
        'username' => '@',
        'tags' => $rows,
        'tlink' => 'problems?tag=',
        'private' => 0,
        'id' => 1
    ];

    //If user is logged in
    if(isset($_SESSION['user_id'])){
        $arr['isLoggedin'] = 1;
        $arr['username'] = $_SESSION['user_id'];
    }

    return $this->view->render($response, 'home.html', $arr);
});




//Routing the problem for selected tag
$app->get('/problems', function($request, $response, $arg){
    $tag = $request->getQueryParams()['tag'];

    require 'config.php';
    $sql = "SELECT * FROM questions WHERE tag='".$tag."'";

    $result = mysqli_query($conn, $sql);
    $rows = $result->fetch_all();

    $filteredQues = array();
    
    foreach($rows as $key => $val){
        $temp = array();
        array_push($temp, $val[0]);
        array_push($temp, $val[2]);
        array_push($temp, $val[3]);
        array_push($temp, $val[4]);
        array_push($temp, floor(($val[3]*10000)/$val[4])/100);
        array_push($filteredQues, $temp);
    }

    $arr = [
        'tag' => $tag, 
        'isLoggedin' => 0,
        'username' => '@',
        'problem' => $filteredQues,
        'id' => 0,
        'private' => 0,
        'qlink' => "https://www.codechef.com/problems/"
    ];

    //If user is logged in
    if(isset($_SESSION['user_id'])){
        $arr['isLoggedin'] = 1;
        $arr['username'] = $_SESSION['user_id'];
    }
    return $this->view->render($response, 'home.html', $arr);
});




//Routing the privateTags (only when user is logged in)
$app->get('/privateTag', function($request, $response, $arg){
    if(!isset($_SESSION['user_id'])){
        return $response->withStatus(401)->write("You are not authorised! Please login or signup to access it.");
    }   
    require_once 'config.php';
        
    $filteredTags = array();
    $cnt = array();
    
    $sql = "SELECT * FROM privatetags WHERE user_id='".$_SESSION['user_id']."'";
    $result = mysqli_query($conn, $sql);
    $rows = $result->fetch_all();

    foreach($rows as $key => $val){
        $cnt[$val[1]] = 0;
    }

    foreach($rows as $key => $val){
        $cnt[$val[1]]++;
    }

    $pt = 0;
    foreach($cnt as $key => $val){
        $temp = array();
        $temp[0] = ++$pt;
        $temp[1] = $key;
        $temp[2] = 'Private';
        $temp[3] = $val;
        array_push($filteredTags, $temp);
    }

    $arr = [
        'tags' => $filteredTags,
        'id' => 2,
        'private' => 1,
        'isLoggedin' => 1,
        'tlink' => 'privateTag/problems?tag=',
        'username' => $_SESSION['user_id']
    ];

    return $this->view->render($response, 'home.html', $arr);
});



//Routing problems for selected privateTag (only when user is logged in)
$app->get('/privateTag/problems', function($request, $response, $arg){
    $tag = $request->getQueryParams()['tag'];

    require 'config.php';
    $sql = "SELECT * FROM privatetags WHERE tag='".$tag."' AND user_id = '".$_SESSION['user_id']."'";

    $result = mysqli_query($conn, $sql);
    $rows = $result->fetch_all();

    $filteredQues = array();
    
    foreach($rows as $key => $val){
        $temp = array();
        array_push($temp, $val[2]);
        array_push($temp, $val[3]);
        array_push($temp, $val[4]);
        array_push($temp, $val[5]);
        array_push($temp, floor(($val[4]*10000)/$val[5])/100);
        array_push($filteredQues, $temp);
    }

    $arr = [
        'tag' => $tag, 
        'isLoggedin' => 1,
        'username' => $_SESSION['user_id'],
        'problem' => $filteredQues,
        'id' => 0,
        'private' => 1, 
        'qlink' => "https://www.codechef.com/problems/"
    ];

    return $this->view->render($response, 'home.html', $arr);
});



//Routing the logging page
$app->get('/login', function($request, $response, $arg){
    //Not accessible when user is logged in
    if(isset($_SESSION["user_id"])){
        return $response->withStatus(401)->write('Page is not available');
    }
    $arr = [
        'isLoggedin' => 0,
        'username' => '@'
    ];

    if(isset($_SESSION['user_id'])){
        $arr['isLoggedin'] = 1;
        $arr['username'] = $_SESSION['user_id'];
    }
    return $this->view->render($response, 'login.html', $arr);
});




//Routing the signup page
$app->get('/signup', function($request, $response, $arg){
    //Not accessible when user is logged in
    if(isset($_SESSION["user_id"])){
        return $response->withStatus(401)->write('Page is not available');
    }
    $arr = [
        'isLoggedin' => 0,
        'username' => '@'
    ];

    if(isset($_SESSION['user_id'])){
        $arr['isLoggedin'] = 1;
        $arr['username'] = $_SESSION['user_id'];
    }
    return $this->view->render($response, 'signup.html', $arr);
});




//Routing the search page
$app->get('/search', function($request, $response, $arg){
    $arr = [
        'isLoggedin' => 0,
        'username' => '@',
        'gotTable' => 0,
    ];

    if(isset($_SESSION['user_id'])){
        $arr['isLoggedin'] = 1;
        $arr['username'] = $_SESSION['user_id'];
    }
    return $this->view->render($response, 'search.html', $arr);
});




//Fetching the tag which start with some 'term' in search bar
$app->get('/tags/search', function($request, $response, $arg) {
    require_once 'config.php';
    
    $filteredTags = array();
    $term = $request->getQueryParams()['term'];
    
    if($term==''){
        echo json_encode($filteredTags);
        return;
    }
    
    $sql = "SELECT * FROM all_tags WHERE tag LIKE '$term%'";
    $result = mysqli_query($conn, $sql);
    $rows = $result->fetch_all();
    
    foreach($rows as $key => $val){
        array_push($filteredTags, $val[1]);
    }

    if(isset($_SESSION['user_id'])){
        $sql = "SELECT * FROM privatetags WHERE tag LIKE '$term%'";
        $result = mysqli_query($conn, $sql);
        $rows = $result->fetch_all();
        foreach($rows as $key => $val){
            array_push($filteredTags, $val[1]);
        }
    }

    if(sizeof($filteredTags) == 0){
        array_push($filteredTags, 'No results found');
    }

    $arr = array();
    $filteredTags = array_unique($filteredTags);
    for($i=0; $i<min(sizeof($filteredTags), 10); $i++){
        array_push($arr, $filteredTags[$i]);
    }
    echo json_encode(array_unique($arr));
});



//Fetching problems for searched tags in search bar
$app->get('/search/problems', function($request, $response, $arg){
    $tag = $request->getQueryParams()['tag'];
    $tag = urldecode($tag);

    require 'config.php';
    $sql = "SELECT * FROM questions WHERE ";
    $tag = explode(",", $tag);
    $sz = sizeof($tag);
    $condition = '';
    for($i = 0; $i < $sz-1; $i++){
        $condition = $condition."tag = '".trim($tag[$i])."' OR ";
    }
    $condition = $condition."tag = '".trim($tag[$sz-1])."'";
    $sql = $sql.$condition;
    $result = mysqli_query($conn, $sql);
    $rows = $result->fetch_all();

    $filteredQues = array();
    
    foreach($rows as $key => $val){
        $temp = array();
        array_push($temp, $val[0]);
        array_push($temp, $val[2]);
        array_push($temp, $val[3]);
        array_push($temp, $val[4]);
        array_push($temp, floor(($val[3]*10000)/$val[4])/100);
        if(!in_array($temp, $filteredQues)){
            array_push($filteredQues, $temp);
        }
    }

    $arr = [
        'isLoggedin' => 0,
        'username' => '@',
        'gotTable' => 1
    ];

    if(isset($_SESSION['user_id'])){
        $arr['isLoggedin'] = 1;
        $arr['username'] = $_SESSION['user_id'];

        $sql = "SELECT * FROM privatetags WHERE user_id='".$_SESSION['user_id']."' AND (";
        $sql = $sql.$condition.")";
        $result = mysqli_query($conn, $sql);
        $rows = $result->fetch_all();
        foreach($rows as $key => $val){
            $temp = array();
            array_push($temp, $val[2]);
            array_push($temp, $val[3]);
            array_push($temp, $val[4]);
            array_push($temp, $val[5]);
            array_push($temp, floor(($val[4]*10000)/$val[5])/100);
            if(!in_array($temp, $filteredQues)){
                array_push($filteredQues, $temp);
            }
        }
    }

    $arr['rows'] = $filteredQues;
    $arr['qlink'] = "https://www.codechef.com/problems/";
    return $this->view->render($response, 'search.html', $arr);
});



/*******************************************USER PRIVILEGES*********************************************** */

//posting signup form
$app->post('/signup', function($request, $response, $arg){
    extract($_POST);
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    if(isset($_SESSION["user_id"])){
        return $response->withStatus(401)->write('Page does not exist');
    }

    require 'config.php';
    $sql = "SELECT * FROM user WHERE user_id = '".$user_id."'";
    $result = mysqli_query($conn, $sql);
    $arr = $result->fetch_all();
    if(sizeof($arr) > 0){
        return $response->withJson(array('status' => 0));
    }
    $sql = "INSERT INTO user (user_id, pass, name, email) VALUES ('$user_id','$pass','$name','$email')";
    $rs = mysqli_query($conn, $sql);
    
    return $response->withJson(array('status' => 1));
});



//posting login form 
$app->post('/login', function($request, $response, $arg){
    extract($_POST);
    if(isset($_SESSION["user_id"])){
        return $response->withStatus(401)->write('Page does not exist');
    }

    require_once 'config.php';
    $result = mysqli_query($conn,"select * from user where user_id='$user_id'");
    $result = $result->fetch_all();
    $db_pass = $result[0][1];
    if(password_verify($pass, $db_pass)){
        $_SESSION["user_id"] = $user_id;
        return $response->withJson(array('status' => 1));
    }
    else{
        return $response->withJson(array('status' => 0));
    }
});



//posting tags and question details when a tag is added
$app->post('/addTag', function($request, $response, $arg){
    if(!isset($_SESSION['user_id'])){
        return $response->withStatus(401)->write("You are not authorised!");
    }
    extract($_POST);
    $user_id = $_SESSION['user_id'];
    require 'config.php';
    $sql = "SELECT * FROM privatetags WHERE user_id = '$user_id' AND tag = '$tag' AND code = '$code'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        return $response->withJson(array('status' => 1));
    }
    $sql = "INSERT INTO privatetags (user_id, tag, code, author, solved, attempted) VALUES ('$user_id', '$tag', '$code', '$author', '$solved', '$attempted')";
    $result = mysqli_query($conn, $sql);
    return $response->withJson(array('status' => 1));
});




$app->post('/privateTag/delQues', function($request, $response, $arg){
    if(!isset($_SESSION['user_id'])){
        return $response->withStatus(401)->write("You are not authorised!");
    }
    extract($_POST);
    $user_id = $_SESSION['user_id'];
    require 'config.php';
    $sql = "DELETE FROM privatetags WHERE user_id = '$user_id' AND tag = '$tag' AND code = '$code'";
    mysqli_query($conn, $sql); 
    return $response->withJson(array('status' => 1));
});



$app->post('/privateTag/delTag', function($request, $response, $arg){
    if(!isset($_SESSION['user_id'])){
        return $response->withStatus(401)->write("You are not authorised!");
    }
    extract($_POST);
    $user_id = $_SESSION['user_id'];
    require 'config.php';
    $sql = "DELETE FROM privatetags WHERE user_id = '$user_id' AND tag = '$tag'";
    mysqli_query($conn, $sql); 
    return $response->withJson(array('status' => 1));
});



$app->get('/logout', function($request, $response){
    if(isset($_SESSION["user_id"])){
        unset($_SESSION["user_id"]);
        $arr = [
            'isLoggedin' => 0,
            'username' => '@'
        ];
    
        if(isset($_SESSION['user_id'])){
            $arr['isLoggedin'] = 1;
            $arr['username'] = $_SESSION['user_id'];
        }
        header("Location: http://codebook1106.000webhostapp.com/");
        die();
    }
    else{
        return $response->withStatus(401)->write('Page does not exist');
    }
});


/********************************************************************************************************* */

$app->run();


?>
