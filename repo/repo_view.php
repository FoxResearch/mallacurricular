<?php

require_once("../../../lib/formslib.php");

class view_form extends moodleform {

    function definition() {

        global $coc_config, $USER, $CFG, $DB, $PAGE, $OUTPUT;

        $block = 'mallacurricular';

        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', 'Edicion');

        // add curso moodle
        $options = array(
            null  => 'Elija una opcion'
        );
        $result = get_courses();

        foreach( $result as $item ) {
            $options[$item->id] = $item->fullname;
        }

        $mform->addElement(
          'select',
          "id",
          get_string("dato3", 'block_' . $block ),
          $options,
          null );
        $mform->setType( 'id', PARAM_INT);

        // hidden elements

        $this->add_action_buttons(false, 'Ver Reporte');
    }
}
