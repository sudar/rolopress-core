	<?php rolopress_before_footer(); // before footer hook ?>
	<div id="footer">
	<?php rolopress_footer(); // rolopress footer hook ?>
		<div id="colophon">
		
			<div id="site-info">
				<p>Powered by <span id="generator-link"><a href="http://rolopress.com/" title="<?php _e( 'RoloPress', 'rolopress' ) ?>" rel="generator"><?php _e( 'RoloPress', 'rolopress' ) ?></a></span></p>			
			</div><!-- #site-info -->
			
		</div><!-- #colophon -->
	</div><!-- #footer -->
	<?php rolopress_after_footer(); // After footer hook ?>
	
</div><!-- #wrapper -->	
	<?php rolopress_after_wrapper(); // After wrapper hook ?>

<?php wp_footer(); // WordPress footer hook ?>

</body>
</html>