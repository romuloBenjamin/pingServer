<?php 
//GET PAGE
function get_slug($entry)
{}
//GET PAGE INNER
function get_slug_inner($entry)
{}
//GET SQL
function call_sql($file)
{ include(DIR_PATH."cnt-sql/".DIR_SQL."/main".ucfirst(DIR_SQL).DIR_EXT); }
//GET HTML
function call_html($files)
{ include(DIR_PATH."cnt-html/".$files.DIR_EXT); }
//GET FOLDER
function call_folder($folder, $file)
{ include(DIR_PATH."cnt-modules/".$folder."-module/".$file.DIR_EXT); }
function call_jfolder($folder, $file)
{ include(DIR_JPATH."cnt-modules/".$folder."-module/".$file.DIR_EXT); }
//GET SUBFOLDER
function call_SubFolder($folder, $sFolder, $file)
{ include(DIR_PATH."cnt-modules/".$folder."-module/".$sFolder."/".$file.DIR_EXT); }
function call_jSubFolder($folder, $sFolder, $file)
{ include(DIR_JPATH."cnt-modules/".$folder."-module/".$sFolder."/".$file.DIR_EXT); }
?>