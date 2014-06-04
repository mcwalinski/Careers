                    <div id="topten">
                    	<?php if ($rrpost) : ?>
                            <?php $rr_blurb = get_post_meta($rrpost->ID, "rr_blurb", true); ?>

                            <p class="bold">Why Work Here?</p>
                            <p><span class="fourteen grey"><?php echo($rrpost->post_title);?></span></p>
                           	<p>
                                <?php echo $rr_blurb ?>
                            </p>
                           	<a href="<?php bloginfo('url')?>/?category_name=topten">See Our Top 10 &raquo;</a>
                    	<?php endif; ?>
                    </div>
