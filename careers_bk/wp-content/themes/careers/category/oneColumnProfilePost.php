<?php
    $linkurl = get_bloginfo('url');
    $imgurl = get_bloginfo('template_directory');

    $preview = getString($_GET['preview']);
    if ($preview == true){
        $subcatpost = getString($_GET['p']);
        $current_category = getCategorySlugForPost($postid);
        foreach((get_the_category()) as $current_category) {
            $desc = $current_category->category_description;
        }
        $category_name = $current_category->category_nicename;
        if ($category_name == "employeeprofilesitem"){
            $cat = "employeeprofiles";
        } else if ($category_name == "leaderprofilesitem"){
            $cat = "leaderprofiles";
        }
    } else {
        $subcatpost = getString($_GET['subcatpost']);
        $cat = getString($_GET['category_name']);
    }

    if ($cat == "employeeprofiles"){
        $profile_color = "Green";
        $profile_type = "Employee Profile";
    } else if ($cat == "leaderprofiles"){
        $profile_color = "Blue";
        $profile_type = "Leader Profile";
    }
    $profile_type_slug = $cat . "item";
?>

<?php get_header(); ?>
            <!-- "page" beings in header <div id="page">-->
                <?php get_sidebar(); ?>
                <div id="pageBody">
                    <div id="content" class="oneCol relative">
                        <h1><?php echo $profile_type; ?></h1>
                        <?php $postid = getSinglePostForCategory($postid,$category_name);?>
                        <?php query_posts("p=$subcatpost"); ?>
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="post profilePost" id="post-<?php the_ID(); ?>">
                                    <!--change 'foobar' below to 'Katharine' to include her Flash page-->
                                    <?php if (single_post_title('', false) == "Katharine"){ ?>
                                        <p>
                                            <iframe src="wp-content/themes/careers/flash/katharine/katharine.html" width="665" height="430" frameborder="0" allowTransparency="true"></iframe>
                                            <!--object data="wp-content/themes/careers/flash/katharine/katharine.html" border="0" hspace="0" vspace="0" height="338" width="665">
                                                <img src="<?php //echo imgurl; ?>/images/katharine_noFlash.gif" border="0" />
                                            </object-->
                                        </p>
                                        <?php the_content(); ?>
                                        <div id="profilePaging">
                                            <?php
                                                getPrevNextPostId($profile_type_slug, $post->ID, 'post_title', &$previd, &$nextid);
                                                if ($nextid != null){
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $nextid . "'><img class='padLeft' src='" . $imgurl . "/images/pagingArrow_right.gif' border='0' /></a>";
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $nextid . "'>Next</a>";
                                                }
                                                echo "<div class='dottedPipe right'>&nbsp;</div>";
                                                if ($previd != null){
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $previd . "'>Previous</a>";
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $previd . "'><img class='padRight' src='" . $imgurl . "/images/pagingArrow_left.gif' border='0' /></a>";
                                                }
                                            ?>
                                            <div class="floatClear">&nbsp;</div>
                                        </div>
                                    <?php } else { ?>
                                        <?php the_content(); ?>
                                        <div id="profilePaging">
                                            <?php
                                                getPrevNextPostId($profile_type_slug, $post->ID, 'post_title', &$previd, &$nextid);
                                                if ($nextid != null){
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $nextid . "'><img class='padLeft' src='" . $imgurl . "/images/pagingArrow_right.gif' border='0' /></a>";
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $nextid . "'>Next</a>";
                                                }
                                                echo "<div class='dottedPipe right'>&nbsp;</div>";
                                                if ($previd != null){
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $previd . "'>Previous</a>";
                                                    echo "<a class='right' href='" . $linkurl . "?category_name=" . $category_name . "&" . $postcat . "&subcatpost=" . $previd . "'><img class='padRight' src='" . $imgurl . "/images/pagingArrow_left.gif' border='0' /></a>";
                                                }
                                            ?>
                                            <div class="floatClear">&nbsp;</div>
                                        </div>
                                        <div class="profileOverText profilePost">
                                            <h3><?php the_title(); ?></h3>
                                            <?php the_excerpt(); ?>
                                            <?php $profile_quote = get_post_meta($post->ID, "profile_quote", true); ?>
                                            <img class="leftQuote" src="<?php echo $imgurl; ?>/images/quoteLeft<?php echo $profile_color ?>.gif" /><h2 class="profileQuote quote<?php echo $profile_color ?>"><?php echo $profile_quote ?><img class="rightQuote" src="<?php echo $imgurl; ?>/images/quoteRight<?php echo $profile_color ?>.gif" /></h2>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="floatClear">&nbsp;</div>
            </div><!-- end "page" -->
