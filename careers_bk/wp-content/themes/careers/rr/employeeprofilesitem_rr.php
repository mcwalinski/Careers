<?php if ($rrpost) : ?>
	<div id="employeeprofile" class="yapbProfile" style="background-image:url(<?php yapbImgSrc($rrpost->ID); ?>);">
		<!--span class="grey smalltext">Meet..</span><br /-->
        <p><a href="<?php bloginfo('url'); ?>/?category_name=employeeprofiles&subcatpost=<?php echo($rrpost->ID); ?>"><?php echo($rrpost->post_title); ?></a></p>
		<?php echo($rrpost->post_excerpt); ?>
	</div>
<?php endif; ?>

