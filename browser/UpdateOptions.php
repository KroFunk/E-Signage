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
<?php

if(isset($_POST['Action'])){




///////////////////
// Create Editor //
///////////////////

if($_POST['Action'] == 'CreateEditor') {
if(isset($_POST['EsignID'])) {

echo "<input id='InfoButtonOptions' class='InfoButton' type='button' onclick='UpdateOptions();' value='Save Changes' style='display:none;' /><textarea></textarea>";


}
else {
echo "EsignID missing";
}
}







/////////////////////////////////////////
// Update the database entry for esign //
/////////////////////////////////////////

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







/////////////////////////////////////////
// Create the database entry for esign //
/////////////////////////////////////////

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







/////////////////////////////////////////
// Delete the database entry for esign //
/////////////////////////////////////////

if($_POST['Action'] == 'DeleteEsign') {
if(isset($_POST['ESignID']) && isset($_POST['Description'])) {


$esign_id = htmlentities($_POST['ESignID']);
$Description = htmlentities($_POST['Description']);

mysqli_query($con, "DELETE FROM `esign`.`esigns` WHERE `esigns`.`esign_id` = $esign_id") or die ('Unable to execute query. '. mysqli_error($con));
echo "<input id='InfoButtonOptions' class='InfoButton' type='button' onclick='UpdateOptions();' value='Save Changes' style='display:none;' /><div style='padding-top:10px;' class='updatemessage'>" . $Description . " Deleted!</div>";
echo "<script>
    setTimeout(function(){ 
    parent.closewrapper(); 
    parent.SelectContainer('deselect', `Signs`, `E-Sign`);
    parent.CreateContainers('ListSigns');
    }, 1000);
</script>";
}
else {
echo "EsignID missing";
}
}







///////////////////////////////////
// Create Options and Audit tabs //
///////////////////////////////////

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





///////////////////////////////////
// Create Containers for E-Signs //
///////////////////////////////////

if($_POST['Action'] == 'ListSigns') {


$query = mysqli_query($con, "SELECT * FROM `$SQLDB`.`esigns`;") or die ('Unable to execute query. '. mysqli_error($con));

while($result = mysqli_fetch_array($query)){
echo '<div class="EsignContainer" id="' . $result['esign_id'] . '" ondblclick="javascript:NavigateSign(' . $result['esign_id'] . ', `' . $result['sign_location'] . '`)" onblur="SelectContainer(' . "'deselect'" . ', `Signs`, `E-Sign`);" onclick="javascript:SelectContainer(' . $result['esign_id'] . ', `Signs`, `E-Sign`);">
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
echo '<div class="EsignContainerPlus" id="containerplus" onclick="javascript:SelectContainer(' . "'deselect'" . ', `Signs`, `E-Sign`); openwrapper(' . "'UpdateOptions.php?Action=NewSigns'" . ', 300, 240);"></div>';
}








/////////////////////////
// List E-Sign Content //
/////////////////////////

if($_POST['Action'] == 'ListContent') {


$query = mysqli_query($con, "SELECT * FROM `$SQLDB`.`content` WHERE `esign_id` = 1 ORDER BY `priority` ASC;") or die ('Unable to execute query. '. mysqli_error($con));

while($result = mysqli_fetch_array($query)){
echo '<div class="EsignContainer" id="' . $result['content_id'] . '" ondblclick="javascript:NavigateSign(' . $result['content_id'] . ')" onblur="SelectContainer(' . "'deselect'" . ', `Content`, `Content`);" onclick="javascript:SelectContainer(' . $result['content_id'] . ', `Content`, `Content`);">
<div class="EsignContainerContent">
<!--img-->
</div>
<div class="EsignContainerDescription">
<table style="font-size:inherit; color:inherit;">
<tr><td align="right">Location:</td><td class="truncate" align="left"><div id="EsignContainerDescriptionLocation' . $result['content_type'] . '">' . $result['content_type'] . '</div></td></tr>
<tr><td align="right">Description:</td><td align="left"><div class="truncate" id="EsignContainerDescriptionDescription' . $result['description'] . '">' . $result['description'] . '</div></td></tr>
</table>
</div>
</div>';
}
echo '<div class="EsignContainerPlusContent" id="containerplus" onclick="javascript:SelectContainer(' . "'deselect'" . ', `Content`, `Content`); openwrapper(' . "'UpdateOptions.php?Action=NewContent'" . ', 840, 580);"></div>';
}


















}
else {
//echo "Action missing";
//echo "<form action='' method='POST'><input type='hidden' name='Action' value='ListSigns' /><input type='submit' /></form>";











if (isset($_GET['Action'])) {





////////////////////////////////
// Form for Creating  E-Signs //
////////////////////////////////

if ($_GET['Action'] == "NewSigns") {
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

//content_id
//esign_id
//content_type*
//content
//description
//autosave
//locked
//UserID
//priority
//status*

////////////////////////////////
// Form for Creating  Content //
////////////////////////////////

if ($_GET['Action'] == "NewContent") {
echo "
<div style='display:none; position:absolute; z-index:999; width:175px; overflow-y:scroll; overflow-x:hidden; background:white; border:1px solid #ccc; border-bottom:0px; border-radius:2px; #000; top:95px; left:100px;' id='contenttypelist'>
<div class='ListItem' onclick='document.getElementById(`contenttypelist`).style.display = `none`; document.getElementById(`ContentTypeText`).value = `Text`'>Text</div>
<div class='ListItem' onclick='document.getElementById(`contenttypelist`).style.display = `none`; document.getElementById(`ContentTypeText`).value = `Image`'>Image</div>
<div class='ListItem' onclick='document.getElementById(`contenttypelist`).style.display = `none`; document.getElementById(`ContentTypeText`).value = `Video`'>Video</div>
</div>

<div id='InfoLocation' style='padding-top:10px'>New Content</div>
<div style='float:left;width:300px; margin-top:10px;'>
&nbsp;Content Options:
<form method='POST' style='padding:0;margin:0;' action=''><div style='margin:0 auto; width:290px; padding-top:10px;'><table>
<tr>
<td><span class='InfoLabel'>Content Type</span></td>
<td><input name='ContentType' onclick='document.getElementById(`contenttypelist`).style.display = `block`;' style='border:1px solid #ccc; border-radius:2px; background:#fff; padding:5px;' id='ContentTypeText' maxlength='25' class='InfoTextBox' type='textbox' value='" . '' . "' /></td>
</tr><tr>
<td><span class='InfoLabel'>Description</span></td><td><input name='Description' style='border:1px solid #ccc; border-radius:2px; background:#fff; padding:5px;' id='InfoDescription' maxlength='25' class='InfoTextBox' type='textbox' value='" . '' . "' /></td>
</tr><tr>
<td><span class='InfoLabel'>Status</span></td><td><input name='Description' style='border:1px solid #ccc; border-radius:2px; background:#fff; padding:5px;' id='InfoDescription' maxlength='25' class='InfoTextBox' type='textbox' value='" . '' . "' /></td>
</tr></table></div>
<input name='Action' type='hidden' value='" . 'CreateEsign' . "' />
<div id='InfoSubmitButton' style='text-align:center'>
<input id='InfoButtonOptions' class='InfoButton InfoButtonBlue' type='submit' value='Create Content' style='display:inline;' />
</div></form>
</div>

<div style='float:right;width:520px; margin-top:10px;'>
Content:<br>Please select a content type!
</div>


";
}




////////////////////////////////
// Form for Deleting  E-Signs //
////////////////////////////////
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