<?php 
//Checking Authentication. Same file as the SQL connection details to avoid spoofing. 
//Run check if user is not currently in the process of logging in
if ($_SERVER["REQUEST_URI"] != "/auth/auth.php") {
if(isset($_SESSION['CUID'])){
$CUID = $_SESSION['CUID'];
$authquery = mysqli_query($con, "SELECT * 
FROM  `users` 
WHERE `UserID` = '$CUID'
ORDER BY  `UserID` DESC 
LIMIT 0 , 99") or die ('Unable to execute query. '. mysqli_error($con));
$authresult = mysqli_fetch_array($authquery);
if($CUID==$authresult['UserID']){
//Do nothing, the user exists and has signed in
}
else{
//send 403 error to browser and destroy session data. Server variable exists but user doesnt match the database. 
session_destroy();
header("HTTP/1.1 403 Unauthorized" );
echo "User authentication failed.";
echo "<a href='" . $DocPath . "auth/'>Click here to return to the login</a>";
exit;
}
}
else{
//send 403 error to browser and destroy session data
session_destroy();
header("HTTP/1.1 403 Unauthorized" );
?>
<h1>HTTP/1.1 403 Unauthorized</h1>
Sorry there was a problem with your request. </br>
The server responded with:
<b>User Not logged in.</b>
<a href='<?php echo $DocPath; ?>auth/'>Click here to return to the login</a>
<?PHP
exit;
}
}
?>