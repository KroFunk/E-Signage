<?PHP
session_start();
require "../config/config.php";
?>

<?PHP
if(isset($_GET['action'])){
Session_destroy();
echo "You have logged out...";
?>
<script>
window.location.assign('<?php echo $DocPath; ?>auth/?message=Logout%20Sucessful');
</script>
<?PHP
}

if(isset($_POST['email'])&&isset($_POST['password'])){
$email = strtolower($_POST['email']);

$authquery = mysqli_query($con, "SELECT * 
FROM  `users` 
WHERE `Email` = '$email'
ORDER BY  `UserID` DESC 
LIMIT 0 , 99") or die ('Unable to execute query. '. mysqli_error($con));
$authresult = mysqli_fetch_array($authquery);
if (password_verify($_POST['password'], $authresult['Password'])){
echo "Authentication Sucessful!<br/>Please Wait...";
$_SESSION['CUID'] = $authresult['UserID'];
$_SESSION['NAME'] = $authresult['Name'];
if ($authresult['Admin'] = True){
$_SESSION['IA'] = True;
}
else {
$_SESSION['IA'] = False;
}
?>
<script>
window.location.assign("<?php echo $DocPath; ?>browser/");
</script>
<?PHP
}
else {
echo "Login incorrect";?>
<script>
window.location.assign("<?php echo $DocPath; ?>auth/?message=Password%20Incorrect");
</script>
<?PHP
}
mysqli_close($con);
}
else {?>
?>
<script>
window.location.assign('<?php echo $DocPath; ?>auth/');
</script><?PHP } ?>

