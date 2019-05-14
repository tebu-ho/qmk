<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset=" <?php bloginfo( 'charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head(); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" <?php body_class( 'index' ); ?>>
    <nav class="navbar navbar-dark navbar-expand-lg navbar-fixed-top">
        <div class="container nav-container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <?php the_custom_logo(); ?>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Custom Menu -->
               <?php
                    if ( !is_user_logged_in() ) {
                        wp_nav_menu(
                            array(
                                'container_id'    => 'bs-example-navbar-collapse-1',
                                'container_class' => 'collapse navbar-collapse justify-content-end',
                                'menu_class'      => 'nav navbar-nav navbar-right',
                                'theme_location'  => 'login_register_menu',
                            )
                        );
                    } else {
                        wp_nav_menu(
                            array(
                                'container_id'    => 'bs-example-navbar-collapse-1',
                                'container_class' => 'collapse navbar-collapse justify-content-end',
                                'menu_class'      => 'nav navbar-nav navbar-right',
                                'theme_location'  => 'Primary',
                            )
                        );
                        echo '<li class="menu-item logout"><a href=" ' . wp_logout_url( home_url() ) . '" class="nav-link">Logout</a></li>';
                    }
                ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- Header -->
    <header style="background-image: url(<?php header_image(); ?>);">
        <div class="container">
            <div class="intro-text">
               <?php
                    while (have_posts()):
                        the_post();
                ?>
                <div class="intro-lead-in"><?php the_field( 'showcase_and_discover' ); ?></div>
                <div class="intro-heading"><?php bloginfo( 'description' ); ?><br>
                <small><?php  the_field( 'creatives_places_lifestyle' ); ?></small></div>
                <?php endwhile; ?>
                <div class="col-md-12">
                    <ul class="list-group list-group-horizontal list-inline social-buttons">
                        <?php
                            $args = array(
                                'role' => 'Administrator',
                                'meta_key' => 'facebook',
                            );
                            
                            // The Query
                            $user_query = new WP_User_Query( $args );
                            // User Loop
                        if ( ! empty( $user_query->get_results() ) ) {
                            foreach ( $user_query->get_results() as $user ) {
                                $registered = $user->user_registered;
                                $registered_date = date('F Y', strtotime( $registered ));
                        ?>
                        <li><a href="<?php echo $user->facebook; ?>"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="<?php echo $user->instagram; ?>"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li><a href="<?php echo $user->youtube; ?>"><i class="fa fa-youtube"></i></a>
                        </li>
                        <li><a href="<?php echo $user->soundcloud; ?>"><i class="fa fa-soundcloud"></i></a>
                        </li>
                            <?php }} ?>
                    </ul>
                </div>
            </div>
        </div>
    </header>