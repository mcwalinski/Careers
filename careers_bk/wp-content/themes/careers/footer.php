            <div id="didYouKnow">
                <?php $postid = getRandomSinglePostForCategory($postid,"didyouknow");?>
                <?php query_posts("p=$postid"); ?>
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div id="dykFact" class="twelve">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div id="footer">
                <div id="links">
                    <span><a href="?category_name=privacystatement">Privacy Statement</a></span>
                </div>
                <div id="twp" onclick="window.open('http://washingtonpost.com', 'new');">&nbsp;</div>
                <!--div id="wpCom" onclick="window.open('http://washingtonpost.com', 'new');">&nbsp;</div-->
                <div id="express" onclick="window.open('http://www.expressnightout.com', 'new');">&nbsp;</div>
                <div id="elTiempo" onclick="window.open('http://eltiempolatino.com', 'new');">&nbsp;</div>
                <!--div id="mobile" onclick="window.open('http://www.washingtonpost.com/wp-srv/contents/mobile/mobilewebsite.html?hpid=distribution', 'new');">&nbsp;</div-->
            </div>
            <?php wp_footer(); ?>
        </div> <!-- end #wrap  -->
        <div class="copyright">&#169;
            <script type="text/javascript">
                var d = new Date();
                document.write(d.getFullYear());
            </script>
            The Washington Post Company</div>
        </div>
        <?php include 'ga.php'; ?>
    </body>
</html>