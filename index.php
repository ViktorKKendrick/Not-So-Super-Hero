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
//Session to store information
//Create Hero
function createHero ( $name,  $about_me, $biography){
     $sql = "INSERT INTO heroes (name, about_me, biography) VALUES ('$name', '$about_me', '$biography')";

     global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "New Hero created successfully";
        echo '<br>';
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // echo 'Hero Created';
    
}
//Read Heroes
function viewAllHeroes(){
    $sql = "SELECT name, about_me FROM heroes";

    global $conn;
    $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo $row['id'] . "Name: " . $row['name'] . ". <br/>About Me: " . $row['about_me'] . "<br/><br/>";
        }
}
//Update Hero
function updateHero($name, $tagline){

}
//Delete Hero
function deleteHero($name){

}
$action = $_GET['action'];

if($action !=''){
    switch($action){
        case "create":
            createHero($_GET["name"], $_GET["about_me"], $_GET["biography"]);
            viewAllHeroes();
            break;
        case 'read':
            viewAllHeroes();
            break;
        case 'update':
            updateHero($_GET['name'], $_GET['tagline']);
            break;
        case 'delete':
            deleteHero($_GET['name']);
            break;
        default:
            echo '404: Page Not Found';
            break;
    }
    
}

$conn->close();
?>