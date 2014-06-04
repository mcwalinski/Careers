<?php get_header(); ?>
            <!-- "page" beings in header <div id="page">-->
                <?php get_sidebar(); ?>
                <div id="pageBody">
                    <div id="content" class="oneCol">
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
                        <?php $itemposts = getMultipleFullPostListForCategory($category_name."item",10)?>
                        <?php if ($itemposts): ?>
                            <?php foreach ($itemposts as $item):?>
                                <?php setup_postdata($item);?>
                                <?php if(!hasExpired($item)): ?>
                                    <?php
                                        $hasImage = hasYAPB($item->ID);
                                        if ($hasImage===true){
                                            $cls = "postImage";
                                        } else if ($hasImage===false){
                                            $cls = "postWide";
                                        }
                                    ?>
                                    <?php $cat = getOtherCategoryForPost($item->ID,$category_name."item");?>
                                    <?php if ($cat == null){
                                        $cat = $category_name . "&subcatpost=$item->ID";
                                    } ?>
                                    <div id="listPost<?php the_ID();?>" class="listPost listPostOff" onmouseover="careers.swapListBG(<?php the_ID();?>);" onmouseout="careers.swapListBG(<?php the_ID();?>);">
                                        <?php if ($hasImage == true){ ?>
                                            <img class="listThumb" src="<?php yapbImgSrc($item->ID)?>" />
                                        <?php } ?>
                                        <div class="post <?php echo $cls ?> left" id="post-<?php the_ID();?>">
                                            <?php $related_link = get_post_meta($item->ID, "related_link", true); ?>
                                            <?php $window_type = get_post_meta($item->ID, "window_type", true); ?>
                                            <?php if (!$related_link){ ?>
                                                <h3><a href="?category_name=<?php echo $cat; ?>"><?php echo($item->post_title); ?></a></h3>
                                                <div id="excerpt-<?php the_ID();?>" class="excerpt">
                                                    <p><?php echo($item->post_excerpt); ?></p>
                                                </div>
                                            <?php } else if ($related_link){ ?>
                                                <h3><?php echo($item->post_title); ?></h3>
                                                <div id="excerpt-<?php the_ID();?>" class="excerpt">
                                                    <p><?php echo($item->post_excerpt); ?></p>
                                                </div>
                                                <?php if (!$window_type){ ?>
                                                    <a href="<?php echo $related_link ?>">Learn More &raquo;</a>
                                                <?php } else if ($window_type == 'new'){ ?>
                                                    <a href="<?php echo $related_link ?>" target="_blank">Learn More &raquo;</a>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <div class="floatClear">&nbsp;</div>
                                    </div>
                                    <div id="listBottom<?php the_ID();?>" class="listBottom listBottomOff">&nbsp;</div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="floatClear">&nbsp;</div>
            </div><!-- end "page" -->
