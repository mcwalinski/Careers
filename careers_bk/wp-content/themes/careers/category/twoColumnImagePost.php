<?php $preview = getString($_GET['preview']);?>
<?php //get_header(); ?>
            <!-- "page" beings in header <div id="page">-->
            	<?php $postid = getSinglePostForCategory($postid,$category_name);?>
            	<?php $postcat = single_cat_title("", false); ?>
                <?php $posttitle = single_post_title('', false); ?>
                <?php get_sidebar(); ?>
                <div id="pageBody">
                    <?php if ($preview != ""){ ?>
                        <h1 class="unloopHeadline"><?php echo $posttitle ?></h1>
                    <?php } else { ?>
                        <?php $ptitle = getPostTitle(&$ptitle, $postid); ?>
                        <h1 class="unloopHeadline"><?php echo $ptitle ?></h1>
                    <?php } ?>
                    <?php if (hasYAPB($postid) == true){ ?>
                        <div id="yapbMain">
                            <?php yapbImg($postid);?>
                        </div>
                    <?php } ?>
                    <?php include (TEMPLATEPATH . "/rightRail.php"); ?>
                    <div id="content" class="twoCol">
                        <?php query_posts("p=$postid"); ?>
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="post" id="post-<?php the_ID(); ?>">
                                    <?php the_content(); ?>
                                </div>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <h1 class="center">Not Found</h1>
                            <p class="center">Sorry, but you are looking for something that isn't here.</p>
                            <?php include (TEMPLATEPATH . "/searchform.php"); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="floatClear">&nbsp;</div>
            </div><!-- end "page" -->
