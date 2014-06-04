<?php

if ( function_exists('register_sidebar') )    register_sidebar(array('name'=>'sidebar',        'before_widget' => '<li>',    'after_widget' => '</li>', 'before_title' => '',        'after_title' => '',    ));if ( function_exists('register_sidebar') )    register_sidebar(array('name'=>'sidebar2',        'before_widget' => '<li>',    'after_widget' => '</li>', 'before_title' => '',        'after_title' => '',    ));

function getBreadCrumbs($category_name){
		global $wpdb;
        $catid = getCategoryId($catid,$category_name);
		$name = $wpdb->get_var("select name from wp_terms where term_id=$catid");
		$breadcrumbs = "$name";
		$delimiter = "|";
		$blogurl = get_bloginfo('url');
		
		$parentid = $wpdb->get_var("select parent from wp_term_taxonomy where term_id=$catid");
		
	  	while ($parentid != 0){
	  		$row = $wpdb->get_row("select name,slug from wp_terms where term_id=$parentid");
	  		$breadcrumbs = "<a href=".$blogurl."/?category_name=".$row->slug.">".$row->name."</a> ".$delimiter." ".$breadcrumbs;
	  		$catid = $parentid;
	  		$parentid = $wpdb->get_var("select parent from wp_term_taxonomy where term_id=$catid");	
	  	}	
	  	
	  $breadcrumbs = "<a href=".$blogurl."/index.php>Home</a> ".$delimiter." ".$breadcrumbs;
//    "select name,slug from wp_terms where term_id=$current_id
//    "select term_id from wp_term_taxonomy where term_id=$current_id and taxonomy='category'"

	  return $breadcrumbs;
}

function getMenu(){
    global $wpdb,$category;
    $excludeList = file_get_contents(dirname(__FILE__).'/category/exclude-category.txt');
    $catArray = $wpdb->get_results("SELECT t1.name,t1.slug,t1.term_id from wp_terms t1, wp_term_taxonomy t2 where t1.term_id=t2.term_id and t2.parent=0 and t2.taxonomy='category' and t2.count>0 and t1.slug not in ($excludeList) order by t1.term_order");
    $blogurl = get_bloginfo('template_directory');

    $catid = getCategoryId($catid,$category);
    $parentList = get_category_parents($catid,false,";",TRUE);
    $pos = strpos($parentList,$category);
    $parentList = substr($parentList,0,$pos-1);   //stripping off current category

    foreach($catArray as $cat){ 

        if ($cat->slug==="home" and $category==="home") {
            continue;
        }
        printMenuChildren($cat,$parentList);        
    }
    if ($category == "searchopenings" || $category == "washpostjobopportunities" || $category == "wpdigitaljobopportunities" || $category == "expressjobopportunities" || $category == "eltiempojobopportunities" || $category == "newsroomjobopportunities"){
        echo "<p class='currentCat menu menuPage'><img src='" . $blogurl . "/images/nav_searchJobs_icon.gif' /><a class='inline' href='?category_name=searchopenings'>Search Opportunities</a></p>";
    } else {
        echo "<p class='menu menuPage'><img src='" . $blogurl . "/images/nav_searchJobs_icon.gif' /><a class='inline' href='?category_name=searchopenings'>Search Opportunities</a></p>";
    }
    if ($category === "currentemployeecenter" || $category== "eltiempoemployee" || $category== "expressemployee" || $category== "newsroomemployee" || $category== "washpostemployee" || $category== "wpdigitalemployee"){
        echo "<p class='currentCat menu menuPage'><img src='" . $blogurl . "/images/nav_curEmp_icon.gif' /><a class='inline' href='?category_name=currentemployeecenter'>Employee Center</a></p>";
    } else {
        echo "<p class='menu menuPage'><img src='" . $blogurl . "/images/nav_curEmp_icon.gif' /><a class='inline' href='?category_name=internal-opportunities'>Employee Center</a></p>";
    }
    
}

