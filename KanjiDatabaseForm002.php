<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
include_once 'PHPPuzzleObject.php';

$servername = $_SESSION["servername"];
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$puzzlenumber = $_SESSION["puzzlenumber"];
$createddate = $_SESSION["createddate"];

$temppuzzle = new Puzzle($puzzlenumber, '182');
$conn = new mysqli($servername, $username, $password);

// Check connection
if($conn->connect_error) {
    echo "Your server information has become invalid.";
    echo "<h1>Connection Parameters</h1>";
    echo "The servername you entered was $servername .";
    echo "<br>";
    echo " The username you entered was $username .";
    echo "<br>";
    echo "The password you entered was $password .";
    die("Connection failed: " . $conn->connect_error);
    }else {
    echo "Database is online. <br>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<?php 
$sql = "SELECT * FROM kanji.kanji_puzzle WHERE puzzle_number = $puzzlenumber";
$row = $conn->query($sql);
if($row->num_rows > 0) {
    echo "Your puzzle has loaded.<br>";
    $asarray = $row->fetch_row();
    $htmlfill = $temppuzzle->editpuzzle($temppuzzle->size, $asarray);
    echo html_entity_decode($htmlfill);
    }else {
    echo "Error: " . $sql . "<br>" . $conn->error . $conn->errno;
}
?>

<input type='submit' value='Update'></form>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $temppuzzle->indexed_boxnames;
    $postarray = array();
    for($x = 0; $x < count($index); $x++) {
        $postname = strval($index[$x]);
        array_push($postarray, $_POST[$postname]);
    }
    $assignment = $temppuzzle->updatepuzzle($postarray);
    echo strval($assignment);
    $sql = "UPDATE kanji.kanji_puzzle SET $assignment WHERE puzzle_number = '$puzzlenumber'";
    if ($conn->query($sql) === TRUE) {
        echo "Your puzzle number " . $puzzlenumber . " was updated. <br>";
        }elseif ($conn->errno == 1062){
        echo "This is a duplicate entry.";
        }else {
        echo "Error: " . $sql . "<br>" . $conn->error . $conn->errno;
    }
    
    $conn->close();
}

?>

</body>
</html>