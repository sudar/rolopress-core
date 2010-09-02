<?php if ( is_sidebar_active('primary') ) :  ?>
		<div id="primary" class="widget-area sidebar">
			<ul class="xoxo">
				<?php dynamic_sidebar('primary'); ?>
			</ul>
		</div><!-- #primary .widget-area -->
<?php endif; ?>		
		
<?php if ( is_sidebar_active('secondary') ) : ?>
		<div id="secondary" class="widget-area sidebar">
			<ul class="xoxo">
				<?php dynamic_sidebar('secondary'); ?>
			</ul>
		</div><!-- #secondary .widget-area -->
<?php endif; ?>