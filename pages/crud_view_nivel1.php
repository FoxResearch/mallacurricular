<?php

require_once("../../../lib/formslib.php");

class view_form extends moodleform {

    function definition() {

        $nivel = 1;
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

        // add activo field
        $mform->addElement('select', 'activo', 'Activo', array(null=>'Elija una opcion',1=>'Si',0=>'No'));
        $mform->setType('activo', PARAM_RAW);
        $mform->setDefault('activo',null);
        $mform->addRule('activo', null, 'required', null, 'client');

        // hidden elements
        $mform->addElement('hidden', "nivel", $nivel);
        $mform->setType( "nivel", PARAM_TEXT);

        $mform->addElement('hidden', 'id' );
        $mform->setType( 'id', PARAM_TEXT);

        $mform->addElement('hidden', 'id_dato1' );
        $mform->setType( 'id_dato1', PARAM_TEXT);

        $mform->addElement('hidden', 'id_dato2' );
        $mform->setType( 'id_dato2', PARAM_TEXT);

        $mform->addElement('hidden', 'id_dato3' );
        $mform->setType( 'id_dato3', PARAM_TEXT);

        $this->add_action_buttons();
    }
}
