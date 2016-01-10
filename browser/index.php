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
<script>
function openwrapper(url, x, y){
// Show popup elements
document.getElementById('iframewrapper').className='block'; 
document.getElementById('grey').className='block';

// Resize elements
document.getElementById('iframewrapper').style.width=x + "px";
document.getElementById('iframewrapper').style.height=y + "px";
document.getElementById('Iframe').style.height=(y - 10) + "px";

// Position elements
document.getElementById('iframewrapper').style.marginLeft="-" + (x / 2) + "px";
document.getElementById('iframewrapper').style.marginTop="-" + (y / 2) + "px";
document.getElementById('iframeX').style.left=(x - 15) + "px";

// Stop scroll event 'bubble'
 document.getElementById('Iframe').src = url;
$('#Iframe').on('mousewheel DOMMouseScroll', function(ev) {
ev.preventDefault();
});
}

function closewrapper() { //will close the window without refreshing the page. 
// hide popup elements
document.getElementById('iframewrapper').className='none'; 
document.getElementById('grey').className='none';
}

function reloadparent() { //reloads parent window, for use from wrapper
location.reload();
}


// Update options
function UpdateOptions()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("InfoSubmitButton").innerHTML=xmlhttp.responseText;
    document.getElementById("InfoLocation").innerHTML=document.getElementById("InfoLocationText").value;
    var ThisID = document.getElementById("InfoEsignID").value;
    document.getElementById("EsignContainerDescriptionLocation" + ThisID).innerHTML=document.getElementById("InfoLocationText").value;
    document.getElementById("EsignContainerDescriptionDescription" + ThisID).innerHTML=document.getElementById("InfoDescription").value;
    //document.getElementById("").innerHTML=document.getElementById("").value;
    }
  }
  
  Description = document.getElementById("InfoDescription").value;
  Location = document.getElementById("InfoLocationText").value;
  Icon = document.getElementById("InfoIcon").value;
  EsignID = document.getElementById("InfoEsignID").value;
  
xmlhttp.open("POST","UpdateOptions.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("Action=UpdateEsign&Description=" + Description + "&Location=" + Location + "&Icon=" + Icon + "&EsignID=" + EsignID);
}


//Populate the Options tab
function CreateOptions(id) {
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("InfoOptions").innerHTML=xmlhttp.responseText;
    document.getElementById('InfoLocation').innerHTML = document.getElementById('InfoLocationText').value;
    }
  }
  
xmlhttp.open("POST","UpdateOptions.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("Action=CreateOptions&EsignID=" + id);
}



// adjust height of content windows when the viewport loads and or resized
window.onload = function expandHeight() {
var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

document.getElementById('InfoWindow').style.height = (h - 110);
document.getElementById('InfoWindowContainer').style.height = (h - 150);
document.getElementById('ContentWindow').style.height = (h - 110);
document.getElementById('ContentWindow').style.width = (w - 310);

CreateContainers('ListSigns');
}
window.onresize = function() {
h = window.innerHeight;
w = window.innerWidth;
//alert(window.innerHeight);
document.getElementById('InfoWindow').style.height = (h - 110);
document.getElementById('InfoWindowContainer').style.height = (h - 150);
document.getElementById('ContentWindow').style.height = (h - 110);
document.getElementById('ContentWindow').style.width = (w - 310);
}

//show an display:none element
function EnableSubmit(id) {
document.getElementById(id).style.display="inline";
}

//Select or deselect containers
var selected = 'nothing';
var AuditOptionsMessage = "Select an E-Sign from the browser to view its options";
function SelectContainer(container, context, language) {
if (container == 'deselect') {
if (selected !== 'nothing'){
document.getElementById(selected).className = "EsignContainer";
selected = 'nothing';
document.getElementById('InfoAudit').innerHTML = AuditOptionsMessage;
document.getElementById('InfoOptions').innerHTML = AuditOptionsMessage;
document.getElementById('InfoLocation').innerHTML = "E-Signage Browser";
document.getElementById('Functions').innerHTML = '<a href="#" onclick="CreateContainers(' + "'List" + context + "'" + ');">Reload ' + language + '</a><a href="#" onclick="openwrapper(' + "'UpdateOptions.php?Action=New" + context + "'" + ', 300, 240);">Create New ' + language + '</a>';
}
}
else {
if (document.getElementById(container).className == "EsignContainer") {
document.getElementById(container).className = "EsignContainerSelected";
//document.getElementById('InfoOptions').innerHTML = ""; //this is where I was setting option content before. 


//create options window
CreateOptions(container);

//create audit winodw
document.getElementById('InfoAudit').innerHTML = "woo audit";


//update top menu
document.getElementById('Functions').innerHTML = '<a href="#" onclick="CreateContainers(' + "'List" + context + "'" + ');">Reload ' + language + '</a><a href="#" onclick="SelectContainer(' + "'deselect'" + ');">Deselect ' + language + '</a><a href="#" onclick="openwrapper(' + "'UpdateOptions.php?Action=Delete" + context + "&ESign=" + container + "'" +', 300, 240);">Delete ' + language + '</a>';


if (selected !== 'nothing'){
document.getElementById(selected).className = "EsignContainer";
}
selected = container;
}
else {
document.getElementById(container).className = "EsignContainer";
selected = 'nothing';
document.getElementById('InfoAudit').innerHTML = AuditOptionsMessage;
document.getElementById('InfoOptions').innerHTML = AuditOptionsMessage;
document.getElementById('InfoLocation').innerHTML = "E-Signage Browser";
document.getElementById('Functions').innerHTML = '<a href="#" onclick="CreateContainers(' + "'List" + context + "'" + ');">Reload ' + language + '</a><a href="#" onclick="openwrapper(' + "'UpdateOptions.php?Action=New" + context + "'" + ', 300, 240);">Create New ' + language + '</a>';
}
}
}


