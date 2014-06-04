<?php $preview = getString($_GET['preview']);?>
<?php $postid = getString($_GET['p']);?>
<?php $linkurl = get_bloginfo('url'); ?>

<?php
    if ($preview == 'true'){
        get_header();

        $current_category = getCategorySlugForPost($postid);
        foreach((get_the_category()) as $current_category) {
            $desc = $current_category->category_description;
        }

        $filename = trim(strip_tags($desc));
        if (strlen($filename) > 0 and file_exists(dirname(__FILE__)."/".$filename)===true) {
            $category_name = $current_category->category_nicename;
            $category = $current_category->category_nicename;
            //echo $category_name;
            include (TEMPLATEPATH."/".$filename);
        } else {
        	include (TEMPLATEPATH.'/category/oneColumnPost.php');
        }

        get_footer();
    } else {
        include (TEMPLATEPATH.'/archive.php');
    }
?>
