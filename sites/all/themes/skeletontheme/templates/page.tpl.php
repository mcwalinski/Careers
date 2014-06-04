<!--[if IE]>
<style type="text/css">
	/* css for IE 8 */
	
	ul#nav {
		list-style-type: none;
		margin: 0;
		padding: 0;
		float: left;
		max-width:750px;
	}
	
	ul#nav li {
	display: inline;
	margin: 0;
	padding: 0;
}

ul#nav li a {
	display: block;
	float: left;
	padding: 17px 30px;
	border-right: 1px solid #d5d5d5;
	font-family: FranklinCondBold;
	font-size: 14px;
	text-transform: uppercase;
}

ul#nav li a:hover {
	color: #FFF;
	background: -webkit-linear-gradient(top, #0370AC, #057EC0);
	border-right: 1px solid #003D5D;
}

ul#nav li a.active {
	color: #FFF;
	background: -webkit-linear-gradient(top, #0370AC, #057EC0);
	border-right: 1px solid #003D5D;
}
	
</style>
<![endif]
-->


<div class="container">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script src="scripts/jquery.masonry.min.js"></script>
        
       <link rel="apple-touch-icon" href="apple-touch-icon.png" />
	   <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png" />

        <script>
		$(function(){
		  $('.view-content').masonry({
			// options
			itemSelector: '.job_category'
		  });
		});
		</script>
        
        
        <!-- #header -->
        <div id="header" class="sixteen columns clearfix">
            <div id="header">
      	<div id="header_top">
        <!--
          <div id="breadcrumbs">
            <?php print $breadcrumb; ?>
          </div>
         --> 
          
          <div id="connect">
          	<p>Follow us:</p>
            <a id="facebook" class="sm_icon" href="http://www.facebook.com/washingtonpostcareers" target="_blank"></a>
            <a id="twitter" class="sm_icon" href="http://twitter.com/wpcareers" target="_blank"></a>
          </div>
        </div>
          <div id="signature">
          	<div id="logo"><?php if ($logo): ?>
                  <a href="http://washingtonpost.com" title="<?php print t('Home'); ?>"  id="logo" rel="home">
                    <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                  </a>
                <?php endif; ?>
            </div>

                    <div id="title">
                    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a>
                    </div>
         
          </div>
          <div id="top_left_triangle"></div>
          <div id="top_right_triangle"></div>
          <div id="navigation">
            <ul id="nav">
            	 <?php if ($page['header']) : ?>
                <?php print drupal_render($page['header']); ?>
                <?php else : ?>
                <?php print theme('links__system_main_menu', array(
                'links' => $main_menu,
                'attributes' => array(
                    'id' => 'main-menu-links',
                    'class' => array('menu', 'clearfix'),
                ),
                'heading' => array(
                    'text' => t('Main menu'),
                    'level' => 'h2',
                    'class' => array('element-invisible'),
                ),
                )); ?>
            <?php endif; ?>
            </ul>
            <div id="nav_login">
            	Returning applicants &nbsp;|&nbsp; <a href="/careers/?q=content/apply-now&url=https://washingtonpost.silkroad.com/epostings/index.cfm?fuseaction=app.res_login&company_id=16068&version=1">Sign in</a><br>
                Current employees &nbsp;|&nbsp;  <a href="employee/login.php">Sign in</a>
            </div>
            
          </div>
          
      </div>
    
               
                
            
        </div>
        
        <!-- /#header -->
        
        
        <?php if ($page['sidebar_first']) { ?>
        <div id="content" class="eleven columns">
        <?php } else { ?>
        <div id="content" class="sixteen columns clearfix">
        <?php } ?>
        
            <?php if ($messages): ?>
                <div id="messages">
                  <?php print $messages; ?>
                </div><!-- /#messages -->
            <?php endif; ?>
        
           
            
            <div id="main" <?php if ($page['sidebar_second']): ?> class="twelve columns"<?php endif; ?>>
            
                <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
                
                <?php print render($title_prefix); ?>
                
                <?php if ($title): ?>
                <h1 class="title" id="page-title">
                  <?php print $title; ?>
                </h1>
                <?php endif; ?>
                
                <?php print render($page['help']); ?>
                
                <?php if ($action_links): ?>
                <ul class="action-links">
                  <?php print render($action_links); ?>
                </ul>
                <?php endif; ?>
                <!-- this is the content-->
                <?php print render($page['content']); ?>
                <!-- this is the content-->
				<?php print render($page['content_bottom']); ?>
                
            </div>
        
        
        
        <?php if ($page['sidebar_first']): ?>
        <!-- #sidebar-first -->
        <div id="sidebar" class="five columns">
            <?php print render($page['sidebar_first']); ?>
        </div><!-- /#sidebar-first -->
        <?php endif; ?>
        
        <?php if ($page['sidebar_second']): ?>
      <div id="sidebar-second" class="four columns column sidebar"><div class="section">
        <?php print render($page['sidebar_second']); ?>
      </div></div> <!-- /.section, /#sidebar-first -->
    <?php endif; ?>
    
    <?php if ($page['featured_left'] || $page['featured_right']): ?>
        <!-- #featured -->
        <div id="featured" class="sixteen columns clearfix">
            
            <?php if ($page['featured_left'] && $page['featured_right']) { ?>
            <div class="one_half">
            <?php print render($page['featured_left']); ?>
            </div>
            
            <div class="one_half last">
            <?php print render($page['featured_right']); ?>
            </div>
            <?php } else { ?>
                
            <?php print render($page['featured_left']); ?>
            <?php print render($page['featured_right']); ?>
            
            <?php } ?>
            
        </div><!-- /#featured -->
        <?php endif; ?>

        <div id="menu">
            <div id="menu_item1">
            <?php if ($page['footer_first']): ?><?php print render($page['footer_first']); ?><?php endif; ?>
            </div>
            
            <div id="menu_item2">
            <?php if ($page['footer_second']): ?><?php print render($page['footer_second']); ?><?php endif; ?>
            </div>
            
            <div id="menu_item3">
            <?php if ($page['footer_third']): ?><?php print render($page['footer_third']); ?><?php endif; ?>
            </div>
        </div>
        
   </div><!-- /#content -->
        
        <div id="footer" class="sixteen columns clearfix">
            <div class="clear"></div>
            
            <?php if ($page['footer']): print render($page['footer']); endif; ?>
            
            <div class="clear"></div>
            
        <div id="bottom_left_triangle">&nbsp;</div><div id="bottom_right_triangle">&nbsp;</div><div id="back_to_top"><a href="#Top">Back to top</a> </div><div id="social"><p><img style="display:block; margin:0px auto 10px; width:50px; height:50px; border: 1px solid #d5d5d5" src="sites/default/files/social_icon.jpg" />Join the conversation! Follow us on <a href="http://www.facebook.com/washingtonpostcareers" target="_blank">Facebook</a> and <a href="http://twitter.com/wpcareers" target="_blank">Twitter</a>.</p></div><div id="color_test">2014 © The Washington Post</div>
        
        </div>
    </div>
    
    <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
    try {
        var pageTracker = _gat._getTracker("UA-6350795-3");
        pageTracker._trackPageview();
    } catch(err) {

    }
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49725045-1', 'washingtonpost.com');
  ga('send', 'pageview');

</script>
