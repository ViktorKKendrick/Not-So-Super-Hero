<?php
// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "superheroes";
// $dbname = "superheres"; 
// ^^ fake database to check for connection error ^^
$conn = new mysqli($servername, $username, $password, $dbname);
$conn2 = new mysqli($servername, $username, $password, 'supervillains');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

//Create Hero
function createHero ( $name,  $about_me, $biography){
    if(strlen($name) == 0){
        echo 'Error 406: Please enter a Name';
        return;
    }
    else if(strtolower($name) === 'teapot'){
        echo 'Error 418.';
        return;
    }

     $sql = "INSERT INTO heroes (name, about_me, biography) VALUES ('$name', '$about_me', '$biography')";

     global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "New Hero created successfully";
        echo '<br>';
        viewAllHeroes();
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // echo 'Hero Created';
    
}
//Create Villain
function createVillain ( $name,  $about_me, $biography){
    if(strlen($name) == 0){
        echo 'Error 406: Please enter a Name';
        return;
    }
    else if(strtolower($name) === 'teapot'){
        echo 'Error 418.';
        return;
    }
     $sql = "INSERT INTO villains (name, about_me, biography) VALUES ('$name', '$about_me', '$biography')";

     global $conn2;
    if ($conn2->query($sql) === TRUE) {
        echo "New Villain created successfully";
        echo '<br>';
        viewAllVillains();
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn2->error;
    }
    // echo 'Hero Created';
    
}

//Read Heroes
function viewAllHeroes(){
    $sql = "SELECT name, about_me FROM heroes";

    global $conn;
    $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "Name: " . $row['name'] . ". <br/>About Me: " . $row['about_me'] . "<br/><br/>";
        }
}
//Read Villain
function viewAllVillains(){
    $sql = "SELECT name, about_me FROM villains";

    global $conn2;
    $result = $conn2->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "Name: " . $row['name'] . ". <br/>About Me: " . $row['about_me'] . "<br/><br/>";
        }
}

//Update Hero
function updateHero($name, $about_me, $biography){
    if(strlen($name) == 0){
        echo 'Error 406: Please enter a Name';
        return;
    }
    if($name != 'Tom'){
        $sql = "UPDATE heroes SET name='$name', about_me='$about_me', biography='$biography' WHERE name='$name'";
    }
    else{
        echo "You Can't Change me";
        echo '<br>';
    }
    global $conn;
        if ($conn->query($sql) === TRUE) {
            echo "Updated successfully";
            echo '<br>';
            viewAllVillains();
        }
        else {
            echo "Error Updating: " . $conn->error;
            echo '<br>';
        }
}
//Update Villain
function updateVillain($name, $about_me, $biography){
    if(strlen($name) == 0){
        echo 'Error 406: Please enter a Name';
        return;
    }

        $sql = "UPDATE villains SET name='$name', about_me='$about_me', biography='$biography' WHERE name='$name'";
    global $conn2;
        if ($conn2->query($sql) === TRUE) {
            echo "Updated successfully";
            echo '<br>';
            viewAllVillains();
        }
        else {
            echo "Error Updating: " . $conn2->error;
            echo '<br>';
        }
}

//Delete Hero
function deleteHero($name){
    if(strlen($name) == 0){
        echo 'Error 406: Please enter a Name';
        return;
    }
    if($name != 'Tom'){
        $sql = "DELETE FROM heroes WHERE name='$name'";
    }
    else{
        echo "You can't delete Tom";
        echo "<br>";
        echo "<br>";
        return;
    }
    global $conn;
    
     if ($conn->query($sql) === TRUE) {
        echo "$name deleted successfully";
        echo '<br>';
        viewAllVillains();
    }
    else {
        echo "Error when deleting:" . $conn->error;
        echo "<br>";
    }
}
//Delete Villain
function deleteVillain($name){
    if(strlen($name) == 0){
        echo 'Error 406: Please enter a Name';
        return;
    }
        $sql = "DELETE FROM villains WHERE name='$name'";
    global $conn2;
    
     if ($conn2->query($sql) === TRUE) {
        echo "$name deleted successfully";
        echo '<br>';
        viewAllVillains();
    }
    else {
        echo "Error when deleting:" . $conn2->error;
        echo "<br>";
    }
}
//Get Ability
function getAllAbilities(){
    $sql = "SELECT ability FROM ability_type";
    global $conn;
    $result = $conn->query($sql);
    // $result->num_rows
    if ($conn->query($sql) > 0) {
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            echo '<br>';
        }
    }
    else {
        echo $conn->errors;
    }
}

function getHeroAbilities(){
    $id = $_GET["id"];
    $sql = "SELECT 
    heroes.name, heroes.about_me, GROUP_CONCAT(ability_type.ability separator ', ') ability_type
    FROM ((heroes
    INNER JOIN abilities ON heroes.id = abilities.hero_id)
    INNER JOIN ability_type ON abilities.ability_id = ability_type.id)
    GROUP BY heroes.name, heroes.about_me";
    global $conn;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            echo '<br>';
        }
    }
    else {
        echo $conn->errors;
    }
}

$action = $_GET['action'];

//Routes
if($action !=''){
    switch($action){
        case "createH":
            createHero($_GET["name"], $_GET["about_me"], $_GET["biography"]);
            break;

        case 'readH':
            viewAllHeroes();
            break;

        case 'updateH':
            updateHero($_GET['name'], $_GET['about_me'], $_GET['biography']);
            break;

        case 'deleteH':
            deleteHero($_GET['name']);
            break;

        case 'createV':
            createVillain($_GET["name"], $_GET["about_me"], $_GET["biography"]);
            break;

        case 'readV':
            viewAllVillains();
            break;

        case 'updateV':
            updateVillain($_GET['name'], $_GET['about_me'], $_GET['biography']);
            break;

        case 'deleteV':
            deleteVillain($_GET['name']);
            break;

        case 'getAllAbilities':
            getAllAbilities();
            break;

        case 'getHeroAbilities':
            getHeroAbilities();
            break;

        default:
            echo '404: Page Not Found';
            break;
    }
    
}

$conn->close();
