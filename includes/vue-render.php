<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (!class_exists('VueRender')) {
    class VueRender {
        private $shrotcode_name = 'short';

        public function register()
        {
            // 注册shortcode
            add_shortcode($this->shrotcode_name, [$this, 'shortcode']);
            // 加载shortcode对应的js和css文件
            add_action('wp_enqueue_scripts', [$this, 'scripts']);
            // 添加ajax请求
            add_action('wp_ajax_nopriv_submit_form', [$this, 'submit_form']);
            add_action('wp_ajax_nopriv_get_data', [$this, 'get_data']);
            // 登录用户请求
            add_action('wp_ajax_submit_form', [$this, 'submit_form']);
            add_action('wp_ajax_get_data', [$this, 'get_data']);
        }

        public function shortcode($atts) {
            // 获取shortcode属性并添加渲染
            $short_atts = esc_attr(json_encode([
                'name' => 'test'
            ]));
            return "<div data-vue-atts='{$short_atts}'>Loading short...</div>";
        }

        public function scripts()
        {
            global $post;
            // 渲染post内容
            if (has_shortcode($post->post_content, $this->shrotcode_name)) {
                // 添加只针对本shortcode的js文件
                wp_enqueue_script('vue-render', plugin_dir_url(__FILE__) . 'js/vue-render.js', ['MainJs'], '0.1', true);
                // 全局添加ajax路径
                wp_add_inline_script('vue-render', 'window.ajaxUrl = "' . admin_url('admin-ajax.php') . '"');
                // 添加渲染vue组件的css文件
                wp_enqueue_style('vue-render', plugin_dir_url(__FILE__) . 'css/vue-render.css', ['MainStyles'], '0.1');
            }
        }

        // 添加ajax post请求
        public function submit_form()
        {
            exit('success');
        }
        // 添加ajax get请求
        public function get_data()
        {
            $data = [
                'name' => 'test'
            ];
            exit(json_encode($data));
        }
    }
}
