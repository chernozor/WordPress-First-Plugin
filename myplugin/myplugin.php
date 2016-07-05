<?php
/*
Plugin Name: myPlugin
Plugin URI: http://webmaster-gambit.ru/
Description: myPlugin — my first plugin.
Version: 1.0.0
Author: Webmaster Gambit
Author URI: http://webmaster-gambit.ru/
*/

include 'myplugin_options.php';

//добавляем ссылку для настроек на странице выбора плагина
add_filter('plugin_action_links', 'myplugin_plugin_action_links', 10, 2);

function myplugin_plugin_action_links($actions, $plugin_file) {
    if (false === strpos($plugin_file, basename(__FILE__))) return $actions;
    $settings_link = '<a href="options-general.php?page=myplugin_settings">Настройки</a>';
    array_unshift($actions, $settings_link);
    return $actions;
}

add_filter('plugin_row_meta', 'myplugin_plugin_description_links', 10, 4);

function myplugin_plugin_description_links($meta, $plugin_file) {
    if (false === strpos($plugin_file, basename(__FILE__))) return $meta;
    $meta[] = '<a href="options-general.php?page=myplugin_settings">Настройки</a>';
    return $meta;
}

$options = get_option('myplugin_options');

if (is_admin()) {
    $options = get_option('myplugin_options');

    if (is_bool($options)) {
        myplugin_set_default_options();
    }

    $url = get_site_url();

    if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_REQUEST['myplugin_options']))) {
        //выполняем код с нашими настройками
        //например, результат сохранения настроект, будет операция слияния строк первого и второго в одну
        $options = $_REQUEST['myplugin_options'];
        $options['myplugin_result'] = intval($options['myplugin_first']) + intval($options['myplugin_second']);
        update_option('myplugin_options', $options);
    } else {
        $options = get_option('myplugin_options');
    }
    $my_settings_page = new mypluginSettingsPage();
}

