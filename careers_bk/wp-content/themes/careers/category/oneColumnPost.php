<?php
    $subcatpost = getString($_GET['subcatpost']);
?>
<?php //get_header(); ?>
            <!-- "page" beings in header <div id="page">-->
                <?php get_sidebar(); ?>
                <div id="pageBody">
                    <div id="content" class="oneCol">
                    	<?php if ($subcatpost) :?>
                    		<?php $postid = $subcatpost;?>
                    	<?php else :?>
                        	<?php $postid = getSinglePostForCategory($postid,$category_name);?>
                        <?php endif;?>
                        <?php query_posts("p=$postid"); ?>
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="post" id="post-<?php the_ID(); ?>">
                                    <h1><?php the_title(); ?></h1>
                                    <?php the_content(); ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div><!-- end "pageBody" -->
                <div class="floatClear">&nbsp;</div>
            </div><!-- end "page" -->
