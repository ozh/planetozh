<div id="sidebar">

    <div id="about_me" class="firstblock">
        <h3>About me</h3>
        <div>
            <p>This is planetOzh, weblog of Ozh, a <span title="35 for ever">35</span> years old dude living in France with an interest for,
                errr, like, computer things. I have a wife, 2 kids, and one computer-unrelated job.</p>
            <p>Something about http://amzn.to/plugindevbook and http://planetozh.com/blog/books/professional-wordpress-plugin-development/</p>
        </div>
    </div>

    <div class="sidebar_footer"></div>

    <?php /*
    <div id="toto" class="block">
        <h3>machin</h3>
        <div>
            content
        </div>
    </div>
    */ ?>

    <?php if (true === 1 && !is_home()) { ?>
    <div id="postinfo" class="firstblock">
        <h3>This page</h3>
        <div>
            <?php if (is_single()) {
                echo '<p><ul><li>Post: ';
                echo '<a href="'. get_permalink() .'" rel="bookmark" title="Permanent link : '. the_title('','',false) .'">'. the_title('','',false) .'</a>';
                echo "</li>\n";
                echo '<li>Posted on: ';
                planetozh_archives_links(false,' / ');
                echo ' (';
                planetozh_date_since();
                echo ")</li>\n";

                if (get_the_time('mdy') != get_the_modified_time('mdy')) {
                    echo '<li>Last updated: ';
                    planetozh_archives_links_lastmod(false,' / ');
                    echo ' (';
                    planetozh_date_since_lastmod();
                    echo ")</li>\n";
                }

                echo '<li>Filed in: ';
                planetozh_tag_list();
                echo "</li></ul></p><p><ul>\n";
                previous_post_link("<li><strong>&laquo;</strong>Previous post: %link</li>\n");
                next_post_link("<li><strong>&raquo;</strong>Next post: %link</li>\n");
                echo "</ul></p>";
            }
            ?>

            <?php if (is_page()) {
                echo '<p>This page was written on ';
                planetozh_archives_links(false,' / ');
                echo ' (';
                planetozh_date_since();
                echo ')';

                if (get_the_time('mdy') != get_the_modified_time('mdy')) {
                    echo "\n<br/>Last updated: ";
                    planetozh_archives_links_lastmod(false,' / ');
                    echo ' (';
                    planetozh_date_since_lastmod();
                    echo ")";
                }

                echo "</p>\n";
            }
            ?>

            <?php
                /* If this is a 404 page */ if (is_404()) {
                    echo "<p>... is a 'page not found' page. D'oh.</p>";

                /* If this is a category archive */ }
                elseif (is_tag()) { ?>
                <p>Your are browsing the archives for tag <strong><?php single_tag_title(''); ?></strong></p>

                <?php /* If this is a category archive */ }
                elseif (is_category()) { ?>
                <p>Your are browsing the archives for category <strong><?php single_cat_title(''); ?></strong></p>

                <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                <p>You are browsing the archives for the day <strong><?php the_time('l, F jS, Y'); ?></strong>.</p>

                <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                <p>You are browsing the archives for <strong><?php the_time('F, Y'); ?></strong>.</p>

          <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                <p>You are browsing the archives for the year <strong><?php the_time('Y'); ?></strong>.</p>

             <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
                <p>You have searched the <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> weblog archives
                for <strong>'<?php echo wp_specialchars($s); ?>'</strong>.</p>

                <?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                <p>You are currently browsing the <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> weblog archives.</p>

                <?php } ?>

        </div>
    </div>
    <hr/>
    <?php } // not is_home(); ?>

    <div id="highlights" class="block">
        <h3>Post Highlights</h3>
        <div class="tabber">
            <?php if (function_exists('wp_ozh_recent_posts')) { ?>
            <div class="tabbertab" id="lastposts">
                <h4>Recent</h4>
                <p>The last 5 post on planetOzh:</p>
                <?php wp_ozh_recent_posts(); ?>
            </div>
            <?php } ?>

    <?php if (planetozh_is_admin()) { ?>
            <div class="tabbertab" id="lastcoms">
                <h4>Recent + Hot</h4>
                <p>Most viewed posts this month</p>
                <ul>
                    <?php if (function_exists('wp_ozh_postviews_most_viewed_time')) wp_ozh_postviews_most_viewed_time(30) ?>
                </ul>
            </div>

    <?php } ?>

            <div class="tabbertab" id="popposts">
                <h4>Hottest</h4>
                <p>All time popular posts</p>
                <ul>
                <?php if (function_exists('wp_ozh_postviews_most_viewed_time')) wp_ozh_postviews_most_viewed(); ?>
                </ul>
            </div>

        </div> <!-- tabber -->
    </div> <!-- highlights -->


    <div id="categories" class="block">
    </div>

    <?php if (!is_page('tag-cloud')) { ?>
    <div id="cloud">
        <h3>Catacloud</h3>
        <div>
            <div><?php wp_tag_cloud('smallest=9&largest=30&number=39&format=string'); ?></div>
        </div>
    </div>
    <?php } ?>

    <hr/>

    <div id="allarchives">
        <h3>Everything</h3>
        <div>
            <p>See the complete <a href="<?php echo get_option('siteurl'); ?>/archives/" title="All posts on planetOzh">archives</a></p>
        </div>
    </div>

    <?php /*
    <div id="search">
        <h3>Search</h3>
        <div>
            <form method="get" id="searchform" action="<?php echo get_option('siteurl'); ?>/index.php">
            <fieldset>
            <input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
            <input type="submit" id="searchsubmit" name="Submit" value="&raquo;" />
            </fieldset>
        </form>
        </div>
    </div>
    <?php */ ?>


    <hr/>
    <?php /*

    <div id="communism" class="block">
        <h3>Communism</h3>
        <div class="tabber">
            <div class="tabbertab">
                <h4>bookmarks</h4>
                <?php echo planetozh_feed_get('book'); ?>
                    </div>

            <div class="tabbertab">
                <h4>last.fm</h4>
                <?php //echo planetozh_feed_get('lastfm'); ?>
                <p>See my <a href="http://www.last.fm/user/-ozh-/">last.fm</a> profile</p>

            </div>

            <div class="tabbertab">
                <h4>youtube</h4>
                <p>My latest <a href="http://www.youtube.com/Ozh#g/f">favorite</a> vids</p>
                <?php //ozh_youfave(); ?>
            </div>

    <!--		<div class="tabbertab">
            <h4>blogue</h4>
            </div>
    -->

        </div> <!-- tabber -->
    </div> <!-- communism -->

    <?php */ ?>


    <div class="sidebar_footer"></div>

    <div id="syndicate" class="firstblock">
        <h3>Misc and stuff</h3>
        <div>
            <span id="btn_feedicon"><a href="<?php echo get_bloginfo('rss2_url') ?>" title="planetOzh via RSS feed">RSS Feed</a></span>
            <ul>
                <li id="btn_planetozh" class="buttons"><a href="http://planetozh.com" title="The epicenter of everything Ozh !">planetOzh</a></li>
                <li id="btn_frefrafac" class="buttons"><a href="http://frenchfragfactory.net" title="French Frag Factory. News pour Quakeurs.">French Frag Factory</a></li>
                <li>1337 users online. I swear.</a></li>
            </ul>
        </div>
    </div>

    <div id="user" class="halfblock">
        <h3>Meta</h3>
        <div>
        <ul>
        <?php wp_register('<li>',' &raquo;</li><li><a href="/blog/wp-admin/post-new.php">Write</a> &raquo;</li>'); ?>
        <li><?php wp_loginout(); ?></li>
        </ul>
        </div>
    </div>

    <div class="sidebar_footer"></div>


</div> <!-- sidebar -->
