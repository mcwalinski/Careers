                    <div id="wheredoifit">
                    	<?php if ($rrpost) : ?>
                    		<?php query_posts("p=$rrpost->ID"); ?>
                    		<?php while (have_posts()) : the_post(); ?>
                    			<p class="bold">Where do you fit?</p>
                    			<!--?php $arr = array("w=50", "h=50");?-->
                    			<div id="whereimage">
                                    <?php yapbImgResize(array("w=50", "h=50")); ?>
                                </div>
                                <div id="wherep">
                                    <?php $rr_blurb = get_post_meta($rrpost->ID, "rr_blurb", true); ?>
                                    <p><?php echo $rr_blurb; ?></p>
                                </div>
                            	<div class="floatClear">&nbsp;</div>
                            	<a href="<?php bloginfo('url')?>/?category_name=<?php echo(getOtherCategoryForPost($rrpost->ID,"wheredoifititem"));?>"><?php echo($rrpost->post_title);?> Opportunities &raquo;</a>
                            <?php endwhile;?>
                    	<?php endif; ?>
                    </div>
