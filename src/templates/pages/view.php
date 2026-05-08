<?php
global $action;

$IC = new Items();
$itemtype = "page";

$sindex = $action[0];

$item = $IC->getItem([
	"sindex" => $sindex, 
	"status" => 1, 
	"extend" => [
		"tags" => true, 
		"user" => true, 
		"mediae" => true, 
		"comments" => true, 
		"readstate" => true
	]
]);

if($item) {
	$this->pageTitle($item["name"])
	$page->bodyClass($item["classname"] || "pages");
	$this->sharingMetaData($item);
}

?>

<div class="scene page i:scene">


<? if($item):
	$media = $IC->sliceMediae($item, "single_media"); ?>

	<div class="article i:article id:<?= $item["item_id"] ?> service" itemscope itemtype="http://schema.org/Article"
		data-csrf-token="<?= session()->value("csrf") ?>"
		data-readstate="<?= $item["readstate"] ?>"
		data-readstate-add="<?= security()->validPath("/janitor/admin/profile/addReadstate/".$item["item_id"]) ?>" 
		data-readstate-delete="<?= security()->validPath("/janitor/admin/profile/deleteReadstate/".$item["item_id"]) ?>" 
		>

		<? if($media): ?>
		<div class="image item_id:<?= $item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>


		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => ["page"]
		]) ?>


		<h1 itemprop="headline"><?= $item["name"] ?></h1>


		<?= $HTML->renderSnippet("snippets/info.php", [
			"item" => $item,

			// TODO
			// Make dynamic somehow – if controller is not called pages, then what

			// – and if there are more pages controllers, how can cannonical url become unique
			"url" => "/pages/".$item["sindex"],
			"media" => $media,
			"sharing" => true
		]) ?>



		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>


		<?= $HTML->frontendComments($item, "/janitor/page/addComment") ?>

	</div>

<? else: ?>

	<h1>Technology clearly doesn't solve all problems.</h1>
	<h2>Technology needs humanity.</h2>
	<p>We could not find the specified service.</p>

<? endif; ?>

</div>
