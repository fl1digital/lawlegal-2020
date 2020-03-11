<?php
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
?>
<?php get_header(); ?>

<div class="container">
    <div class="box">
        <?php get_sidebar(); ?>
        <!-- start midcol -->

        <div class="midcol">
            <h1 class="page-title">
                <?php _e('Error 404 - Not Found', 'framework') ?>
            </h1>
            <!-- start showcase -->

            <!-- end showcase -->
            <!-- start entry -->
            <div class="entry">
                <p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
            </div>
            <!-- end entry -->
        </div>

        <!-- end midcol -->
        <?php get_sidebar('right'); ?>
        <div class="clear"></div>
    </div>
    <!-- end box -->
</div>

<?php get_footer(); ?>