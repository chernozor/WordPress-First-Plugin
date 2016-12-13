<?php

class myFirstPluginSettingsPage {
    public $options;
    public $settings_page_name = 'myfirstplugin_settings';

    public function __construct() {
        add_action('admin_menu', array($this, 'add_myfirstplugin_page'));
        add_action('admin_init', array($this, 'myfirstplugin_page_init'));
        $this->options = get_option('myfirstplugin_options');
    }

    public function add_myfirstplugin_page() {
        add_options_page('My First Plugin Settings', 'My First Plugin', 'manage_options', $this->settings_page_name, array($this, 'create_myfirstplugin_admin_page'));
    }

    public function create_myfirstplugin_admin_page() {
        $this->options = get_option('myfirstplugin_options');
        ?>
        <div class="wrap">
            <div id="wrapper">
                <form id="settings_form" method="post"
                      action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                    <h1>Плагин My First Plugin</h1>
                    <?php
                    settings_fields('myfirstplugin_option_group');
                    do_settings_sections('myfirstplugin_settings');
                    ?>
                    <input type="submit" name="submit_btn" value="Save">
                </form>
            </div>
        </div>
        <?php
    }

    public function myfirstplugin_page_init() {
        register_setting('myfirstplugin_option_group', 'myfirstplugin_options', array($this, 'sanitize'));

        add_settings_section('setting_section_id', '', // Title
            array($this, 'print_section_info'), $this->settings_page_name);

        add_settings_field('myfirstplugin_first', 'Первая настройка', array($this, 'myfirstplugin_first_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('myfirstplugin_second', 'Вторая настройка', array($this, 'myfirstplugin_second_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('myfirstplugin_result', 'Результат', array($this, 'myfirstplugin_result_callback'), $this->settings_page_name, 'setting_section_id');
    }

    public function sanitize($input) {
        $new_input = array();

        if (isset($input['myfirstplugin_first'])) $new_input['myfirstplugin_first'] = $input['myfirstplugin_first'];

        if (isset($input['myfirstplugin_result'])) $new_input['myfirstplugin_result'] = $input['myfirstplugin_result'];

        if (isset($input['myfirstplugin_second'])) $new_input['myfirstplugin_second'] = $input['myfirstplugin_second'];

        return $new_input;
    }

    public function print_section_info() {
    }

    public function myfirstplugin_first_callback() {
        printf('<input type="text" id="myfirstplugin_first" name="myfirstplugin_options[myfirstplugin_first]" value="%s" title="Введите в данном поле Первую настройку"/>', isset($this->options['myfirstplugin_first']) ? esc_attr($this->options['myfirstplugin_first']) : '');
    }

    public function myfirstplugin_second_callback() {
        printf('<input type="text" id="myfirstplugin_second" name="myfirstplugin_options[myfirstplugin_second]" value="%s" title="Введите в данном поле Вторую настройку" />', isset($this->options['myfirstplugin_second']) ? esc_attr($this->options['myfirstplugin_second']) : '');
    }

    public function myfirstplugin_result_callback() {
        printf('<input type="text" id="myfirstplugin_result" name="myfirstplugin_options[myfirstplugin_result]" value="%s" />', isset($this->options['myfirstplugin_result']) ? esc_attr($this->options['myfirstplugin_result']) : '');
    }
}

function myfirstplugin_set_default_options() {
    $options = get_option('myfirstplugin_options');
    if (is_bool($options)) {
        $options = array();
        $options['myfirstplugin_first'] = '';
        $options['myfirstplugin_second'] = '';
        $options['myfirstplugin_result'] = '';
        update_option('myfirstplugin_options', $options);
    }
}
