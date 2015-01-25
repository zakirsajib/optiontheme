<?php 
get_header();
?>
<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	  	<?php if ( have_posts() ) : ?>
			  	<?php while(have_posts()) : the_post();?>
			    	
			    <?php endwhile;?>
		<?php else : ?>
		
		<?php endif; // end have_posts() check ?>	
</div> <!-- end post-class -->
<?php get_footer();?>
