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
                    the_content();
                ?>
            </section>
            <?php echo call_to_action(); ?>
        </div> <!-- col-md-12 text-center -->
    </div> <!-- container -->
<?php get_footer(); ?>