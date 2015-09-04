<?PHP
session_start();
require ('../config/config.php');
?>
<HTML>
<head>
<title>E-Signage | Admin</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../styles/admin.css.php' rel='stylesheet' type='text/css'>

</head>
<body style="margin:0px; padding:0px;">
<img src="../styles/images/blur.png" class="bg" />



<div style="position:absolute; top:50%; margin-top:-135px; width:100%; background:#fff; padding:0px; padding-top:20px;">
<center>

<?php

$authquery = mysqli_query($con, "SELECT * FROM  `users` LIMIT 0 , 1");
$authresult = mysqli_fetch_array($authquery);

if($authresult != NULL) { //i.e. if there are users, show the login.


//do nothing, there are already users this form is for initial user only.

echo "<h1>Failure...</h1><p>There are already users in the database. For security reasons /auth/firstuser.php should be deleted!</p><p><a href='" . $DocPath . "auth/'>Click here to return to login</a></p>";


}
else { //show user creation if there are no users

//create user! //should tell user to delete firstuser.php
$email = $_POST['email'];
$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($con,"INSERT INTO `$SQLDB`.`users` (`UserID`, `Email`, `Name`, `Password`) VALUES (NULL, '$email', '$name', '$password')") or die ('Unable to execute query. '. mysqli_error($con));

echo "<h1>Success!</h1>";

echo "<h2>" . $_POST['name'] . " has been created.</h2><p>E-Signage is now ready for you to login and create or edit signs. For security reasons '/auth/firstuser.php' should now be deleted!</p><p><a href='" . $DocPath . "auth/'>Click here to return to login</a></p>";

}

?>


</center>
</div>

<p style="margin:5px;padding:0px; color:#000; font-size:10px; width:99%; clear:both;text-align:center; position:absolute; bottom:0px;">&copy; <a href="https://chalkcreation.co.uk/" target="_new" style="color:#000; text-decoration:none;">Robin Wright 2014</a></p>
<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>
<?php
if(isset($_GET['message'])){
echo "<div class='servermessage'>" . $_GET['message'] . "</div>";
}
?>
</body>
</HTML>