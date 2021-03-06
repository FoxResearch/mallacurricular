<?php

require_once("../../../lib/formslib.php");

class view_form extends moodleform {

    function definition() {

        global $coc_config, $USER, $CFG, $DB, $PAGE, $OUTPUT;

        $nivel = 4;
        $padre = $nivel - 1;
        $block = 'mallacurricular';

        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', 'Edicion');

        // add page title element.
        $mform->addElement('text', 'nombre', 'Descripcion');
        $mform->setType('nombre', PARAM_RAW );
        $mform->addRule('nombre', null, 'required', null, 'client');

        // add display text field
        $mform->addElement('text', 'codigo', 'Codigo');
        $mform->setType('codigo', PARAM_RAW );

        // add Padre field
        $options = array(
            null  => 'Elija una opcion'
        );

        $result = $DB->get_records("malla_nivel" . $padre , null );

        foreach( $result as $item ) {
            $options[$item->id] = $item->nombre . ' (' . $item->codigo . ')';
        }

        $mform->addElement(
          'select',
          'id_nivel' . $padre,
          get_string("nivel" . $padre, 'block_' . $block ),
          $options,
          null );
        $mform->setType( 'id_nivel' . $padre, PARAM_RAW);
        $mform->addRule( "id_nivel" . $padre, null, 'required', null, 'client');

        // add Sede & ciclo field
        for( $padre = 1; $padre < 3; $padre = $padre + 1 ) {
          $options = array(
              null  => 'Elija una opcion'
          );

          $result = $DB->get_records("malla_dato" . $padre, null );

          foreach( $result as $item ) {
              $options[$item->id] = $item->nombre . ' (' . $item->codigo . ')';
          }

          $mform->addElement(
            'select',
            "id_dato" . $padre,
            get_string('dato' . $padre, 'block_' . $block ),
            $options,
            null );
          $mform->setType( "id_dato" . $padre, PARAM_RAW);
        }

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
          "id_dato3",
          get_string("dato3", 'block_' . $block ),
          $options,
          null );
        $mform->setType( 'id_dato3', PARAM_INT);

        // add activo field
        $mform->addElement('select', 'activo', 'Activo', array(null=>'Elija una opcion',1=>'Si',0=>'No'));
        $mform->setType( 'activo', PARAM_RAW);
        $mform->addRule('activo', null, 'required', null, 'client');

        // hidden elements
        $mform->addElement('hidden', "nivel", $nivel);
        $mform->setType( "nivel", PARAM_RAW);

        $mform->addElement('hidden', 'id' );
        $mform->setType( 'id', PARAM_RAW);

        $this->add_action_buttons();
    }
}
