<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>

	<div id="container">	<div id="content" class="widecolumn">

<h2>Links:</h2>
<ul>
<?php wp_list_bookmarks(); ?>
</ul>


		</div><!-- #content -->
	</div><!-- #container -->
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . "/sidebar2.php"); ?>	


<?php get_footer(); ?>