function printMenuChildren ($parent,$parentListStr)  {
    global $category;

    $catid = getCategoryId($catid,$category);
    $currentparent = getTopLevelParent($catid);
    $currentslug = getCategoryById($currentparent);
    $blogurl = get_bloginfo('url');

    //print parent
    if ($parent->slug==="home") {
        echo "<p class='menu'><a href=".$blogurl."/index.php>".$parent->name."</a></p>";
    } else {
        if ($parent->slug===$category) {
            if ($parent->slug===$currentslug){
                echo "<p class='currentCat menu'>".$parent->name."</p>";
            } else {
                echo "<p class='bold menu'>".$parent->name."</p>";
            }
        } else {
            if ($parent->slug===$currentslug){
                echo "<p class='currentCat menu'><a href=".$blogurl."?category_name=".$parent->slug.">".$parent->name."</a></p>";
            } else {
                echo "<p class='menu'><a href=".$blogurl."?category_name=".$parent->slug.">".$parent->name."</a></p>";
            }
        }
        
    }

    $parentList = explode(";",$parentListStr);

    if ((in_array($parent->slug,$parentList)) or ($parent->slug===$category)) {
    
        $children = getChildCategories($children,$parent->term_id);
    
        if ($children) {
            echo "<div class='submenu'>";
            foreach ($children as $child){
                printMenuChildren($child,$parentListStr);
            }
            echo "</div>";
            
        } else {
            return $children;
        }
    } else {
        return $children;
    }
    
}

function getTopLevelParent($catid){
    global $wpdb;

    $currentid = $catid;
    $parentid = $wpdb->get_var("select parent from wp_term_taxonomy where term_id=$currentid");

    while ($parentid != 0){
        $currentid = $parentid;
        $parentid = $wpdb->get_var("select parent from wp_term_taxonomy where term_id=$currentid");
    }
    return $currentid;
}

function getCategoryById($catid){
    global $wpdb;

    $currentid = $catid;
    $currentslug = $wpdb->get_var("select slug from wp_terms where term_id=$catid");

    return $currentslug;
}

function getChildCategories (&$children,$catId){
    global $wpdb;
    $excludeList = file_get_contents(dirname(__FILE__).'/category/exclude-category.txt');

    $children = $wpdb->get_results("select t1.name,t1.slug,t1.term_id from wp_terms t1, wp_term_taxonomy t2 where t1.term_id=t2.term_id and t2.parent=$catId and t2.taxonomy='category' and t2.count>0 and t1.slug not in ($excludeList) order by t1.term_order");
    return $children;
}


function getSinglePostForCategory(&$postid,$slug){
    global $wpdb;

    $catid = getCategoryId($catid,$slug);
    $postid = $wpdb->get_var("SELECT ID from wp_posts p, wp_term_relationships tr, wp_term_taxonomy tax where p.id=tr.object_id and tr.term_taxonomy_id=tax.term_taxonomy_id and tax.term_id=$catid and p.post_type='post' and p.post_status='publish' order by post_modified desc limit 1");
    return $postid;
}

function getRandomSinglePostForCategory(&$postid,$slug){
    global $wpdb;

    $catid = getCategoryId($catid,$slug);
    //$postid = $wpdb->get_var("SELECT ID from wp_posts p, wp_term_relationships tr where p.id=tr.object_id and tr.term_taxonomy_id=$catid and p.post_type='post' and p.post_status='publish' order by RAND() desc limit 1");
    $postid = $wpdb->get_var("SELECT ID from wp_posts p, wp_term_relationships tr, wp_term_taxonomy tax where p.id=tr.object_id and tr.term_taxonomy_id=tax.term_taxonomy_id and tax.term_id=$catid and p.post_type='post' and p.post_status='publish' order by RAND() desc limit 1");
    return $postid;
}

function getRandomSingleFullPostForCategory($slug){
    global $wpdb;

    $catid = getCategoryId($catid,$slug);
    //$postid = $wpdb->get_var("SELECT ID from wp_posts p, wp_term_relationships tr where p.id=tr.object_id and tr.term_taxonomy_id=$catid and p.post_type='post' and p.post_status='publish' order by RAND() desc limit 1");
    $post = $wpdb->get_row("SELECT p.* from wp_posts p, wp_term_relationships tr, wp_term_taxonomy tax where p.id=tr.object_id and tr.term_taxonomy_id=tax.term_taxonomy_id and tax.term_id=$catid and p.post_type='post' and p.post_status='publish' order by RAND() desc limit 1");
    return $post;
}

function getSingleFullPostForPostId($postid){
    global $wpdb;

    $post = $wpdb->get_row("SELECT * from wp_posts where id=$postid and post_type='post' and post_status='publish' order by post_modified desc limit 1");
    return $post;
}

function getMultiplePostsForCategory(&$posts,$slug,$numofposts){
    global $wpdb;

    $catid = getCategoryId($catid,$slug);
    $posts = $wpdb->get_results("SELECT ID from wp_posts p, wp_term_relationships tr, wp_term_taxonomy tax where p.id=tr.object_id and tr.term_taxonomy_id=tax.term_taxonomy_id and tax.term_id=$catid and p.post_type='post' and p.post_status='publish' order by post_modified desc limit $numofposts");
    return $posts;
}

