<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
<title>Login to Kanji Puzzle Database</title>
</head>

<body>
<h1> Welcome to the Kanji Database Insertion Form! <h1>

<?php
  $servername = $_SESSION["servername"] = clean_input($_POST["servername"]);
  $username = $_SESSION["username"] = clean_input($_POST["username"]);
  $password = $_SESSION["password"] = clean_input($_POST["password"]);
  $puzzlenumber = $_SESSION["puzzlenumber"] = clean_input($_POST["puzzlenumber"]);
  $createddate = $_SESSION["createddate"] = clean_input($_POST["createddate"]);
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo "<h1>You are editing puzzle number:" . $puzzlenumber . "</h1>";
// Create connection
  $conn = new mysqli($servername, $username, $password);
  // Check connection
  if ($conn->connect_error) {
    echo "Your server information has become invalid.";
    echo "<h1>Connection Parameters</h1>";
    echo "The servername you entered was " . $servername . ".<br>";
    echo "The username you entered was " . $username . ".<br>";
    echo "The password you entered was " . $password . ".<br>";
    die("Connection failed: " . $conn->connect_error);
    }else{
    echo "Database is online. <br>";
    echo "Puzzle will be created on " . $createddate . ". <br>";
    }
// Start puzzle record 
  $sql = "INSERT INTO kanji.kanji_puzzle (puzzle_number, created_date)
  VALUES ('$puzzlenumber', '$createddate')";
  if ($conn->query($sql) === TRUE) {
    echo "Your puzzle number " . $puzzlenumber . " has been created successfully. <br>";
    echo "<form method=\"post\" action=\"KanjiDatabaseForm002.php\"><br><input type=\"submit\" value=\"Proceed to Kanji Entry\"></form>"; 
    }elseif ($conn->errno == 1062){
    echo "This is a duplicate entry. What would you like to do?";
    echo "<form method=\"post\" action=\"KanjiDatabaseForm002.php\"><br><input type=\"submit\" value=\"Update Existing Entry\"></form>";
    echo "<form method=\"post\" action=\"KanjiDatabaseForm003.php\"><br><input type=\"submit\" value=\"Delete Existing Entry\"></form>";
    }else {
    echo "Error: " . $sql . "<br>" . $conn->error . $conn->errno;
    }
   $conn->close();
}
?>

<?php
//Strip unnecessary characters (extra space, tab, newline) from the user input data (with the PHP trim() function)
//Remove backslashes (\) from the user input data (with the PHP stripslashes() function)
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<label for="servername">Servername: </label><br>
<input type="text" id="servername" name="servername"><br>

<label for="username">Username: </label><br>
<input type="text" id="username" name="username"><br>

<label for="password">Password: </label><br>
<input type="text" id="password" name="password"><br>

<label for="puzzlenumber">Puzzle Number (###):</label><br>
<input type="text" id="puzzlenumber" name="puzzlenumber"><br>

<label for="createddate">Date Created (YYYY-MM-DD): </label><br>
<input type="text" id="createddate" name="createddate"><br>

<input type="submit" name="create" value="Create Puzzle">
</form>

</body>
</html>