<?php get_header(); ?>
    <section id="portfolio" class="bg-light-gray">
        <div class="container">
			<div class="row">
                <?php 
                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                $big = 999999999;
                    $query = new WP_Query(
                        array(
                            'post_type' => 'video',
                            'posts_per_page' => 2,
                            'paged' => $paged,
                        )
                    );
                    if ( have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post();
                ?>
				<div class="col-md-4 col-sm-5 portfolio-item">
                    <?php the_content(); ?>
                    <div class="portfolio-caption">
                        <h4><?php the_title(); ?></h4>
						<p class="text-muted"><i class="fa fa-tag"></i>&nbsp;<?php the_field( 'area_code' ); ?></p>
                    </div>
                </div>
                <?php } } 
                ?>
            </div>
        </div>
    </section>
    <?php echo call_to_action(); ?>
    <section>
	    <div class="container">
		    <div class="row">
			    <div class="col-md-8">
                    <?php 
                echo paginate_links(
                    array(
                        'total' => $query->max_num_pages,
                        'prev_text' => 'Previous',
                        'next_text' => 'Next',
                        'show_all' => true,
                        'type' => 'plain',
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'type' => 'list',
                    )
                ); ?>
		    </div>
		    </div>
	    </div>
    </section>
<?php get_footer(); ?>