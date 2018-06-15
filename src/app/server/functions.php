<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    die();
}

function checkIfLoggedIn(){
    global $conn;
    if(isset($_SERVER['HTTP_TOKEN'])){
        $token = $_SERVER['HTTP_TOKEN'];
        $result = $conn->prepare("SELECT * FROM users WHERE token=?");
        $result->bind_param("s",$token);
        $result->execute();
        $result->store_result();
        $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        return true;
    }
    else{
        return false;
    }
    }
    else{
        return false;
    }
}
function login($username, $password){
    global $conn;
    $rarray = array();
    if(checkLogin($username,$password)){
        $id = sha1(uniqid());
        $result2 = $conn->prepare("UPDATE users SET token=? WHERE username=?");
        $result2->bind_param("ss",$id,$username);
        $result2->execute();
        $rarray['token'] = $id;
    } else{
        header('HTTP/1.1 401 Unauthorized');
        $rarray['error'] = "Invalid username/password";
    }
    return json_encode($rarray);
}

function checkLogin($username, $password){
    global $conn;
    $password = md5($password);
    $result = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $result->bind_param("ss",$username,$password);
    $result->execute();
    $result->store_result();
    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        return true;
    }
    else{
        return false;
    }
}

function register($username, $password, $firstname, $lastname){
    global $conn;
    $rarray = array();
    $errors = "";
    if(checkIfUserExists($username)){
    $errors .= "Username already exists\r\n";
    }
    if(strlen($username) < 5){
    $errors .= "Username must have at least 5 characters\r\n";
    }
    if(strlen($password) < 5){
    $errors .= "Password must have at least 5 characters\r\n";
    }
    if(strlen($firstname) < 3){
    $errors .= "First name must have at least 3 characters\r\n";
    }
    if(strlen($lastname) < 3){
    $errors .= "Last name must have at least 3 characters\r\n";
    }
    if($errors == ""){
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username,
        password) VALUES (?, ?, ?, ?)");
        $pass =md5($password);
        $stmt->bind_param("ssss", $firstname, $lastname, $username, $pass);
        if($stmt->execute()){
            $id = sha1(uniqid());
            $result2 = $conn->prepare("UPDATE users SET token=? WHERE username=?");
            $result2->bind_param("ss",$id,$username);
            $result2->execute();
            $rarray['token'] = $id;
        }else{
            header('HTTP/1.1 400 Bad request');
            $rarray['error'] = "Database connection error";
        }
    } else{
        header('HTTP/1.1 400 Bad request');
        $rarray['error'] = json_encode($errors);
    }
    return json_encode($rarray);
}

function checkIfUserExists($username){
    global $conn;
    $result = $conn->prepare("SELECT * FROM users WHERE username=?");
    $result->bind_param("s",$username);
    $result->execute();
    $result->store_result();
    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        return true;
    }
    else{
        return false;
    }
}

function addRoom($broj, $naziv, $tv, $kvadrati, $kreveti, $room_type_id){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){
        $stmt = $conn->prepare("INSERT INTO rooms (broj, naziv, tv, kvadrati, kreveti, room_type_id) VALUES (?,
        ?, ?, ?, ?, ?)");
        $stmt->bind_param("dsdddd",$broj, $naziv, $tv, $kvadrati, $kreveti, $room_type_id);
        if($stmt->execute()){
            $rarray['success'] = "ok";
        }else{
            $rarray['error'] = "Database connection error";
        }
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
    }
    return json_encode($rarray);
}


function getRooms(){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){ 
        
                             //"SELECT rooms.id, broj, naziv, tv, kvadrati, kreveti,  (SELECT tip FROM room_type WHERE id=rooms.room_type_id) as tip FROM rooms"
        $result = $conn->query("SELECT rooms.id,broj,naziv,tv,kvadrati,kreveti, tip from rooms,room_type where rooms.room_type_id=room_type.id");
      
        $num_rows = $result->num_rows;
        
        $rooms = array();
        if($num_rows > 0)
        {                         //"SELECT rooms.id, broj, naziv, tv, kvadrati, kreveti,  (SELECT tip FROM room_type WHERE id=rooms.room_type_id) as tip FROM rooms"
            $result2 = $conn->query("SELECT rooms.id,broj,naziv,tv,kvadrati,kreveti, tip from rooms,room_type where rooms.room_type_id=room_type.id");
           
            while($row = $result2->fetch_assoc()) {
                $one_room = array();
                $one_room['id'] = $row['id'];
                $one_room['broj'] = $row['broj'];
                $one_room['naziv'] = $row['naziv'];
                $one_room['tv'] = $row['tv'];
                $one_room['kvadrati'] = $row['kvadrati'];
                $one_room['kreveti'] = $row['kreveti'];
                $one_room['tip'] = $row['tip']; 
                array_push($rooms,$one_room);
            }
        }
        $rarray['rooms'] = $rooms;
        return json_encode($rarray);
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
        return json_encode($rarray);
    }
}




