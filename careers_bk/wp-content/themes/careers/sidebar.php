<?php $linkurl = get_bloginfo('url'); ?>
<?php $imgurl = get_bloginfo('template_directory'); ?>
            <div id="leftNav">
                <?php getMenu(); ?>
                <div id="quotes">
                    <?php $qpost = getRandomSingleFullPostForCategory("employeeprofilesitem");?>
                    <?php if ($qpost) : ?>
                        <div class="navQuote">
                            <img class="leftQuote" src="<?php echo $imgurl; ?>/images/quoteLeftGrey.gif" />
                            <h4><!--?php echo($qpost->post_content); ?-->
                                <?php $profile_quote = get_post_meta($qpost->ID, "profile_quote", true); ?>
                                <?php echo $profile_quote ?>
                                <img class="rightQuote" src="<?php echo $imgurl; ?>/images/quoteRightGrey.gif" />
                            </h4>
                            <p><a href="<?php echo $linkurl; ?>?category_name=employeeprofiles&subcatpost=<?php echo $qpost->ID; ?>""><?php echo $qpost->post_title; ?></a></p>
                            <?php echo $qpost->post_excerpt; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
