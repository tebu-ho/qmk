<?php
    wp_redirect( esc_url( wp_logout() ) );
    wp_redirect( esc_url( site_url( '/' ) ) );
?>