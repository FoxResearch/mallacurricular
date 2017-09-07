<?php

require_once("../../../lib/formslib.php");

class view_form extends moodleform {

    function definition() {

        global $coc_config, $USER, $CFG, $DB, $PAGE, $OUTPUT;

        $block = 'mallacurricular';

        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', 'Edicion');

        $options = array(
            'multiple' => false,
            'noselectionstring' => 'Elija una opcion',
        );

        // add page title element.
        for( $i = 1; $i < 5; $i = $i + 1 ) {
          $sql =
            "SELECT " .
            "N" . $i . ".nombre as dato " .
            "FROM {malla_nivel" . $i . "} N" . $i . " " .
            "WHERE N" . $i . ".activo = 1 " .
            "UNION SELECT " .
            "N" . $i . ".codigo as dato " .
            "FROM {malla_nivel" . $i . "} N" . $i . " " .
            "WHERE N" . $i . ".activo = 1 ";
          $result = $DB->get_records_sql( $sql , null );
          $items = array();
          $items[null] = "Elija una opcion";
          foreach( $result as $item ) {
            $items[$item->dato] = $item->dato;
          }
          $mform->addElement('autocomplete', 'nivel' . $i, get_string('nivel' . $i, 'block_mallacurricular'), $items, $options );
          $mform->setType('nivel' . $i , PARAM_RAW );
        }

        // add page title element.
        for( $i = 1; $i < 3; $i = $i + 1 ) {
          $sql =
            "SELECT " .
            "D" . $i . ".nombre as dato " .
            "FROM {malla_dato" . $i . "} D" . $i . " " .
            "WHERE activo = 1 " .
            "UNION SELECT " .
            "D" . $i . ".codigo as dato " .
            "FROM {malla_dato" . $i . "} D" . $i . " " .
            "WHERE activo = 1 ";
          $result = $DB->get_records_sql( $sql , null );
          $items = array();
          $items[null] = "Elija una opcion";
          foreach( $result as $item ) {
            $items[$item->dato] = $item->dato;
          }
          $mform->addElement('autocomplete', 'dato' . $i, get_string('dato' . $i, 'block_mallacurricular'), $items, $options );
          $mform->setType('dato' . $i , PARAM_RAW );
        }

        $this->add_action_buttons(false, 'Buscar');
    }
}
