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
	$media = $IC->sliceMediae($item, "single_media");
	 ?>

	<div class="article i:article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"<?= HTML()->jsData(["readstate"]) ?>>

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $item,
			"media" => $media,
		]) ?>

		<? /*if($media): ?>
		<div class="image item_id:<?= $item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; */ ?>


		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => ["page"]
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


		<?= HTML()->renderSnippet("snippets/comments.php", [
			"item" => $item
		]) ?>

	</div>

<? else: ?>

	<h1>Technology clearly doesn't solve all problems.</h1>
	<h2>Technology needs humanity.</h2>
	<p>We could not find the specified service.</p>

<? endif; ?>

</div>
