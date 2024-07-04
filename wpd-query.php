<?php

/**
 * Plugin Name: Query Learning
 * Description: Learn more about wordpress query
 * Version: 1.0.0
 * Author: Robiul Islam
 * Text Domain: wpd_query
 */

if ( !defined( 'ABSPATH' ) ) {
    exit();
}

final class Wpd_Query_Robiul {
    private static $instance;

    private function __construct() {
        // initialize first action
        add_action( 'init', [$this, 'wpd_init'] );
    }

    /**
     * Create a instance method
     */
    public static function getInstance() {
        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initialize function for plugin
     *
     * @return mixed
     */
    public function wpd_init() {
        // call require classes
        $this->require_classes();

    }

    /**
     * Call all require classes here
     *
     * @return mixed
     */
    public function require_classes() {
        require_once __DIR__ . '/includes/admin_menu.php';

        new Admin_menu();
    }
}

function wpd_query() {
    return Wpd_Query_Robiul::getInstance();
}

// kick of the class
wpd_query();
