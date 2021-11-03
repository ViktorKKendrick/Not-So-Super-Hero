<?php
// session_start();

// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "superheroes";
// $dbname = "superheres"; 
// ^^ fake database to check for connection error ^^
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo 'start of script';
echo '<br>';

$action = $_GET['action'];

if($action !=''){
    switch($action){
        case 'create':
            createHero($_GET['name'], $_GET['tagline']);
            break;
        case 'read':
            
            break;
        case 'update':
            updateHero($_GET['name'], $_GET['tagline']);
            break;
        case 'delete':
            deleteHero($_GET['name']);
            break;
        default:
        init();
    }
    viewAllHeroes();
}

function init(){
    $_SESSION['heroes'] = [];
}
//Session to store information

//store an array, push, pop, splice

//Create Hero
function createHero (String $name, String $about_me, $biography, $abilities, $conn){
     $sql = "INSERT INTO heroes (name, about_me, biography) VALUES ('$name', '$about_me', '$biography')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
//Read Heroes
function viewAllHeroes(){
echo '<pre> view' . print_r($_SESSION['heroes'], 1) . '</pre>';
}
//Update Hero
function updateHero($name, $tagline){

}
//Delete Hero
function deleteHero($name){

}
echo '<br>';
echo 'End of script';



?>