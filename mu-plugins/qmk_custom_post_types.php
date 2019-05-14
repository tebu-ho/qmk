<?php
    function add_qmk_custom_post_types()
    {
    register_post_type(
        'slider', array(
            'public' => true,
            'supports' => array(
                'thumbnail',
                'editor',
            ),
            'labels' => array(
                'name' => 'Slider',
                'add_new_item' => 'Add Slide',
                'edit_item' => 'Edit Slide',
                'all_items' => 'All Slides',
                'Singular' => 'Slide',
            ),
            'menu_icon' => 'dashicons-images-alt2',
        )
    );
    register_post_type(
        'video', array(
            'public' => true,
            'supports' => array(
                'editor',
                'title',
            ),
            'labels' => array(
                'name' => 'videos',
                'add_new_item' => 'Add video',
                'edit_item' => 'Edit video',
                'all_items' => 'All videos',
                'Singular' => 'video',
            ),
            'menu_icon' => 'dashicons-admin-media',
        )
    );
    
    register_post_type(
        'video', array(
            'public' => true,
            'supports' => array(
                'editor',
                'title',
                'custom-fields',
            ),
            'labels' => array(
                'name' => 'Videos',
                'add_new_item' => 'Add Video',
                'edit_item' => 'Edit Video',
                'all_items' => 'All Videos',
                'Singular' => 'Video',
            ),
            'menu_icon' => 'dashicons-video-alt2',
        )
    );  
    
    register_post_type(
        'profile', array(
            'show_in_rest' => true,
            'public' => true,
            'supports' => array(
                'editor',
                'title',
                'custom-fields',
                'thumbnail',
            ),
            'labels' => array(
                'name' => 'Profile',
                'add_new_item' => 'Add Profile',
                'edit_item' => 'Edit Profile',
                'all_items' => 'All Profiles',
                'Singular' => 'Profile',
            ),
            'menu_icon' => 'dashicons-admin-users',
        )
    );  
    }
add_action( 'init', 'add_qmk_custom_post_types' );