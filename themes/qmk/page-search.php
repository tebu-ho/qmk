<?php get_header(); ?>
    <div class="container">
        <div class="col-md-12 col-xl-12 text-center">
            <section class="bg-light-gray">
                <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                        }
                    }
                ?>
                <div class="wp-search-container">
                    <form action="<?php echo esc_url( site_url( '/search/' ) ); ?>" method="get">
                        <input type="search" name="s">
                        <input type="submit" value="Search">
                    </form>
                </div>
            </section>
            <?php echo call_to_action(); ?>
        </div> <!-- col-md-12 text-center -->
    </div> <!-- container -->
<?php get_footer(); ?>