function getRoom($id){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){
        $result = $conn->query("SELECT rooms.id, broj, naziv, tv, kvadrati, kreveti,  (SELECT tip FROM room_type WHERE id=rooms.room_type_id) as tip FROM rooms WHERE rooms.id=".$id);
        $num_rows = $result->num_rows;
        $rooms = array();
        if($num_rows > 0)
        {
            $result2 = $conn->query("SELECT rooms.id, broj, naziv, tv, kvadrati, kreveti,  (SELECT tip FROM room_type WHERE id=rooms.room_type_id) as tip FROM rooms WHERE rooms.id=".$id);
            while($row = $result2->fetch_assoc()) {
                $one_room = array();
                $one_room['id'] = $row['id'];
                $one_room['broj'] = $row['broj'];
                $one_room['naziv'] = $row['naziv'];
                $one_room['tv'] = $row['tv'];
                $one_room['kvadrati'] = $row['kvadrati'];
                $one_room['kreveti'] = $row['kreveti'];
                $one_room['tip'] = $row['tip']; 
                $rooms = $one_room;
            }
        }
        $rarray['room'] = $rooms;
        return json_encode($rarray);
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
        return json_encode($rarray);
    }
}





function deleteRoom($id){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){
        $result = $conn->prepare("DELETE FROM rooms WHERE id=?");
        $result->bind_param("i",$id);
        $result->execute();
        $rarray['success'] = "Deleted successfully";
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
    }
    return json_encode($rarray);
}




function updateRoom($broj, $naziv, $tv, $kvadrati, $kreveti, $room_type_id, $id){ 
    global $conn;
     $rarray = array(); 
     if(checkIfLoggedIn()){
          $stmt = $conn->prepare("UPDATE rooms SET broj=?, naziv=?, tv=?, kvadrati=?, kreveti=?, room_type_id=? WHERE id=?");
           $stmt->bind_param("isiiiii", $broj, $naziv, $tv, $kvadrati, $kreveti, $room_type_id, $id); 
           if($stmt->execute()){
                $rarray['success'] = "updated";
             }else{
                  $rarray['error'] = "Database connection error";
                 } 
    } else{ 
        $rarray['error'] = "Please log in"; 
        header('HTTP/1.1 401 Unauthorized');
     } 
     return json_encode($rarray); 
    }



    function getRoomWithId($id){ 
        global $conn;
        $rarray = array();
         if(checkIfLoggedIn()){ 
            $id = $conn->real_escape_string($id);
            $result = $conn->query("SELECT rooms.id, broj, naziv, tv, kvadrati, kreveti,  (SELECT tip FROM room_type WHERE id=rooms.room_type_id) as tip FROM rooms WHERE rooms.id=".$id); 
            $num_rows = $result->num_rows;
             $rooms = array(); 

              if($num_rows > 0) {

                $result2 = $conn->query("SELECT rooms.id, broj, naziv, tv, kvadrati, kreveti,  (SELECT tip FROM room_type WHERE id=rooms.room_type_id) as tip FROM rooms WHERE rooms.id=".$id);
                while($row = $result2->fetch_assoc()) {
                    $rooms = $row;
                    } 
                 }
                $rarray['room'] = $rooms; 
                 return json_encode($rarray); 
         } else{ 
             $rarray['error'] = "Please log in"; 
             header('HTTP/1.1 401 Unauthorized');
              return json_encode($rarray); 
         }
                    
     }



function addRoomType($tip){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){
        $stmt = $conn->prepare("INSERT INTO room_type (tip) VALUES (?)");
        $stmt->bind_param("s", $tip);
        if($stmt->execute()){
            $rarray['success'] = "ok";
        }else{
            $rarray['error'] = "Database connection error";
        }
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
    }
    return json_encode($rarray);
}

function getRoomTypes(){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){
        $result = $conn->query("SELECT * FROM room_type");
        $num_rows = $result->num_rows;
        $room_types = array();
        if($num_rows > 0)
        {
            $result2 = $conn->query("SELECT * FROM room_type");
            while($row = $result2->fetch_assoc()) {
                $one_room = array();
                $one_room['id'] = $row['id'];
                $one_room['tip'] = $row['tip'];
                array_push($room_types,$one_room);
            }
        }
        $rarray['room_types'] = $room_types;
        return json_encode($rarray);
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
        return json_encode($rarray);
    }
}



function getRoomType($id){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){
        $result = $conn->query("SELECT * FROM room_type WHERE id=".$id);
        $num_rows = $result->num_rows;
        $room_type = array();
        if($num_rows > 0)
        {
            $result2 = $conn->query("SELECT * FROM room_type WHERE id=".$id);
            while($row = $result2->fetch_assoc()) {
                $one_room = array();
                $one_room['id'] = $row['id'];
                $one_room['tip'] = $row['tip'];
                 
                $room_type = $one_room;
            }
        }
        $rarray['type'] = $room_type;
        return json_encode($rarray);
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
        return json_encode($rarray);
    }
}

function updateRoomType($tip, $id){ 
    global $conn;
     $rarray = array(); 
     if(checkIfLoggedIn()){
          $stmt = $conn->prepare("UPDATE room_type SET tip=? WHERE id=?");
           $stmt->bind_param("si", $tip, $id); 
           if($stmt->execute()){
                $rarray['success'] = "updated";
             }else{
                  $rarray['error'] = "Database connection error";
                 } 
    } else{ 
        $rarray['error'] = "Please log in"; 
        header('HTTP/1.1 401 Unauthorized');
     } 
     return json_encode($rarray); 
    }

function deleteRoomType($id){
    global $conn;
    $rarray = array();
    if(checkIfLoggedIn()){
        $result = $conn->prepare("DELETE FROM room_type WHERE id=?");
        $result->bind_param("i",$id);
        $result->execute();
        $rarray['success'] = "Deleted successfully";
    } else{
        $rarray['error'] = "Please log in";
        header('HTTP/1.1 401 Unauthorized');
    }
    return json_encode($rarray);
}



?>
