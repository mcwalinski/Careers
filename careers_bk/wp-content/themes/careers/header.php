<?php error_reporting(0); ?>
<?php
    $preview = getString($_GET['preview']);
    if ($preview == true){
        $postid = getString($_GET['p']);
        $current_category = getCategorySlugForPost($postid);
        foreach((get_the_category()) as $current_category) {
            $desc = $current_category->category_description;
        }
        $category_name = $current_category->category_nicename;
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head profile="http://gmpg.org/xfn/11">
        <title>
            <?php
                $title = single_cat_title('', false);
                if ($title == null){
                    $title = "Washington Post Media Careers";
                }
                echo $title;
            ?>
        </title>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <link rel="stylesheet" href="wp-content/themes/careers/style.css" type="text/css" media="all"></link>
        <link rel="icon" type="image/png" href="wp-content/themes/careers/images/favicon.png">
        <?php if ($category_name === "contactus"){ ?>
            <script type="text/javascript" src="wp-content/themes/careers/js/mootools-1.2.1-core-nc.js"></script>
            <script type="text/javascript" src="wp-content/themes/careers/js/validate1.0/validate.js"></script>
            <link rel="stylesheet" href="wp-content/themes/careers/js/validate1.0/validate.css" type="text/css" media="all"></link>
        <?php } ?>
        <script type="text/javascript" src="wp-content/themes/careers/js/careers.js"></script>
        <!--[if IE 7]>
            <style type="text/css" media="screen">
                @import url( wp-content/themes/careers/ie7.css );
            </style>
        <![endif]-->
        <!--[if IE 6]>
            <style type="text/css" media="screen">
                @import url( wp-content/themes/careers/ie6.css );
            </style>
        <![endif]-->
        <?php wp_head(); ?>
    </head>
    <body>
        <script type='text/javascript'>
            var bodyBG = careers.getBG();
            careers.setBG(bodyBG);
        </script>
        <div id="wrap">
            <div id="headerContainer">
                <div id="globalNav">
                    <a class="navLink first"href="http://www.washingtonpost.com">Read the News</a>|
                    <a class="navLink" href="http://classified.washpost.com">Place an Advertisement</a>|
                    <a class="navLink" href="http://subscription.washpost.com">Subscribe to the Newspaper</a>|
                    <a class="navLink" href="http://washingtonpostmedia.com/careers/">Work With Us</a>
                </div>
                <?php $srcCls = "searchOff";
                    if ($category_name == "searchopenings" || $category_name == "washpostjobopportunities" || $category_name == "wpdigitaljobopportunities" || $category_name == "expressjobopportunities" || $category_name == "eltiempojobopportunities" || $category_name == "newsroomjobopportunities"){
                        $srcCls = "searchOn";
                    }
                ?>
                <div id="searchTab" class="<?php echo $srcCls ?>" onclick="window.location = '?category_name=searchopenings'">&nbsp;</div>
                <div id="colorWidget" class="widgetOff" onmouseover="careers.colorWidget();" onmouseout="careers.colorWidget();">
                    <div class="color hide" onclick="careers.setBG('teal');">&nbsp;</div>
                    <div class="color hide" onclick="careers.setBG('green');">&nbsp;</div>
                    <div class="color hide" onclick="careers.setBG('purple');">&nbsp;</div>
                    <div class="color hide" onclick="careers.setBG('orange');">&nbsp;</div>
                    <div class="color hide" onclick="careers.setBG('blue');">&nbsp;</div>
                    <div class="color hide" onclick="careers.setBG('red');">&nbsp;</div>
                </div>
                <div id="header">
                    <div id="siteTagLine">Discover a <b>career</b> you believe in.</div>
                </div>
            </div>
            <div id="breadcrumbs">
                <div id="crumbs">
                    <a class="navLink"href="http://washingtonpostmedia.com/careers/">Home</a> |
                    <a class="navLink" href="http://washingtonpostmedia.com/careers/?category_name=internal-opportunities">Employee Center</a>
                </div>
            </div>
        	<div id="page">
            <!-- "page" ends in individual templates -->
        <!-- "wrap" ends in footer.php-->
