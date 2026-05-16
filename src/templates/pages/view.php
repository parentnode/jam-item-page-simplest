<?php
global $action;

$IC = new Items();
$itemtype = "page";

$sindex = $action[0];

$item = $IC->getItem([
	"sindex" => $sindex, 
	"status" => 1,
	"historic" => true,
	"extend" => [
		"tags" => true, 
		"user" => true, 
		"mediae" => true, 
		"comments" => true, 
		"readstate" => true
	]
]);

if($item) {
	$this->pageTitle($item["name"]);
	$this->bodyClass($item["classname"] ? $item["classname"] : "pages");
	$this->sharingMetaData($item);
}

?>

<div class="scene page i:scene">

<? if($item):
	$media = $IC->sliceMediae($item, "single_media"); ?>

	<div class="article i:article id:<?= $item["item_id"] ?> page" itemscope itemtype="http://schema.org/Article"<?= HTML()->jsData(["readstate"]) ?>>

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $item,
			"media" => $media,
		]) ?>


		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => [$itemtype]
		]) ?>


		<h1 itemprop="headline"><?= $item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/info.php", [
			"item" => $item,
			"media" => $media,
			"sharing" => true
		]) ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>

	</div>

<? else: ?>

	<h1>Technology is limited</h1>
	<p>We could not find the specified service.</p>

<? endif; ?>

</div>
