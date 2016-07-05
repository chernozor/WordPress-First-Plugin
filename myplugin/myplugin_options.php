<?php

class mypluginSettingsPage {
    public $options;
    public $settings_page_name = 'myplugin_settings';

    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        $this->options = get_option('myplugin_options');
    }

    public function add_plugin_page() {
        add_options_page('Settings Admin', 'myPlugin', 'manage_options', $this->settings_page_name, array($this, 'create_admin_page'));
    }

    public function create_admin_page() {
        $this->options = get_option('myplugin_options');
        ?>
        <div class="wrap">
            <div id="wrapper">
                <form id="settings_form" method="post"
                      action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                    <h1>Плагин myPlugin</h1>
                    <?php
                    settings_fields('myplugin_option_group');
                    do_settings_sections('myplugin_settings');
                    ?>
                    <input type="submit" name="submit_btn" value="Save">
                </form>
            </div>
        </div>
        <?php
    }

    public function page_init() {
        register_setting('myplugin_option_group', 'myplugin_options', array($this, 'sanitize'));

        add_settings_section('setting_section_id', '', // Title
            array($this, 'print_section_info'), $this->settings_page_name);

        add_settings_field('myplugin_first', 'Первая настройка', array($this, 'myplugin_first_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('myplugin_second', 'Вторая настройка', array($this, 'myplugin_second_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('myplugin_result', 'Результат', array($this, 'myplugin_result_callback'), $this->settings_page_name, 'setting_section_id');
    }

    public function sanitize($input) {
        $new_input = array();

        if (isset($input['myplugin_first'])) $new_input['myplugin_first'] = $input['myplugin_first'];

        if (isset($input['myplugin_result'])) $new_input['myplugin_result'] = $input['myplugin_result'];

        if (isset($input['myplugin_second'])) $new_input['myplugin_second'] = $input['myplugin_second'];

        return $new_input;
    }

    public function print_section_info() {
    }

    public function myplugin_first_callback() {
        printf('<input type="text" id="myplugin_first" name="myplugin_options[myplugin_first]" value="%s" title="Введите в данном поле Первую настройку"/>', isset($this->options['myplugin_first']) ? esc_attr($this->options['myplugin_first']) : '');
    }

    public function myplugin_second_callback() {
        printf('<input type="text" id="myplugin_second" name="myplugin_options[myplugin_second]" value="%s" title="Введите в данном поле Вторую настройку" />', isset($this->options['myplugin_second']) ? esc_attr($this->options['myplugin_second']) : '');
    }

    public function myplugin_result_callback() {
        printf('<input type="text" id="myplugin_result" name="myplugin_options[myplugin_result]" value="%s" />', isset($this->options['myplugin_result']) ? esc_attr($this->options['myplugin_result']) : '');
    }
}

function myplugin_set_default_options() {
    $options = get_option('myplugin_options');
    if (is_bool($options)) {
        $options = array();
        $options['myplugin_first'] = '';
        $options['myplugin_second'] = '';
        $options['myplugin_result'] = '';
        update_option('myplugin_options', $options);
    }
}
