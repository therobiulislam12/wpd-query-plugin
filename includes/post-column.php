<?php

/**
 * Post Column Add
 */

class Wpd_Post_Column {
    public function __construct() {
        add_filter( 'manage_page_posts_columns', [$this, 'posts_columns'], 10, 1 );
        add_action( 'manage_page_posts_custom_column', [$this, 'add_custom_value'], 10, 2 );
        add_filter( 'manage_edit-page_sortable_columns', array( $this, 'sortable_columns' ), 10, 1 );
        add_action( 'wp_head', [$this, 'count_post_view'] );
    }

    public function posts_columns( $columns ) {
        // error_log( print_r($columns, true) );

        $new_columns = [];

        foreach ( $columns as $key => $column ) {
            if ( 'cb' == $key ) {
                $new_columns[$key] = $column;
                $new_columns['image'] = 'Thumbnail';
                continue;
            }

            if ( 'author' == $key ) {
                $new_columns[$key] = $column;
                $new_columns['view'] = 'Views';
                continue;
            }

            $new_columns[$key] = $column;
        }

        return $new_columns;
    }

    /**
     * add custom value
     */
    public function add_custom_value( $column_name, $post_id ) {
        if ( 'image' === $column_name ) {
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, 'thumbnail' );
            } else {
                echo 'No Image';
            }
        }

        if ( 'view' == $column_name ) {
            $view_count = get_post_meta( $post_id, '_view_count', true );

            echo $view_count ? $view_count : 0;
        }
    }

    /**
     * Sortable function
     */
    public function sortable_columns( $columns ) {
        $columns['view'] = 'view';
        $columns['image'] = 'image';

        // error_log( print_r($columns, true) );

        // var_dump($columns);

        return $columns;
    }

    /**
     * Post Count View with metadata
     */
    public function count_post_view() {
        if ( is_page() ) {
            global $post;
            // get previous count
            $view_count = get_post_meta( $post->ID, '_view_count', true );

            if ( !$view_count ) {
                $view_count = 0;
            } else {
                $view_count = intval( $view_count );
            }

            // Increment
            $view_count += 1;

            // Save new count
            update_post_meta( $post->ID, '_view_count', $view_count );
        }
    }
}
