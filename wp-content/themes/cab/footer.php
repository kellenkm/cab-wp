<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Comic_Arts_Brooklyn
 * @since Comic Arts Brooklyn 1.0
 */
?>

		<footer class="footer">
        <div class="container">
          <div class="inner">
            <h4 class="section-header">Sponsored by</h4>
            <div class="footer-logos">
						<p>
							<a href="http://www.drawnandquarterly.com/" target="_BLANK"><img src="<?php echo get_bloginfo('template_directory') ?>/images/footer/drawnandquarterly.png" /></a>
							<a href="http://www.lostartbooks.com/" target="_BLANK"><img src="<?php echo get_bloginfo('template_directory') ?>/images/footer/lostartbooks.png" /></a>
						</p>
						<p>
							<a href="http://www.nobrow.net/" target="_BLANK"><img src="<?php echo get_bloginfo('template_directory') ?>/images/footer/nobrow.png" /></a>
							<a href="http://www.printninja.com/printing-products/comic-book-printing?utm_source=comic%20arts%20brooklyn&utm_medium=website%20link&utm_campaign=con%20sponsorships%202014" target="_BLANK"><img src="<?php echo get_bloginfo('template_directory') ?>/images/footer/printninja.png" /></a>
						</p>
						<p>
							<a href="http://www.finland.org/public/default.aspx?nodeid=35840&contentlan=2&culture=en-US" target="_BLANK"><img src="<?php echo get_bloginfo('template_directory') ?>/images/footer/finland_consulate.png" /></a>
						</p>
					</div>
          </div>
        </div>
      </footer>
	</div><!-- .content -->

	<?php wp_footer(); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<? bloginfo('template_url'); ?>/js/skrollr.min.js"></script>
<script src="<? bloginfo('template_url'); ?>/js/bootstrap/bootstrap.min.js"></script>
<!-- <script src="<?php echo get_bloginfo('template_directory') ?>/js/mojotech-stickymojo-7d56a77/stickyMojo.js"></script>
<script src="<?php echo get_bloginfo('template_directory') ?>/js/smooth-scroll-master/dist/js/bind-polyfill.js"></script>
<script src="<?php echo get_bloginfo('template_directory') ?>/js/smooth-scroll-master/dist/js/smooth-scroll.js"></script> -->
<script src="<?php echo get_bloginfo('template_directory') ?>/js/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory') ?>/js/script.js"></script>
</body>
</html>