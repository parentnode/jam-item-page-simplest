<?php
global $module_group_id;
global $module_id;

$module = module()->getModule($module_group_id, $module_id);

$IC = new Items();
$module_class = $IC->typeObject("page");


//
$default_controller = "/pages.php";



$all_controllers = $fs->files(LOCAL_PATH."/www", [
	"deny_folders" => "janitor,js,img,assets", 
	"allow_extensions" => "php"
]);
$page_controllers = [];

	// TODO: delete any modified controllers
	debug(["possible modified controllers", $controllers]);

foreach($all_controllers as $controller) {
	$read_access = true;
	include($controller);
	if(isset($itemtype) && $itemtype === "page") {
		$page_controllers[] = str_replace(LOCAL_PATH."/www", "", $controller);
	}
}



?>
<div class="scene module i:module pageitem i:pageitem">
	<h1>Itemtype page</h1>
	<h2>Configuration</h2>

	<?= HTML()->renderSnippet("snippets/modules/actions-back.php") ?>

	<h3>Module description</h3>
	<?= HTML()->renderSnippet("snippets/modules/panel-info.php", [
		"module" => $module,
	]) ?>

	// TODO
	// Make it possible to create multiple controllers here
	// It will just make duplicates of main module frontend controller
	// Test if controller already exists as you type

	<h3>Page controllers</h3>
	<ul class="controllers">
		<? foreach($page_controllers as $controller): ?>
		<li><?= $controller ?></li>
		<? endforeach;	?>
	</ul>

	<?= $module_class->formStart("modules/updateSettings/item/page", array("class" => "labelstyle:inject")) ?>
		<fieldset>
			<?= $module_class->input("new_controller_path", array("label" => "New controller")) ?>

		</fieldset>

		<ul class="actions">
			<?= $module_class->submit("Save", array("wrapper" => "li.save", "class" => "primary")) ?>
			<?//= $module_class->link("Cancel", "modules", array("class" => "button key:esc", "wrapper" => "li.cancel")) ?>

			<?= $module_class->oneButtonForm("Restore defaults", "modules/restoreDefaults/item/page", array(
				"confirm-value" => "Are you sure?",
				"inputs" => [
					"default_controller" => $default_controller,
				],
				"wrapper" => "li.restore",
				"class" => "secondary",
				// "success-location" => "/janitor/admin/member/view/".$user_id
			)) ?>

		</ul>

	<?= $module_class->formEnd() ?>

	<?= HTML()->formStart("updateSettings") ?>
		<fieldset>
			<?= HTML()->input("default_view_path", [
				"label" => "Default page viewer path",
				"value" => $module["settings"]["default_view_path"] ?? "",
			]) ?>
		</fieldset>
	<?= HTML()->formEnd() ?>

	<?= HTML()->renderSnippet("snippets/modules/panel-version.php", [
		"module" => $module,
	]) ?>
	<?= HTML()->renderSnippet("snippets/modules/panel-upgrade.php", [
		"module" => $module,
	]) ?>
	<?= $HTML->renderSnippet("snippets/modules/panel-uninstall.php",  [
		"module" => $module,
	]) ?>

</div>