function CreateContainers(type,id) {
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("ContentWindow").innerHTML=xmlhttp.responseText;
    
    if (selected !== 'nothing'){
    document.getElementById(selected).className = "EsignContainerSelected";
    }
    
    }
  }
  
xmlhttp.open("POST","UpdateOptions.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("Action=" + type + "&ID=" + id);
}




// info window tab selection
function InfoTab(select, remove) {
document.getElementById(select).className = "InfoOptionsAndAudit TabSelected";
document.getElementById(remove).className = "InfoOptionsAndAudit";
document.getElementById('Info' + select).style.display = 'block';
document.getElementById('Info' + remove).style.display = 'none';
}

// Doubleclick navigation
function NavigateSign(sign, location) {
//window.location.assign('<?php echo $DocPath; ?>browser/?show=single&sign=' + sign);
CreateContainers('ListContent',sign)
document.getElementById('Path').innerHTML = document.getElementById('Path').innerHTML + ' &rsaquo; ' + location;
}

// Reset the path box 
function ResetPath(){
document.getElementById('Path').innerHTML = "E-Signage &rsaquo; <a href='#' style='color:white;' onclick='CreateContainers(`ListSigns`);ResetPath();'>Signs</a>";
}

// Search box aesthetics 
var BnClicked = false;
function HoverSearch(status) {
if(status === "blur"){
BnClicked = false;
document.getElementById("SearchBox").className = "SearchBox SearchBoxStandard";
document.getElementById("SearchButton").className = "SearchButton SearchButtonStandard";
}
if(status === "on" && BnClicked === false) {
document.getElementById("SearchBox").className = "SearchBox SearchBoxLight";
document.getElementById("SearchButton").className = "SearchButton SearchButtonLight";
}
else if (status === "off" && BnClicked === false){
document.getElementById("SearchBox").className = "SearchBox SearchBoxStandard";
document.getElementById("SearchButton").className = "SearchButton SearchButtonStandard";
}
else if (status === "clicked"){
document.getElementById("SearchBox").className = "SearchBox SearchBoxClicked";
document.getElementById("SearchButton").className = "SearchButton SearchButtonClicked";
BnClicked = true;
}
}

</script>
</head>
<body style="margin:0px; padding:0px;">
<?php require ('../includes/menu.inc');?>
<div id="ContentWindow" style="height:400px;">







Please reload containers.








</div>

<div id="InfoWindow" style="">

<div id="InfoWindowContainer">

<div id="InfoLocation">E-Signage Browser</div>
<div id="Options" class="InfoOptionsAndAudit TabSelected" onclick="InfoTab('Options', 'Audit')">Options</div>
<div id="Audit" class="InfoOptionsAndAudit" onclick="InfoTab('Audit', 'Options')">Audit</div>


<div id="InfoOptions" style="display:block; text-align:center;">Select an E-Sign from the browser to view its options</div>

<div id="InfoAudit" style="display:none; text-align:center;">Select an E-Sign from the browser to view its audit</div>




</div>

</div>


<!--
###########################################################################
######################### Iframe Section  Start ###########################
###########################################################################
-->

<!-- Grey out background -->
<div id="grey" class='none' onclick="closewrapper();">&nbsp;</div>

<!-- The white box that the window will reside in -->
<div id="iframewrapper" class='none'  style="width: 750px; height: 230px; margin-left: -375px; margin-top: -95px;">

<!-- The 'X' button -->
<a href="javascript:void(0);" onclick="closewrapper();">
<img id="iframeX" src="../styles/images/X.png" style="position:relative; top:-10px; left:735px; border:0 none;">
</a>

<!-- Actual iFrame container -->
<div id="IframeContainer" style="clear:both; padding:20px; padding-left:0px; margin-top:-50px;">
<iframe id="Iframe" style="margin:10px; height:220px; width:100%;" border="0" frameborder="0"></iframe>
</div>

</div>
 
<!--
###########################################################################
########################## Iframe Section  End ############################
###########################################################################
-->
</body>
</HTML>