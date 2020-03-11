<!-- start footer -->
<div class="footer">
    <!-- start box -->
    <div class="box">
        <!-- start left -->
        <div class="left">
            <div class="footer-link">
				<?php wp_nav_menu(array('theme_location' => '', 'menu' => 'Footer', 'menu_class' => 'menu')); ?>
                <div class="clear"></div>
            </div>
            <?php global $imic_data;
            echo $imic_data['footer-text']; ?>
        </div>
        <!-- end left -->
        <div class="right">
            <!-- Start of SRA Digital Badge code -->
            <div style="max-width:275px;max-height:163px;margin:-20px auto 0;">
                <div style="position: relative;padding-bottom: 59.1%;height: auto;overflow: hidden;">
                    <iframe frameborder="0" scrolling="no" allowTransparency="true" src="https://cdn.yoshki.com/iframe/55845r.html" style="border:0px; margin:0px; padding:0px; backgroundColor:transparent; top:0px; left:0px; width:100%; height:100%; position: absolute;"></iframe>
                </div>
            </div>
            <!-- End of SRA Digital Badge code -->
        </div>
        
        <div class="clear"></div>
    </div>
    <!-- end box -->
</div>
<!-- end footer -->
<?php wp_footer(); ?>
<!--END body-->
</body>
<!--END html-->
</html>