	</div><!-- #main -->
	<?php rolopress_before_footer(); // Before footer hook ?>
	<div id="footer">
	<?php rolopress_footer(); // rolopress footer hook ?>
		<div id="colophon">
		
			<div id="site-info">
				<p>Powered by <span id="generator-link"><a href="http://wordpress.org/" title="<?php _e( 'WordPress', 'rolopress' ) ?>" rel="generator"><?php _e( 'WordPress', 'rolopress' ) ?></a></span> and <span id="theme-link"><a href="http://rolopresss.com" title="<?php _e( 'The rolopress Theme for WordPress', 'rolopress' ) ?>" rel="designer"><?php _e( 'rolopress', 'rolopress' ) ?></a></span>.</p>			
			</div><!-- #site-info -->
			
		</div><!-- #colophon -->
	</div><!-- #footer -->
	<?php rolopress_after_footer(); // After footer hook ?>
	
</div><!-- #wrapper -->	
	<?php rolopress_after_wrapper(); // After wrapper hook ?>

<?php wp_footer(); // WordPress footer hook ?>

</body>
</html>