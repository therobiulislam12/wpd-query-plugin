<?php

class Admin_menu {
    public function __construct() {
        // create a admin menu
        add_action( 'admin_menu', [$this, 'wpd_admin_menu'] );
    }

    public function wpd_admin_menu() {
        // add_menu_page( __( 'WPD Query Plugin', 'wpd_query' ), __( 'WPD All Posts', 'wpd_query' ), 'manage_options', 'wpd_posts_query', [$this, 'wpd_register_admin_menu'], 'dashicons-editor-contract', 30 );

        add_menu_page( __( 'weDevs PD Query Plugin', 'wpd_query' ), __( 'WPD All Posts', 'wpd_query' ), 'manage_options', 'wpd_posts_query', [$this, 'wpd_register_admin_menu'], 'dashicons-editor-contract', 30 );
    }

    /**
     * Admin Menu register function
     *
     * @return void
     */
    public function wpd_register_admin_menu() {
        $date_format = 'Y/m/d';
        $time_format = 'g:i a';

        $posts_args = [
            'post_type'      => 'post',
            'order'          => 'ASC',
            'orderby'        => 'ID',
            'posts_per_page' => -1,
        ];

        if ( isset( $_GET['wpd_category'] ) && $_GET['wpd_category'] > 0 ) {
            $posts_args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $_GET['wpd_category'],
                ],
            ];
        }

        if ( isset( $_GET['wpd_author'] ) && $_GET['wpd_author'] > 0 ) {
            $posts_args['author'] = $_GET['wpd_author'];
        }

        $posts = get_posts( $posts_args );

        $terms = get_terms( [
            'taxonomy' => 'category',
        ] );

        $authors = get_users();

        $post_count = wp_count_posts( 'post' );

        // print_r( $post_count );

        include_once __DIR__ . '/views/admin.view.php';
    }
}