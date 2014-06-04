<?php
/*
Template Name: Latest 
*/
?>

<?php include (TEMPLATEPATH . "/header2.php"); ?>

	<div id="container">	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		</div><!-- #content -->
	</div><!-- #container -->
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . "/sidebar2.php"); ?>	


<?php get_footer(); ?>
