<?php include '../db.php';?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // json : [["sara","hello","1","1544961600000","0","0"],["sara","hi sara","1","1544961240000","0","0"]
    // deviceId : 000000000000000
    // userId : 167

    $json = $_POST["json"];
    $deviceId = $_POST["deviceId"];
    $userId = $_POST["userId"];
    $signed_in = false;
    $cnt = 0;
    
    $profile = find_profile($userId);
    if ($profile) {
        if (0 == strcmp($profile->iemiNo, $deviceId)) {
            $signed_in = true;
        }
    }

    if ($signed_in == false) {
        //echo "<b>You didn't signin.</b>";
    } else {
        $messages = preg_split("/(\],\[)|(\[\[)|(\]\])/", $json, 0, PREG_SPLIT_NO_EMPTY);
        foreach ($messages as $item) {
            $values = preg_split("/[,\"]/", $item, 0, PREG_SPLIT_NO_EMPTY);
            $msg = new Message();
            $msg->sender = $values[0];
            $msg->message = $values[1];
            $msg->arg1 = $values[2];

            $timestamp = (int)((double)($values[3]) / 1000);
            $date = new DateTime();
            $date->setTimestamp($timestamp);
            $msg->time = date_format($date, 'Y-m-d H:i:s');

            $msg->type = $values[4];
            $msg->arg2 = $values[5];

            // Insert new user
            $strsql_insert = "INSERT INTO MESSAGES (userId, sender, message, type, time, arg1, arg2)" 
                . " VALUES ('" . $userId 
                . "','" . $msg->sender 
                . "','" . $msg->message 
                . "','" . $msg->type 
                . "','" . $msg->time 
                . "','" . $msg->arg1 
                . "','" . $msg->arg2 
                . "');";
            if ($mysqli->query($strsql_insert)) {
                $cnt ++;
            } else {
                //echo "<b>Can't insert into the table. " . mysqli_error() . "</b>";
            }
        }
    }

    echo $cnt;
}

$mysqli->close();
?>
