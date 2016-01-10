<div id="TopMenu">
<div id="logo"><img src='../styles/images/logo.png' alt='E-Signage'></div>
<div id="SeachContainer">
<form id="SearchForm">
<input id="SearchBox" onblur="HoverSearch('blur')" onclick="HoverSearch('clicked')" onmouseover="HoverSearch('on')" onmouseout="HoverSearch('off')" class="SearchBox SearchBoxStandard" type="text" name="search" />
<input id="SearchButton" onclick="HoverSearch('clicked')" onmouseover="HoverSearch('on')" onmouseout="HoverSearch('off')" class="SearchButton SearchButtonStandard" type="submit" name="searchButton" value="Search!" />
</form>
</div>
<div id="LogoutSection">Logged in as <?php echo $_SESSION['NAME']; ?></div>
</div>

<div id="MainMenu">

<div id="Path">E-Signage &rsaquo; <a href="#" style='color:white;' onclick="CreateContainers('ListSigns');ResetPath();">Signs</a></div>

<div id="Functions">
<a href="#" onclick="CreateContainers('ListSigns');">Reload E-Signs</a>
<a href="#" onclick="openwrapper('UpdateOptions.php?Action=NewSign', 300, 240);">Create new E-Sign</a>
</div>

</div>
