<?php include '../db.php';?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // profileJson : {"access":"client","deviceName":"unknown Custom Phone - 9.0 preview - API 28 - 768x1280","iemiNo":"000000000000000","name":"unknown Custom Phone - 9.0 preview - API 28 - 768x1280","os":"28","phoneNo":"","userId":""}
    // deviceId : 000000000000000
    // userId : 
    // credentialsJson : {"loginPassword":"password1","loginUserName":"000000000000000","userId":""}

    $profileJson = $_POST["profileJson"];
    $deviceId = $_POST["deviceId"];
    $userId = $_POST["userId"];
    $credentialsJson = $_POST["credentialsJson"];

    $profile = json_decode($profileJson);
    $credentials = json_decode($credentialsJson);

    $strsql = "select * from PROFILES WHERE" 
        . " access='" . $profile->access . "' AND" . " iemiNo='" . $profile->iemiNo . "'"
        . " ORDER BY userId DESC limit 1";
    if ($result = $mysqli->query($strsql)) {
        if ($result->num_rows == 0) {
            // Insert new user
            $strsql_insert = "INSERT INTO PROFILES (access, deviceName, loginPassword, iemiNo, name, os, phoneNo)" 
                . " VALUES ('" . $profile->access 
                . "','" . $profile->deviceName 
                . "','" . $credentials->loginPassword 
                . "','" . $profile->iemiNo 
                . "','" . $profile->name 
                . "','" . $profile->os 
                . "','" . $profile->phoneNo 
                . "');";
            if ($mysqli->query($strsql_insert)) {
                $result = $mysqli->query($strsql);
            } else {
                echo "<b>Can't insert into the table. " . mysqli_error() . "</b>";
            }
        }

        if ($result->num_rows != 0) {
            mysqli_data_seek ( $result, 0 );
            $row = mysqli_fetch_row ( $result );
            $prof = get_profile($row);

            class Data {};
            $data = new Data();
            $data->name = $prof->name;
            $data->iemiNo = $prof->iemiNo;
            $data->userId = $prof->userId;
            $data->phoneNo = $prof->phoneNo;
            $data->email = $prof->email;
            $data->access = $prof->access;
            $data->deviceName = $prof->deviceName;
            $data->os = $prof->os;
            $data->dateTime = $prof->time;

            class Response {};
            $resp = new Response();
            $resp->responseData = $data;

            echo json_encode($resp);
        }

        $result->close();
    } else {
        //Could be many reasons, but most likely the table isn't created yet. init.php will create the table.
        echo "<b>Can't query the database, did you <a href = init.php>Create the table</a> yet?</b>";
    }
}

$mysqli->close();
?>
