<?php

require_once("../../../lib/formslib.php");

class view_form extends moodleform {

    function definition() {

        $nivel_padre = '2';
        $block = 'mallacurricular';

        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', 'Edicion');

        // add page title element.
        $mform->addElement('text', 'nombre', 'Nombre');
        $mform->setType('nombre', PARAM_RAW);
        $mform->addRule('nombre', null, 'required', null, 'client');

        // add display text field
        $mform->addElement('text', 'codigo', 'Codigo');
        $mform->setType('codigo', PARAM_RAW);
        $mform->addRule('codigo', null, 'required', null, 'client');

        // add Padre field

        $options = array(
            null  => 'Elija una opcion'
        );

        $result = $DB->get_records('malla_nivel' . $nivel_padre , null );

        foreach( $result as $item ) {
            $options[$item->id] = $item->nombre . ' (' . $item->codigo . ')';
        }

        $mform->addElement(
          'select',
          'id_nivel' . $nivel_padre,
          get_string('nivel' . $nivel_padre, $block ),
          $options,
          null );
        $mform->addRule( 'id_nivel' . $nivel_padre, null, 'required', null, 'client');

        // add activo field
        $mform->addElement('select', 'activo', 'Activo', array(null=>'Elija una opcion',1=>'Si',0=>'No'));
        $mform->setDefault('activo',null);
        $mform->addRule('activo', null, 'required', null, 'client');

        // add date_time selector in optional area
        // $mform->addElement('date_time_selector', 'displaydate', 'hola', array('optional' => true));
        // $mform->setAdvanced('optional');

        // hidden elements
        $mform->addElement('hidden', 'id');

        $this->add_action_buttons();
    }
}
