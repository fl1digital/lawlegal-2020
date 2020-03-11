<?php get_header(); ?>
<!-- start container -->
<div class="container">
    <!-- start box -->
    <div class="box">
       <?php get_sidebar(); ?>
        <!-- start midcol -->
        <?php while (have_posts()):the_post(); ?>
            <div class="midcol">
                <!-- start showcase -->
                <div class="showcase">
                    <?php
                    if (has_post_thumbnail()):
                        the_post_thumbnail('Medium');
                    endif;
                    ?>
                </div>
                <!-- end showcase -->
                <!-- start entry -->
                <div class="entry">
              <?php the_content(); ?>
                </div>
                <!-- end entry -->
            </div>
<?php endwhile; ?>
        <!-- end midcol -->
       <?php get_sidebar('right'); ?>
        <div class="clear"></div>
    </div>
    <!-- end box -->
</div>
<!-- end container -->
<?php get_footer(); ?>