<?php get_header(); ?>
    <div class="container">
        <div class="col-md-12 col-xl-12 text-center">
            <section class="about-qmk">
                <?php while ( have_posts() ): the_post(); ?>
                <h2 class="section-heading"><?php $title = get_the_title(); echo ucwords($title); ?></h2>
                <?php the_content(); ?>
            </section>
            <section class="video-embed">
                <div class="col-md-8 center-block embed-responsive embed-responsive-16by9">
                    <?php the_field( 'video_link' ); ?>
                </div>
                <?php endwhile; ?>
            </section>
            <div id="qmk-carousel" class="carousel slide carousel-fade" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                        $count = 0;
                        $i = 0;
                        $slider = new WP_Query(
                            array(
                                'post_type' => 'slider',
                                'post_per_page' => -1,
                            )
                        );
                        while ( $slider->have_posts() ) {
                            $slider->the_post();
                            $count = $count + 1;
                    ?>
                    <li class="" data-target="#qmk-carousel-indicators" data-slide-to="<?php echo $count; ?>"></li>
                        <?php } ?>
                </ol>
                <div class="carousel-inner col-md-8">
                    <?php
                        while ( $slider->have_posts() ) {
                            $slider->the_post();
                    ?>
                    <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                        <img class="d-block" src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo get_post_thumbnail_id(); ?>" width="720px" height="300">
                    </div>
                    <?php $i++;?>
                    <?php wp_reset_postdata(); ?>
                    <?php } ?>
                </div>
                <p><a class="carousel-control-prev" href="#qmk-carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#qmk-carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </p>
            </div>
            <div class="col-md-12 text-center soundcloud-audio">
                <?php the_field( 'soundcloud_audio' ); ?>
            </div>
            <section id="about-qmk">
                <div class="container">
                    <div class="row">
                        <?php while ( have_posts() ): the_post(); ?>
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading"><?php the_title(); ?></h2>
                            <p class="about-qmk-p"><?php the_field( 'heading_three' ); ?></p>
                            <p class="hobo-form"><?php the_field( 'services_heading' ); ?></p>
                            <div class="media">
                                <?php 
                                    $slider = new WP_Query(
                                        array(
                                            'post_type' => 'service',
                                            'post_per_page' => 2,
                                            'order' => 'ASC',
                                            'post__in' => array(67, 70)
                                        )
                                    );
                                    while ( $slider->have_posts() ) {
                                        $slider->the_post();
                                ?>
                                <div class="media-body col-12-12">
                                    <h4 class="media-heading hobo-form"><?php the_title(); ?></h4>
                                    <?php the_content(); ?>
                                </div>
                                <?php wp_reset_postdata(); ?>
                                <?php } ?>
                            </div>
                            <div class="media">
                                <?php 
                                    $slider = new WP_Query(
                                        array(
                                            'post_type' => 'service',
                                            'post_per_page' => 2,
                                            'order' => 'ASC',
                                            'post__in' => array(68, 71)
                                        )
                                    );
                                    while ( $slider->have_posts() ) {
                                        $slider->the_post();
                                ?>
                                <div class="media-body col-md-12">
                                    <h4 class="media-heading hobo-form"><?php the_title(); ?></h4>
                                    <?php the_content(); ?>
                                </div>
                                <?php wp_reset_postdata(); ?>
                                <?php } ?>
                            </div>
                            <div class="media">
                                <?php 
                                    $slider = new WP_Query(
                                        array(
                                            'post_type' => 'service',
                                            'post_per_page' => 2,
                                            'order' => 'ASC',
                                            'post__in' => array(69, 72)
                                        )
                                    );
                                    while ( $slider->have_posts() ) {
                                        $slider->the_post();
                                ?>
                                <div class="media-body col-md-12">
                                    <h4 class="media-heading hobo-form"><b><?php the_title(); ?></b></h4>
                                    <?php the_content(); ?>
                                </div>
                                <?php wp_reset_postdata(); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    </div>
                </div>
            </section>
            <section id="contact" class="section-quote">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <p class="hobo-form"><?php (the_field( 'request_quote' )); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <?php echo call_to_action(); ?>
        </div> <!-- col-md-12 text-center -->
    </div> <!-- container -->
<?php get_footer(); ?>