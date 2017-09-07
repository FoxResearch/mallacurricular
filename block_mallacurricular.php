<?php

class block_mallacurricular extends block_base {

    //
    // Primer metodo a ser llamado
    //
    public function init() {
        $this->title = get_string('titulo', 'block_mallacurricular');
    }

    public function get_content() {

        global $coc_config, $USER, $CFG, $DB, $PAGE, $OUTPUT;

        /*
            PREPARE
        */

        // Don't run this function twice.
        if ($this->content !== null) {
            return $this->content;
        }

        // Get plugin config.
        $coc_config = get_config('block_mallacurricular');

        $this->content         =  new stdClass();
        $this->content->text   = 'The content of our Malla Curricular block!';

        $url1 = new moodle_url(
            '/blocks/mallacurricular/admin_index.php',
            array( 'id' => 0 )
        );

        $url2 = new moodle_url(
            '/blocks/mallacurricular/search/search_controller.php',
            array( 'id' => 0 )
        );

        $url3 = new moodle_url(
            '/blocks/mallacurricular/repo/repo_controller.php',
            array( 'id' => 0 )
        );

        $this->content->footer =
          html_writer::link($url1, 'Administrador') . " | " .
          html_writer::link($url2, 'Busqueda') . " | " .
          html_writer::link($url3, 'Reporte') . " | " ;

        return $this->content;
    }

    //
    // Este metodo es llamado apenas luego de que se ejecuta el INIT
    //
    public function specialization() {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('titulo', 'block_mallacurricular');
            } else {
                $this->title = $this->config->title;
            }

            if (empty($this->config->text)) {
                $this->config->text = get_string('titulo', 'block_mallacurricular');
            }
        }
    }

    public function instance_can_be_hidden() {
        return false;
    }

    //
    // No permite mas de 1 bloque
    public function instance_allow_multiple() {
        return true;
    }

    function applicable_formats() {
        return array('all' => true, 'tag' => false);
    }
}
