<?php get_header(); ?>
            <!-- "page" beings in header <div id="page">-->
            	<?php $postid = getSinglePostForCategory($postid,$category_name);?>
                <?php get_sidebar(); ?>
                <div id="pageBody">
                    <?php include (TEMPLATEPATH . "/rightRail.php"); ?>
                    <div id="content" class="twoCol">
                        <?php //$postid = getSinglePostForCategory($postid,$category_name);?>
                        <?php query_posts("p=$postid"); ?>
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="post" id="post-<?php the_ID(); ?>">
                                    <h1><?php the_title(); ?></h1>
                                    <?php the_content(); ?>
                                </div>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <h1 class="center">Not Found</h1>
                            <p class="center">Sorry, but you are looking for something that isn't here.</p>
                            <?php include (TEMPLATEPATH . "/searchform.php"); ?>
                        <?php endif; ?>
                    </div>
                </div><!-- end "pageBody" -->
                <div class="floatClear">&nbsp;</div>
            </div><!-- end "page" -->
