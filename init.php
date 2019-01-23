<?php include 'db.php';?>

<!DOCTYPE html>
<html>
<head>
    <title>Phone Spy</title>
    <link rel="stylesheet" href="style.css" />
</head>

<?php

$sqlTable="DROP TABLE IF EXISTS PROFILES";
$mysqli->query($sqlTable);

echo "Executing CREATE PROFILES Query...<br>";
if ($mysqli->query($sqlTable_PROFILES)) {
    echo "Table created successfully!<br>";
} else {
	echo "ERROR: Cannot create table. "  . mysqli_error();
	die();
}


$sqlTable="DROP TABLE IF EXISTS MESSAGES";
$mysqli->query($sqlTable);

echo "Executing CREATE MESSAGES Query...<br>";
if ($mysqli->query($sqlTable_MESSAGES)) {
    echo "Table created successfully!<br>";
} else {
	echo "ERROR: Cannot create table. "  . mysqli_error();
	die();
}

$mysqli->close();
?>

<button class = "mybutton" onclick="window.location = 'index.php';">Back</button>

</html>