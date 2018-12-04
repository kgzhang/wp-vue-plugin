<?php
/**
 * Plugin Name: ShortVue
 * Description: ShortCode rendering in vue
 * Version:     0.0.1
 * Author:      Kaige
 */

require_once dirname(__FILE__) . '/includes/vue-render.php';

if (!function_exists('short_vue_init')) {
    function short_vue_init () {
        $class = new VueRender();
        $class->register();
    }

    add_action('init', 'short_vue_init');
}
