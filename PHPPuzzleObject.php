<?php
class Puzzle {
// name is a string format ### representing the puzzles primary key in mysqldb
  public $name;
// size is a string format ### representing the no of boxes in the puzzle
// size is used to generate the html representation of the puzzle
  public $size;
// function list is a string of the different methods availabe in this class
  public $function_list;
// an indexed array
  public $indexed_boxnames;
// html string shows where boxnames are arranged in the html table
  public $htmltable;

  public function __construct($name, $size) {
    $this->name = $name;
    $this->size = $size;
    $this->function_list = "The variables available are as follows: <br>
    name, size, function_list, indexed_boxnames <br>
    The functions available are as follows: <br>
    get_name, set_name, get_size, set_size, get_boxnames, help, mysqlpuzzle <br>";
    $this->indexed_boxnames = $this->boxnamearray($size);
    $this->htmltable = $this->buildpuzzle($size);
  }
  
  public function get_name() {
    return $this->name;
  }

  public function set_name($string) {
    $this->name = $string;
  }
  
  public function get_size() {
    return $this->size;
  }

  public function set_size($string) {
    $this->size = $string;
  }
  
  public function get_boxnames() {
    return print_r($this->indexed_boxnames);
  }
    
  public function help() {
    return $this->function_list;
  }

  private function boxnamearray($string) {
//    echo "Function started. <br>";
    $array = array();
//    echo "Empty array initialized. <br>";
    $i = 1; 
//    echo "Iterator set to 1. <br>";
    while($i < ($string +1)){
//        echo "While-Loop started. <br>";
        $boxname = "box_" . strval($i); 
//        echo "Boxname variable set. <br>";
        array_push($array, $boxname);
//        echo "Array appended with " . $boxname . ". <br>"; 
        $i++;
//        echo "Iterator advanced to " . $i . ". <br";
    }
//    echo "While-Loop exited. <br>";
    return $array;
  }
  
  private function buildpuzzle($string){
    $htmlstring = htmlentities("<table><tbody>");
    if($string == '182') {
//      echo "Valid puzzle size. <br>"; 
      $i = 0;
      while($i < 14) {
        $htmlstring = $htmlstring . htmlentities("<tr>");
        $j = 1; 
        while($j < 14){
          $boxname = "box_" . ($j + ($i*13));
          $htmlstring = $htmlstring . htmlentities("<td>") . $boxname . htmlentities("</td>");
          $j++;
          }
        $htmlstring = $htmlstring . htmlentities("</tr>");
        $i++;
        }
      $htmlstring = $htmlstring . htmlentities("</table>");
      return $htmlstring;
    }else {
      echo "Invalid puzzle size. Current supported puzzle sizes include: <br>
      182 <br>";
      $htmlstring = $htmlstring . htmlentities("<tr><th>Failed build due to invalid size.</th></tr>");
      $htmlstring = $htmlstring . htmlentities("</tbody></table>");
      return $htmlstring;
    }
  }

//Pass in a valid puzzle size 182 and valid SQL query cast to array to return htmlentity string
//The SQL query must result in an enumerated array, $mysqlrow->fetch_row();
//   $conn = new mysqli($servername, $username, $password);
//   $sql = "SELECT * FROM database.table WHERE puzzle_number = '#'";
//   $row = $conn->query($sql);
//   $asarray = $row->fetch_row();
//$asarray is an enumerated array and can be passed to this function 
  public function mysqlpuzzle($size, $asarray){
    $htmlstring = htmlentities("<table>");
    if($size == '182') {
      $i = 0;
      while($i < 14) {
        $htmlstring = $htmlstring . htmlentities("<tr>");
        $j = 1; 
        while($j < 14){
          $k = $j + ($i*13) + 1;
          $boxentry = $asarray[$k];
          $htmlstring = $htmlstring . htmlentities("<td>") . $boxentry . htmlentities("</td>");
          $j++;
          }
        $htmlstring = $htmlstring . htmlentities("</tr>");
        $i++;
        }
      $htmlstring = $htmlstring . htmlentities("</table>");
      return $htmlstring;
    }else {
      echo "Invalid puzzle size. Current supported puzzle sizes include: <br>
      182 <br>";
      $htmlstring = $htmlstring . htmlentities("<tr><th>Failed build due to invalid size.</th></tr>");
      $htmlstring = $htmlstring . htmlentities("</table>");
      return $htmlstring;
    }
  }

  public function editpuzzle($size, $asarray){
    $htmlstring = htmlentities("");
    if($size == '182') {
        $i = 0;
        while($i < 14) {
            $htmlstring = $htmlstring . htmlentities("<br>");
            $j = 1; 
            while($j < 14){
                $k = $j + ($i*13) + 2;
                $boxentry = $asarray[$k];
                $boxno = $k-2;
                $htmlstring = $htmlstring . htmlentities("<input type='text' name='box_$boxno' value='$boxentry'>");
                $j++;
            }
            $htmlstring = $htmlstring . htmlentities("<br>");
            $i++;
        }
        return $htmlstring;
        }else {
        echo "Invalid puzzle size. Current supported puzzle sizes include: <br> 182 <br>";
        return $htmlstring;
    }
  }
  
  public function updatepuzzle($postarray){
    $easybox = $this->indexed_boxnames;
    $i = 0;
    $asgnstring = "$easybox[$i] = '$postarray[$i]'";
    $i++;
    while($i < count($easybox)){
        $asgnstring = $asgnstring . ", $easybox[$i] = '$postarray[$i]'"; 
        $i++;
    }
    return $asgnstring;
  }
}

?>