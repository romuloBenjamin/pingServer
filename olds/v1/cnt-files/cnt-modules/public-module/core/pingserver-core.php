<?php 
include("../../../cnt-php/defines.php");
include(DIR_JPATH."cnt-sql/".DIR_SQL."/main".ucfirst(DIR_SQL).DIR_EXT);
include(DIR_JPATH."cnt-modules/public-module/class/pingServerMods-class".DIR_EXT);
$geraStatus = new pingServer_modules(); echo $geraStatus->ping_compound($_POST["e"]);
?>