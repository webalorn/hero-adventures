<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/news.php');

template_getHeaderPart1("News.php");
?>
<style>
	.newsTitre
	{
		display: inline-block;
		font-size: 150%;
		margin: 0px;
		margin-right: 20px;
	}
	.newsDate
	{
		display: inline-block;
		font-style: italic;
	}
	.newsCont
	{
		overflow: hidden;
		padding: 15px;
		padding-left: 25px;
		display: none;
		border-left: 2px solid rgb(139, 139, 139);
	}
	.news > header
	{
		padding: 15px;
		cursor: pointer;
		border-radius: 9px;
	}
	.news > header:hover
	{
		background: rgba(255, 255, 255, 0.1);
	}
</style>
<?php
template_getHeaderPart2();
?>
<p>
    Le site est toujours en devellopement! Vous trouverez ici, de temps en temps, les avances, visibles ou non, de son devellopement.
</p>
<hr />
<?php

$news = getNews();

foreach ($news as $new) {
	?>
	<article class="news">
		<header>
			<h3 class="newsTitre"><?php echo $new['titre']; ?></h3>
			<span class="newsDate"><?php echo $new['date']; ?></span>
		</header>
		<div class="newsCont"><?php echo $new['contenu']; ?></div>
	</article>
	<?php
}
?>
<script>
	$(function(){
		$(".news > header").click(function(){
			var elem = $(this).parents(".news").find(".newsCont");
			var ouvrir = (elem.css("display") == "none");
			$(".newsCont").css("display", "none");
			if (ouvrir)
				elem.css('display', 'block');
		});
	});
</script>
<?php

template_getFooter();

?>
