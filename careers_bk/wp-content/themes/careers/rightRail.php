                <div id="rightCol">
                	<?php $relatedPosts=getRelatedPosts($postid);
                			if($relatedPosts){
                    			$size = count($relatedPosts);
                    			for ($i=0; $i<$size; $i++){
                    				$postCats = getCategorySlugForPost($relatedPosts[$i]);
                    				//echo "<pre>";
                    				//print_r($postCats);
                    				if ($postCats){
                                        foreach ($postCats as $postCat){
                    						$filename=$postCat->slug."_rr.php";
                    						if (strlen($filename) > 0 and file_exists(TEMPLATEPATH."/rr/".$filename)===true){
                    							$rrpost= getSingleFullPostForPostId($relatedPosts[$i]);
                    							include(TEMPLATEPATH . "/rr/".$filename);
                    							break;
                    						}
                    					}
                    				}
                    			}//end for
                    		}
                	?>
                	
                    <?php 	$relatedCats=getRelatedCategoriesForPost($postid);?>
                    <?php 
                    		if($relatedCats){
                    			$size = count($relatedCats);
                    			for ($i=0; $i<$size; $i++){
                    				$filename=$relatedCats[$i]."_rr.php";
                                    if ((strlen($filename) > 0) && (file_exists(TEMPLATEPATH."/rr/".$filename)===true)){
                    					$rrpost= getRandomSingleFullPostForCategory($relatedCats[$i]);
                    					include(TEMPLATEPATH . "/rr/".$filename);
                                    }
                    			}//end for
                    		}
                    ?>
                </div>
