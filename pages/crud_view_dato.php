<?php

require_once("../../../lib/formslib.php");

class view_form extends moodleform {

    function definition() {

        $block = 'mallacurricular';

        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', 'Edicion');

        // add page title element.
        $mform->addElement('text', 'nombre', 'Nombre');
        $mform->setType('nombre', PARAM_TEXT);
        $mform->addRule('nombre', null, 'required', null, 'client');

        // add display text field
        $mform->addElement('text', 'codigo', 'Codigo');
        $mform->setType('codigo', PARAM_TEXT);
        $mform->addRule('codigo', null, 'required', null, 'client');

        // add activo field
        $mform->addElement('select', 'activo', 'Activo', array(null=>'Elija una opcion',1=>'Si',0=>'No'));
        $mform->setType('activo', PARAM_TEXT);
        $mform->setDefault('activo',null);
        $mform->addRule('activo', null, 'required', null, 'client');

        // hidden elements
        $mform->addElement('hidden', 'dato');
        $mform->setType('dato', PARAM_TEXT);
        $mform->addElement('hidden', 'id' );
        $mform->setType('id', PARAM_TEXT);

        $this->add_action_buttons();
    }
}
