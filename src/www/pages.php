<?php
$itemtype = "page";

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

// TODO
// find way to identify this file as main page item controller, so it can be cleaned up and so input on settings page can be updated without storing info in third place. Info for settings page will then rely on folder scan


include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();



// news list for tags
// /pages/#sindex#
if(count($action) == 1) {

	$page->page(array(
		"templates" => "pages/view.php"
	));
	exit();

}

$page->page(array(
	"templates" => "pages/404.php"
));
exit();

?>
