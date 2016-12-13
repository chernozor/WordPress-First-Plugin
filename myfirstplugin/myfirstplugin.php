<?php
/**
 *   Plugin Name: My First Plugin
 *   Plugin URI: http://webmaster-gambit.ru/
 *   Description: My First Plugin — simple plug-in for WordPress
 *   Version:    1.0.0
 *   Author:     Gambit
 *   Author URI: http://webmaster-gambit.ru/
 **/

include 'myfirstplugin_options.php';

//добавляем ссылку для настроек на странице выбора плагина
add_filter('plugin_action_links', 'myfirstplugin_plugin_action_links', 10, 2);

function myfirstplugin_plugin_action_links($actions, $plugin_file) {
    if (false === strpos($plugin_file, basename(__FILE__))) return $actions;
    $settings_link = '<a href="options-general.php?page=myfirstplugin_settings">Настройки</a>';
    array_unshift($actions, $settings_link);
    return $actions;
}

add_filter('plugin_row_meta', 'myfirstplugin_plugin_description_links', 10, 4);

function myfirstplugin_plugin_description_links($meta, $plugin_file) {
    if (false === strpos($plugin_file, basename(__FILE__))) return $meta;
    $meta[] = '<a href="options-general.php?page=myfirstplugin_settings">Настройки</a>';
    return $meta;
}

add_action('admin_menu', function () {
    add_menu_page('My First Plugin Settings', 'My First Plugin', 'manage_options', 'myfirstplugin_settings', 'add_myfirstplugin_setting', plugin_dir_url(__FILE__) . '/img/logo.png', 100);
});

// функция отвечает за вывод страницы настроек
function add_myfirstplugin_setting() {
    $myfirstplugin_settings_page = new myFirstPluginSettingsPage();
    if (!isset($myfirstplugin_settings_page)) {
        wp_die(__('Plugin uLogin has been installed incorrectly.'));
    }
    if (function_exists('add_plugins_page')) {
        add_plugins_page('My First Plugin Settings', 'My First Plugin', 'manage_options', basename(__FILE__), array(&$myfirstplugin_settings_page, 'create_myfirstplugin_admin_page'));
    }

}

$options = get_option('myfirstplugin_options');

if (is_admin()) {
    $options = get_option('myfirstplugin_options');

    if (is_bool($options)) {
        myfirstplugin_set_default_options();
    }

    $url = get_site_url();

    if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_REQUEST['myfirstplugin_options']))) {
        //выполняем код с нашими настройками
        //например, результат сохранения настроект, будет операция слияния строк первого и второго в одну
        $options = $_REQUEST['myfirstplugin_options'];
        $options['myfirstplugin_result'] = intval($options['myfirstplugin_first']) + intval($options['myfirstplugin_second']);
        update_option('myfirstplugin_options', $options);
    } else {
        $options = get_option('myfirstplugin_options');
    }
    $my_settings_page = new myfirstpluginSettingsPage();
}

