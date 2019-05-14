<?php get_header(); ?>
    <!-- Portfolio Grid Section -->
    <?php $user_id = get_current_user_id(); ?>
    <section class="search-section">
        <div class="container">
            <div class="row">
                <div class="input-group mb-3 col-md-6 search-input_field">
                    <input type="text" class="form-control search-input_field" placeholder="Search for creatives here" aria-label="Search for artists here" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="button-addon2">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="portfolio" class="bg-light-gray">
        <div class="container">
			<div class="row">
                <?php
                    $big = 999999999;
                    $number   = 10;
                    $paged    = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;
                    $offset   = ($paged - 1) * $number;
                    $users    = get_users();
                    $query    = get_users('&offset='.$offset.'&number='.$number);
                    $total_users = count($users);
                    $total_query = count($query);
                    $total_pages = ceil($total_users / $number) + 1;
                    $args = array(
                        'value' => 'user_login',
                        'orderby' => 'registered',
                        'order' => 'DESC',
                        'number' => 2,
                        'paged' => $paged,
                    );
                    
                    // The Query
                    $user_query = new WP_User_Query( $args );
                    
                    // User Loop
                    if ( ! empty( $user_query->get_results() ) ) {
                        foreach ( $user_query->get_results() as $user ) {
                            $registered = $user->user_registered;
                            $registered_date = date('F Y', strtotime( $registered ));

                            //If user profile image is not empty
                            if ( isset( $user->profile_image ) ) {
                                $image = $user->profile_image;
                            } else {
                                $image = 'http://www.qmk.co.za/wp-content/uploads/2018/12/banner.jpg';
                            }
                ?>
                
			    <div class="col-md-4 col-sm-5 portfolio-item">
                    <a href="#<?php echo $user->nickname; ?>" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
					            <p><?php echo wp_trim_words( $user->description, 20 ); ?></p>
                            </div>
                        </div>
                        <img src="<?php echo $image; ?>" class="img-responsive" alt="<?php echo get_post_thumbnail_id(); ?>">
                    </a>
                    <div class="portfolio-caption mt-2">
                        <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal"><h4><?php echo $user->nickname; ?></h4></a>
			            <p class="text-muted"><i class="fa fa-tag"></i>&nbsp;<?php echo $user->artform; ?></p>
                    </div>
                </div>
                <?php }} ?>
                <?php wp_reset_postdata(); ?>
			</div>
        </div>
    </section>
    <?php call_to_action(); ?>
    <section>
	    <div class="container">
		    <div class="row">
			    <div class="col-md-7">
                <?php

                if ($total_users > $total_pages) {
                $current_page = max(1, get_query_var('page'));
                echo paginate_links(array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => 'page/%#%/',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_next'    => false,
                'type'         => 'list',
                ));
                } else {
                echo 'No creatives found.';
                }
    ?>
		    </div>
		    </div>
	    </div>
    </section>
    <section>
	    <div class="container">
		    <?php echo paginate_links(); ?>
	    </div>
    </section>
    <?php get_footer(); ?>
    <!-- Modal -->
    <?php
        $args = array(
            'value' => 'user_login',
            'orderby' => 'registered',
            'order' => 'DESC',
            array(
                'meta_key' => 'instagram'
            ),
            array(
                'meta_key' => 'facebook'
            ),
            array(
                'meta_key' => 'twitter'
            ),
            array(
                'meta_key' => 'youtube'
            ),
            array(
                'meta_key' => 'soundcloud'
            ),
            array(
                'meta_key' => 'behance'
            ),
            array(
                'meta_key' => 'website'
            ),
        );
        
        // The Query
        $user_query = new WP_User_Query( $args );
        
        // User Loop
        if ( ! empty( $user_query->get_results() ) ) {
            foreach ( $user_query->get_results() as $user ) {
                $registered = $user->user_registered;
                $registered_date = date('F Y', strtotime( $registered ));
                //If user profile image is not empty
                if ( isset( $user->profile_image ) ) {
                    $image = $user->profile_image;
                } else {
                    $image = 'http://www.qmk.co.za/wp-content/uploads/2018/12/banner.jpg';
                }
    ?>
<div class="modal fade" id="<?php echo $user->nickname; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="container">
        <div class="row">
            <div class="modal-dialog" role="document">
                <div class="col-md-8 modal-offset">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel"><?php echo $user->nickname; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                        <span class="badge badge-primary artform-label artform-label-home"><?php echo $user->artform; ?></span>
                            <img class="img-responsive img-centered" src="<?php echo $image; ?>" alt="" class="mb-2" />
                            <p><?php echo $user->description; ?></p>
                        <p><strong>Follow <?php echo $user->nickname; ?></strong></p>
                        <div class="text-block text-center social">
                            <ul class="list-inline social-buttons">
                            <?php
                                if (!empty($user->facebook)) {
                                    echo '<li><a href="'. $user->facebook .'"><i class="fa fa-facebook"></i></a></li>';
                                } 
                                if (!empty($user->instagram)) {
                                    echo '<li><a href="'. $user->instagram .'"><i class="fa fa-instagram"></i></a></li>';
                                }
                                
                                if (!empty($user->twitter)) {
                                    echo '<li><a href="'. $user->twitter .'"><i class="fa fa-twitter"></i></a></li>';
                                }
                                if (!empty($user->youtube)) {
                                    echo '<li><a href="'. $user->youtube .'"><i class="fa fa-youtube"></i></a></li>';
                                }
                                if (!empty($user->soundcloud)) {
                                    echo '<li><a href="'. $user->soundcloud .'"><i class="fa fa-soundcloud"></i></a></li>';
                                }
                                if (!empty($user->behance)) {
                                    echo '<li><a href="'. $user->behance .'"><i class="fa fa-behance"></i></a></li>';
                                }
                                if (!empty($user->website)) {
                                    echo '<li><a href="'. $user->website .'"><i class="fa fa-globe"></i></a></li>';
                                }
                            ?>
                            </ul>
                        </div>
                            <ul class="list-inline text-cente">
                                <li>Since: <?php echo $registered_date; ?></li>
                                <li>Area code: <?php echo $user->area_code; ?></li>
                            </ul>
                        </div>
                        <?php
                            if ( $user_id != $user->ID ) { ?>
                                <div class="modal-footer btn-group btn-group-sm">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        <?php    } else {
                        ?>
                    <div class="modal-footer btn-group btn-group-sm">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="<?php echo esc_url( site_url( '/profile/' ) ); ?>" class="btn btn-primary">Edit Profile</a>
                    </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                        <?php }} ?>