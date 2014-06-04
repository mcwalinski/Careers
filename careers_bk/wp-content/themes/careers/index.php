<?php get_header(); ?>
            <?php $category="home"; ?>
            <?php query_posts('category_name=Home&showposts=1'); ?>
            <!-- "page" beings in header <div id="page">-->
                <div id="homePageBody">

                    <div id="homePageBG">

                        <div id="leftNav">
                            <?php getMenu(); ?>
                        </div>
                        <div id="homePageMovie">



                            <!--object data="wp-content/themes/careers/flash/homepage/homepage.html" border="0" hspace="0" vspace="0" height="385" width="612"-->
                            <!--object data="wp-content/themes/careers/flash/homepage/homepage.html" border="0" hspace="0" vspace="0" height="400" width="613">
                                No content here.
                            </object-->
                            <iframe src="wp-content/themes/careers/flash/homepage/homepage.html" width="613" height="400" frameborder="0" allowTransparency="true"></iframe>

                        </div>
                        <div id="careerCenter">
                            <div id="ccCopy">
                                <h3>Career Center</h3>
                                <p>Explore the opportunities available in technology, business, sales, production, and news. Where might you fit in?</p>
                            </div>
                            <div id="ccIcons">
                                <div class="fitIcon news_off" onmouseover="careers.swapIcons(this, 'news');" onmouseout="careers.swapIcons(this, 'news');" onclick="window.location = '?category_name=news';">&nbsp;</div>
                                <div class="fitIcon production_off" onmouseover="careers.swapIcons(this, 'production');" onmouseout="careers.swapIcons(this, 'production');" onclick="window.location = '?category_name=production';">&nbsp;</div>
                                <div class="fitIcon sales_off" onmouseover="careers.swapIcons(this, 'sales');" onmouseout="careers.swapIcons(this, 'sales');" onclick="window.location = '?category_name=sales';">&nbsp;</div>
                                <div class="fitIcon business_off" onmouseover="careers.swapIcons(this, 'business');" onmouseout="careers.swapIcons(this, 'business');" onclick="window.location = '?category_name=business';">&nbsp;</div>
                                <div class="fitIcon technology_off" onmouseover="careers.swapIcons(this, 'technology');" onmouseout="careers.swapIcons(this, 'technology');" onclick="window.location = '?category_name=technology';">&nbsp;</div>
                                <div id="iconText"></div>
                            </div>
                        </div>


                    </div>

                </div><!-- end "homePageBody" -->
                <div class="floatClear">&nbsp;</div>
        	</div><!-- #page -->
            <?php get_footer(); ?>