<?php $category_name = getString($_GET['category_name']);?>
<?php $subcatpost = getString($_GET['subcatpost']);?>
<?php get_header(); ?>
<?php
		if ($category_name==null){
			//echo ("cat_name: ".$category_name);
			include (TEMPLATEPATH.'/index.php');
			exit;
		}
		if (!$subcatpost){
			$category = $category_name;
        	$category_id = getCategoryId($category_id,$category_name);
		} else {
			//echo "inside subcatpost";
			$category = $category_name."item";
        	$category_id = getCategoryId($category_id,$category_name."item");
		}

		if ($category_id == null){
            include (TEMPLATEPATH.'/index.php');
			exit;
		}

		$filename = category_description($category_id);
        $filename = trim(strip_tags($filename));

        $catlist = getSinglePostForCategory($postid,$category_name);
        if ($postid == ""){
            include (TEMPLATEPATH.'/index.php');
			exit;
        }

        if (strlen($filename) > 0 and file_exists(dirname(__FILE__)."/".$filename)===true) {
        	include $filename;
        } else {
        	include "category/oneColumnPostInternal.php";
        }
?>
<?php get_footer(); ?>