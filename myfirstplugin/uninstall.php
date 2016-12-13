<?php

if (!defined('WP_UNINSTALL_PLUGIN')) exit();

$option_name = 'myfirstplugin_options';
delete_option($option_name);