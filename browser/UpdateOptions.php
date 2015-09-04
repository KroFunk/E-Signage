<?php
session_start();
require ('../config/config.php');
require ('../includes/authcheck.php');

?>
<HTML>
<head><meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link href='../styles/admin.css.php' rel='stylesheet' type='text/css'>
<title>E-Signage | Browser </title>
<script src='../includes/jquery.min.js'></script>
</head>
<body style="margin:0px; padding:0px;">
<?

if(isset($_POST['Action'])){




//////////\\\\\\\\\
// Create Editor \\
//////////\\\\\\\\\

if($_POST['Action'] == 'CreateEditor') {
if(isset($_POST['EsignID'])) {

echo "<input id='InfoButtonOptions' class='InfoButton' type='button' onclick='UpdateOptions();' value='Save Changes' style='display:none;' />

<textarea>

</textarea>


";

}
else {
echo "EsignID missing";
}
}







////////////////////\\\\\\\\\\\\\\\\\\\\\
// Update the database entry for esign \\
////////////////////\\\\\\\\\\\\\\\\\\\\\

if($_POST['Action'] == 'UpdateEsign') {
if(isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['EsignID'])) {

$Description = htmlentities($_POST['Description']);
$Location = htmlentities($_POST['Location']);
$Icon = htmlentities($_POST['Icon']);
$EsignID = htmlentities($_POST['EsignID']);

mysqli_query($con, "UPDATE `$SQLDB`.`esigns` SET `sign_description` = '$Description', `sign_location` = '$Location', `sign_icon` = '$Icon' WHERE `esigns`.`esign_id` = $EsignID;") or die ('Unable to execute query. '. mysqli_error($con));
echo "<input id='InfoButtonOptions' class='InfoButton' type='button' onclick='UpdateOptions();' value='Save Changes' style='display:none;' /><div style='padding-top:10px;' class='updatemessage'>" . $Location . " Updated!</div>";
}
else {
echo "Description, Location or EsignID missing";
}
}







////////////////////\\\\\\\\\\\\\\\\\\\\\
// Create the database entry for esign \\
////////////////////\\\\\\\\\\\\\\\\\\\\\

if($_POST['Action'] == 'CreateEsign') {
if(isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Icon'])) {


$Description = htmlentities($_POST['Description']);
$Location = htmlentities($_POST['Location']);
$Icon = htmlentities($_POST['Icon']);

mysqli_query($con, "INSERT INTO `esign`.`esigns` (`esign_id`, `sign_description`, `sign_location`, `sign_icon`) VALUES (NULL, '$Description', '$Location', '$Icon');") or die ('Unable to execute query. '. mysqli_error($con));
echo "<input id='InfoButtonOptions' class='InfoButton' type='button' onclick='UpdateOptions();' value='Save Changes' style='display:none;' /><div style='padding-top:10px;' class='updatemessage'>" . $Location . " Created!</div>";
echo "<script>
    setTimeout(function(){ 
    parent.closewrapper(); 
    parent.CreateContainers('ListSigns');
    }, 1000);
</script>";
}
else {
echo "Description, Location or EsignID missing";
}
}







////////////////////\\\\\\\\\\\\\\\\\\\\\
// Delete the database entry for esign \\
////////////////////\\\\\\\\\\\\\\\\\\\\\

if($_POST['Action'] == 'DeleteEsign') {
if(isset($_POST['ESignID']) && isset($_POST['Description'])) {


$esign_id = htmlentities($_POST['ESignID']);
$Description = htmlentities($_POST['Description']);

mysqli_query($con, "DELETE FROM `esign`.`esigns` WHERE `esigns`.`esign_id` = $esign_id") or die ('Unable to execute query. '. mysqli_error($con));
echo "<input id='InfoButtonOptions' class='InfoButton' type='button' onclick='UpdateOptions();' value='Save Changes' style='display:none;' /><div style='padding-top:10px;' class='updatemessage'>" . $Description . " Deleted!</div>";
echo "<script>
    setTimeout(function(){ 
    parent.closewrapper(); 
    parent.CreateContainers('ListSigns');
    }, 1000);
</script>";
}
else {
echo "EsignID missing";
}
}







/////////////////\\\\\\\\\\\\\\\\\\
// Create Options and Audit tabs \\
/////////////////\\\\\\\\\\\\\\\\\\

if($_POST['Action'] == 'CreateOptions') {
if(isset($_POST['EsignID'])) {
//(new messageboard) INSERT INTO `esign`.`esigns` (`esign_id`, `sign_description`, `sign_location`) VALUES (NULL, 'newdescription', 'newloaction');

$EsignID = $_POST['EsignID'];

$query = mysqli_query($con, "SELECT * FROM `$SQLDB`.`esigns` WHERE `esigns`.`esign_id` = $EsignID;") or die ('Unable to execute query. '. mysqli_error($con));

$result = mysqli_fetch_array($query);


echo "<div style='margin-top:50px;margin-bottom:20px;'><table cellpadding='5' cellspacing='0'>
<tr>
<td><span class='InfoLabel'>Location</span></td>
<td><input onfocus=" . '"EnableSubmit(' . "'InfoButtonOptions'" . ');"' . "id='InfoLocationText' maxlength='25' class='InfoTextBox' type='textbox' value='" . $result['sign_location'] . "' /></td>
</tr><tr>
<td><span class='InfoLabel'>Description</span></td><td><input onfocus=" . '"EnableSubmit(' . "'InfoButtonOptions'" . ');"' . "id='InfoDescription' maxlength='25' class='InfoTextBox' type='textbox' value='" . $result['sign_description'] . "' /></td>
</tr><tr><td><span class='InfoLabel'>Icon</span></td><td><input onfocus=" . '"EnableSubmit(' . "'InfoButtonOptions'" . ');"' . "id='InfoIcon' maxlength='255' class='InfoTextBox' type='textbox' value='" . $result['sign_icon'] . "' /></td>
</tr><tr><td style='border-top:1px solid #ccc; padding-top:5px;' valign='top'><span class='InfoLabel'>Path</span></td><td style='border-top:1px solid #ccc; padding-top:5px;'><span class='InfoLabel'>" . $DocPath . "?esign_id=" . $result['esign_id'] . "</span></td>
</tr></table></div>
<input id='InfoEsignID' type='hidden' value='" . $result['esign_id'] . "' />
<div id='InfoSubmitButton' style='text-align:center'>
<input id='InfoButtonOptions' class='InfoButton InfoButtonBlue' type='button' onclick='UpdateOptions();' value='Save Changes' style='display:none;' />
</div>";

}
else {
echo "EsignID missing";
}
}





