<?php get_header();  ?>
<!-- start container -->
<div class="container">
    <!-- start box -->
    <div class="box">
       <?php get_sidebar(); ?>
        <!-- start midcol -->
         <div class="midcol">
        <?php 
        if ( have_posts() ) :
        while (have_posts()):the_post(); ?>
           
                <!-- start showcase -->
                <div class="showcase">
                    <a href ="<?php the_permalink() ?>" title ="<?php the_title(); ?>"> <?php
                    if (has_post_thumbnail()):
                        the_post_thumbnail('Thumbnail');
                    endif;
                    ?></a>
                </div>
                <!-- end showcase -->
                <!-- start entry -->
                <div class="entry">
                    <h4><a href ="<?php the_permalink() ?>" title ="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
              <?php 
                   
           the_excerpt(); ?>
                </div>
                <!-- end entry -->
           
<?php endwhile;
 else :
				// Show the default message to everyone else.
			?>
            <article class="post listing first">
            	<header>
                    <h3><?php _e( 'Nothing Found', 'framework' ); ?></h3>
                    <div class="clear"></div>
                </header>
                <section class="entry">
                	<p><?php printf( __( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'framework' )); ?></p>
                </section>
            </article>
  <?php endif; // end have_posts() check ?>

        <div class="pagination">
                <?php if (function_exists("pagination")) {
    			pagination($additional_loop->max_num_pages);
				} ?>
            </div>
                 </div>
        <!-- end midcol -->
       <?php get_sidebar('right'); ?>
        <div class="clear"></div>
    </div>
    <!-- end box -->
</div>
<!-- end container -->
<?php get_footer(); ?>