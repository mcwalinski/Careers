<?php $postcat = getString($_GET['category_name']); ?>
<?php get_header(); ?>
            <!-- "page" beings in header <div id="page">-->
                <?php get_sidebar(); ?>
                <div id="pageBody">
                    <div id="content" class="oneCol">
                        <!-- gets main post content -->
                        <?php $postid = getSinglePostForCategory($postid,$category_name);?>
                        <?php query_posts("p=$postid"); ?>
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="post" id="post-<?php the_ID(); ?>">
                                    <h1><?php the_title(); ?></h1>
                                    <?php the_content(); ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>

                        <!-- gets list of posts -->
                        <?php $cat = $category_name . "item"; ?>
                        <?php query_posts(array(
                            'category_name' => $cat,
                            'orderby' => 'title',
                            'order'=>'ASC'
                            )); ?>
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="yapbProfile" id="post-<?php the_ID(); ?>" style="background-image:url('<?php yapbImgSrc(); ?>');">
                                    <p><a href="?category_name=<?php echo $postcat; ?>&subcatpost=<?php the_ID(); ?>"><?php the_title(); ?></a></p>
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="floatClear">&nbsp;</div>
            </div><!-- end "page" -->