/////////////////\\\\\\\\\\\\\\\\\\
// Create Containers for E-Signs \\
/////////////////\\\\\\\\\\\\\\\\\\

if($_POST['Action'] == 'ListSigns') {


$query = mysqli_query($con, "SELECT * FROM `$SQLDB`.`esigns`;") or die ('Unable to execute query. '. mysqli_error($con));

while($result = mysqli_fetch_array($query)){
echo '<div class="EsignContainer" id="' . $result['esign_id'] . '" ondblclick="javascript:NavigateSign(' . $result['esign_id'] . ')" onblur="SelectContainer(' . "'deselect'" . ');" onclick="javascript:SelectContainer(' . $result['esign_id'] . ');">
<div class="EsignContainerContent">
<img src="' . $result['sign_icon'] . '" />
</div>
<div class="EsignContainerDescription">
<table style="font-size:inherit; color:inherit;">
<tr><td align="right">Location:</td><td class="truncate" align="left"><div id="EsignContainerDescriptionLocation' . $result['esign_id'] . '">' . $result['sign_location'] . '</div></td></tr>
<tr><td align="right">Description:</td><td align="left"><div class="truncate" id="EsignContainerDescriptionDescription' . $result['esign_id'] . '">' . $result['sign_description'] . '</div></td></tr>
</table>
</div>
</div>';
}
echo '<div class="EsignContainerPlus" id="containerplus" onclick="javascript:SelectContainer(' . "'deselect'" . '); openwrapper(' . "'UpdateOptions.php?Action=NewSign'" . ', 300, 240);"></div>';
}





















}
else {
//echo "Action missing";
//echo "<form action='' method='POST'><input type='hidden' name='Action' value='ListSigns' /><input type='submit' /></form>";











if (isset($_GET['Action'])) {





////////////////\\\\\\\\\\\\\\\\
// Form for Creating  E-Signs \\
////////////////\\\\\\\\\\\\\\\\

if ($_GET['Action'] == "NewSign") {
echo "<div id='InfoLocation' style='padding-top:10px'>New E-Sign</div>
<form method='POST' style='padding:0;margin:0;' action=''><div style='margin:0 auto; width:242px; padding-top:10px;'><table>
<tr>
<td><span class='InfoLabel'>Location</span></td>
<td><input name='Location' style='border:1px solid #ccc; border-radius:2px; background:#fff; padding:5px;' onfocus=" . '"EnableSubmit(' . "'InfoButtonOptions'" . ');"' . "id='InfoLocationText' maxlength='25' class='InfoTextBox' type='textbox' value='" . '' . "' /></td>
</tr><tr>
<td><span class='InfoLabel'>Description</span></td><td><input name='Description' style='border:1px solid #ccc; border-radius:2px; background:#fff; padding:5px;' id='InfoDescription' maxlength='25' class='InfoTextBox' type='textbox' value='" . '' . "' /></td>
</tr><tr><td><span class='InfoLabel'>Icon</span></td><td><input name='Icon' style='border:1px solid #ccc; border-radius:2px; background:#fff; padding:5px;' id='InfoIcon' maxlength='255' class='InfoTextBox' type='textbox' value='" . '' . "' /></td>
</tr></table></div>
<input name='Action' type='hidden' value='" . 'CreateEsign' . "' />
<div id='InfoSubmitButton' style='text-align:center'>
<input id='InfoButtonOptions' class='InfoButton InfoButtonBlue' type='submit' value='Create E-Sign' style='display:inline;' />
</div></form>";
}



////////////////\\\\\\\\\\\\\\\\
// Form for Deleting  E-Signs \\
////////////////\\\\\\\\\\\\\\\\
if ($_GET['Action'] == "DeleteSign") {
$esign_id = $_GET['ESign'];
$query = mysqli_query($con, "SELECT * FROM `esigns` WHERE `esign_id` = $esign_id;") or die ('Unable to execute query. '. mysqli_error($con));

while($result = mysqli_fetch_array($query)){
echo "<div id='InfoLocation' style='padding-top:10px'>Delete E-Sign</div>
<div style='text-align:left; padding:10px;'>
Are you sure you want to delete <b>&quot;" . $result['sign_description'] . "&quot;</b>? 
<form method='POST' style='padding:0;margin:0;' action=''>
<div style='text-align:center;'>
<br><b>This cannot be undone!</b><br>
<input id='InfoButtonOptions' class='InfoButton InfoButtonRed' type='submit' value='Delete E-Sign' style='display:inline;' />
<input name='Action' type='hidden' value='" . 'DeleteEsign' . "' />
<input name='ESignID' type='hidden' value='" . $esign_id . "' />
<input name='Description' type='hidden' value='" . $result['sign_description'] . "' />
</div>
</form>
</div>";
}




}

















}








}
?>
</body>
</HTML>