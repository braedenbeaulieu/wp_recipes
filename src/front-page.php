<?php get_header(); ?>
<div <?php post_class( 'front-page' ); ?>>
	<div class="rp-container">
		<main class="rp-content">
			<h1>Home</h1>
			<div class="rp-section">
				<h2>Categories</h2>
				<div class="rp-category-list">
					<?php 
						$categories = get_categories();
						foreach($categories as $category) { ?>
							<a href="/category">
								<div class="rp-category" data-colour="#F3E623">
									<div class="underlay">
										<h3><?php echo $category->name; ?></h3>
									</div>
								</div>
							</a>
						<?php }
					?>
				</div>
			</div>
			<div class="rp-section">
				<h2>Newest Recipes</h2>
				<div class="rp-recipe-list full-width">
					<?php 
						// foreach recipe, put it in there with the title and the permalink
						$the_query = new WP_Query( array(
							'post_type' => 'recipe',
							'posts_per_page' => 10,
						) );
						
						if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
							
								get_template_part( 'components/rp', 'card' );
								// get_template_part( 'components/rp', 'card' );
								// get_template_part( 'components/rp', 'card' );
							}
						}
						wp_reset_postdata();
					?>
				</div>
			</div>
			<div class="rp-section">
				<h2>Highest Rated</h2>
				<div class="rp-recipe-list full-width">
					<?php 
						// foreach recipe, put it in there with the title and the permalink
						$the_query = new WP_Query( array(
							'post_type' => 'recipe',
							'posts_per_page' => 10,
							'meta_key' => 'made_its',
							'orderby' => 'meta_value_num',
							'order' => 'DESC'
						) );

						
						if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
							
								get_template_part( 'components/rp', 'card' );
								// get_template_part( 'components/rp', 'card' );
								// get_template_part( 'components/rp', 'card' );
							}
						}
						wp_reset_postdata();
					?>
				</div>
			</div>
			<div class="rp-section">
				<h2>Dinner Recipes</h2>
				<div class="rp-recipe-list full-width">
					<?php 
						// foreach recipe, put it in there with the title and the permalink
						$the_query = new WP_Query( array(
							'post_type' => 'recipe',
							'tag' => 'dinner'
						) );
						
						if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
							
								get_template_part( 'components/rp', 'card' );
								// get_template_part( 'components/rp', 'card' );
								// get_template_part( 'components/rp', 'card' );
							}
						}
						wp_reset_postdata();
					?>
				</div>
			</div>
		</main>
	</div>
</div>
<?php get_footer();