function getMultipleFullPostListForCategory($slug,$numofposts){
    global $wpdb;

    $catid = getCategoryId($catid,$slug);
    $posts = $wpdb->get_results("SELECT p.* from wp_posts p, wp_term_relationships tr, wp_term_taxonomy tax, wp_postmeta pm
                                 where p.id=tr.object_id and tr.term_taxonomy_id=tax.term_taxonomy_id and tax.term_id=$catid 
                                 and p.post_type='post' and p.post_status='publish' and p.id = pm.post_id and pm.meta_key='display_order'
                                order by  (pm.meta_value+1) asc limit $numofposts");
    if (count($posts)===0){
    	$posts = $wpdb->get_results("SELECT p.* from wp_posts p, wp_term_relationships tr, wp_term_taxonomy tax
                                 	where p.id=tr.object_id and tr.term_taxonomy_id=tax.term_taxonomy_id and tax.term_id=$catid 
                                 	and p.post_type='post' and p.post_status='publish' limit $numofposts");
    }
    return $posts;
}

function getCategoryId(&$catid,$name){
    global $wpdb;

    $catid = $wpdb->get_var("Select term_id from wp_terms where slug='$name'");
    return $catid;
}

function getPostTitle(&$title,$postid){
    global $wpdb;

    $title = $wpdb->get_var("Select post_title from wp_posts where ID='$postid'");
    return $title;
}

function getRelatedCategoriesForPost($postid){
	global $wpdb;
	
	$relatedStr = $wpdb->get_var("Select meta_value from wp_postmeta where post_id=$postid and meta_key='related_categories'");
	
	if (is_null($relatedStr)){
		$relatedCategories="";
		return $$relatedCategories;
	}
	
	if (substr($relatedStr,-1)===",")
	{
		$relatedStr = substr($relatedStr,0,strlen($relatedStr)-1);
	}
	
	$relatedCategories = explode(",",$relatedStr);
	//strip any whitespace, tabs, new line, etc
	for ($i=0; $i<count($relatedCategories); $i++){
		$relatedCategories[$i]=trim($relatedCategories[$i]);
	}
	return $relatedCategories;
}

function getRelatedPosts($postid){
	global $wpdb;
	
	$relatedStr = $wpdb->get_var("Select meta_value from wp_postmeta where post_id=$postid and meta_key='related_post_id'");
	
	if (is_null($relatedStr)){
		$relatedPosts="";
		return $relatedPosts;
	}
	
	if (substr($relatedStr,-1)===",")
	{
		$relatedStr = substr($relatedStr,0,strlen($relatedStr)-1);
	}
	
	$relatedPosts = explode(",",$relatedStr);
	//strip any whitespace, tabs, new line, etc
	for ($i=0; $i<count($relatedPosts); $i++){
		$relatedPosts[$i]=trim($relatedPosts[$i]);
	}
	
	return $relatedPosts;
}

function getStringMetaValue($postid,$metakey){
	global $wpdb;
	
	$metavalue = $wpdb->get_var("Select meta_value from wp_postmeta where post_id=$postid and meta_key='$metakey'");
	return $metavalue;
}

function getCategorySlugForPost($postid){
	global $wpdb;
	
	$slug = $wpdb->get_results("SELECT te.slug from wp_term_relationships tr, wp_term_taxonomy tt, wp_terms te where tr.object_id=$postid and 
	                            tr.term_taxonomy_id = tt.term_taxonomy_id and tt.term_id = te.term_id");
	return $slug;
}

function getOtherCategoryForPost($postid,$unwantedcat){
	global $wpdb;
	
	$slug = $wpdb->get_var("select slug from wp_term_relationships tr, wp_term_taxonomy tax, wp_terms tt 
							where tr.object_id=$postid and tr.term_taxonomy_id = tax.term_taxonomy_id and tax.taxonomy='category'
							and tax.term_id = tt.term_id and tt.slug != '$unwantedcat' limit 1");
	return $slug;
}

function getSingleEvent(&$evt, $pId){
    global $wpdb;

    $evt = $wpdb->get_row("SELECT * from wp_posts p, wp_eventscalendar_main evt where evt.postID=$pId and p.ID=evt.postID and p.post_type='post' and p.post_status='publish' order by post_modified desc limit 1");
    return $evt;
}


function getString($param){
    return sanitize($param);
}

function sanitize($string){
    //decode url
    $string = urldecode  ($string);

    // strips <name> and </name>
    $string = strip_tags($string);

    // replaces eval
    $string = eregi_replace("eval\\((.*)\\)", "",$string);

    // replaces word javascript:
    $string = eregi_replace("javascript:", "",$string);

    // replaces word script
    $string = eregi_replace("script", "",$string);

    //custom replace for braces and ;
    $string= eregi_replace("\\{|\\}|\\[|\\]|;|�|�|�|�", "",$string);
    return $string;
}

// unpublishing of expired content
function hasExpiredByID($id){
    global $wpdb;
    $exp_date= get_post_meta($id, "expiration_date", true);
    if(!$exp_date){
        return false;
    }
    $todays_date = date("Y-m-d");
    $today = strtotime($todays_date);
    $expiration_date = strtotime($exp_date);
    if ($expiration_date > $today) {
        return false;
    }else {
        $querystr = "update wp_posts set post_status='draft' where ID = ".$p->ID;
        $wpdb->query($querystr);
        return true;
    }
}

function hasExpired($p){
    return hasExpiredByID($p->ID);
}

function yapbImg($postid){ // $postid is optional- only needed outside the loop
    global $wpdb, $post;
    if (isset($postid) === false){
       $postid = $post->ID;
    }
    $rows = $wpdb->get_results("SELECT * FROM wp_yapbimage WHERE post_id = $postid");
    $thumb = null;
    foreach ($rows as $row) {
        $thumb = $row->URI;
    }
    echo "<img src='$thumb' border='0' />";
}
// set array in params as described here: http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt
// usually "array('w=150', 'h=150')" works just fine- only need to set maxheight (h=) and maxwidth (w=)
function yapbImgResize($arr){ // NOTE: to be used inside the loop only
    global $wpdb, $post;
    $postid = $post->ID;
    $rows = $wpdb->get_results("SELECT * FROM wp_yapbimage WHERE post_id = $postid");
    $thumb = null;
    foreach ($rows as $row) {
        $thumb = $row->URI;
    }
    if ($thumb != null){
        echo yapb_thumbnail('', array('alt' => ''), '', $arr);
    }
}

function yapbImgSrc($postid=null){ // $postid is optional- only needed outside the loop
    global $wpdb, $post;
    if (isset($postid) === false){
       $postid = $post->ID;
    }
    $rows = $wpdb->get_results("SELECT * FROM wp_yapbimage WHERE post_id = $postid");
    $thumb = null;
    foreach ($rows as $row) {
        $thumb = $row->URI;
    }
    echo $thumb;
}
// set array in params as described here: http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt
function yapbImgSrcResize($postid, $arr){ // $postid is optional- only needed outside the loop
    global $wpdb, $post;
    $rows = $wpdb->get_results("SELECT * FROM wp_yapbimage WHERE post_id = $postid");
    $thumb = null;
    foreach ($rows as $row) {
        $thumb = $row->URI;
    }
    if ($thumb != null){
        $src = 'wp-content/plugins/yet-another-photoblog/YapbThumbnailer.php?post_id=' . $postid;
        foreach ($arr as $value) {
            $src .= '&' . $value;
        }
        return $src;
    }
}
// checks is a post has a YAPB image associated with it
function hasYAPB($postid){
    global $wpdb, $post;
    $rows = $wpdb->get_results("SELECT * FROM wp_yapbimage WHERE post_id = $postid");
    $hasImage = false;
    foreach ($rows as $row) {
        if ($row->URI){
            $hasImage = true;
        }
    }
    return $hasImage;
}


function getPrevNextPostId($category,$currentid,$orderbycol,&$previd,&$nextid){
	global $wpdb;
	
	$catid = getCategoryId($catid,$category); 
	$postids = $wpdb->get_col("SELECT p.id from wp_posts p, wp_term_relationships tr, wp_term_taxonomy tax 
							   where p.id=tr.object_id and tr.term_taxonomy_id=tax.term_taxonomy_id and tax.term_id=$catid 
							   and p.post_type='post' and p.post_status='publish' order by $orderbycol asc");
	$previd=null;
	$nextid=null;
	$numberofids = count($postids);
	for ($i=0; $i<$numberofids; $i++){
        if ($postids[$i] == $currentid){
			if ($i >0){
				$previd = $postids[$i-1];
			} else {
                $previd = $postids[$numberofids -1];
            }
			if ($i < ($numberofids -1)){
				$nextid = $postids[$i+1];
			} else {
                $nextid = $postids[0];
            }
			break;
		}
	}
}

?>
