<?php

require_once('../../../config.php');

// inicializacion de variables
$settingsnode = null;
$editurl = null;
$editnode = null;
$course = null;
$html = null;
$toform = array();
$fromform = null;
$id = null;

global $DB, $OUTPUT, $PAGE;

// ID del registro a editar
$nivel = optional_param('nivel', 0, PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);

require_once('crud_view_nivel' . $nivel . '.php');
$padre = $nivel - 1;

// NAVIGATION TOP
$settingsnode = $PAGE->settingsnav->add(get_string('titulo', 'block_mallacurricular'));
$editurl = new moodle_url(
  '/blocks/mallacurricular/admin_index.php',
  array('id' => 0) );
$editnode = $settingsnode->add( 'Inicio', $editurl );
$editnode->make_active();

// infraestructura de la pagina MOODLE
$PAGE->set_url(
  '/blocks/mallacurricular/pages/crud_controller_nivel.php',
  array('nivel' => $nivel));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading( get_string('titulo', 'block_mallacurricular') );

// Seleccion de la vista
$html = new view_form();

// Manejo de casos posibles
$fromform = $html->get_data();

// Cancelled forms
if( $html->is_cancelled() ) {
    $courseurl = new moodle_url(
      '/blocks/mallacurricular/admin_index.php',
      array('id' => 0) );
    redirect($courseurl);
}

// We need to add code to appropriately act on and store the submitted data
// but for now we will just redirect back to the course main page.
else if ( $fromform != null ) {

    // print_object($fromform);
    // Actualizacion de registros
    if ($fromform->id != 0) {
      if (!$DB->update_record('malla_nivel' . $nivel, $fromform)) {
        $message = 'Ha ocurrido un error al actualizar el codigo (' . $fromform->codigo . ') id (' . $id . ')';
      }
      else {
        $message = 'Se ha actualizado el codigo (' . $fromform->codigo . ') id (' . $id . ')';
      }
    }

    // Insercion de registros
    else {

      if (!$DB->insert_record('malla_nivel' . $nivel, $fromform)) {
        $message = 'Ha ocurrido un error al crear el codigo (' . $fromform->codigo . ') id (' . $id . ')';
      }
      else {
        $message = 'Se ha creado el codigo (' . $fromform->codigo . ')';
        $id = 0;
      }
    }

    // Redirige para mostrarle el resultado final al usuario
    $editurl = new moodle_url(
        '/blocks/mallacurricular/pages/crud_controller_nivel.php',
        array('nivel' => $nivel, 'id' => $id ));
    redirect($editurl, $message);
}

// form didn't validate or this is the first display
else {

    // En caso se este solicitando la actualizacion del registro por su ID
    if( $id > 0 ) {
      $toform['displayinfo'] = get_string('update_nivel' . $nivel, 'block_mallacurricular');

      // Recuperar el registro para poder editarlo
      $result = $DB->get_record('malla_nivel' . $nivel , array( 'id' => $id ));
      if( $result != null ) {
        $toform['nombre'] = $result->nombre;
        $toform['codigo'] = $result->codigo;
        $toform['activo'] = $result->activo;
        $toform['id']     = $result->id;
        if( isset($result->{"id_nivel" . $padre})) $toform["id_nivel" . $padre] = $result->{"id_nivel" . $padre};
        if( isset($result->$id_dato1)) $toform["id_dato1"] = $result->$id_dato1;
        if( isset($result->$id_dato2)) $toform["id_dato2"] = $result->$id_dato2;
        if( isset($result->$id_dato3)) $toform["id_dato3"] = $result->$id_dato3;
      }
    }
    else {
      $toform['displayinfo'] = get_string('create_nivel' . $nivel, 'block_mallacurricular');
    }

    // Enviar al formulario
    $html->set_data($toform);

    // Impresion de la pagina
    echo $OUTPUT->header();
    $html->display();
    echo $OUTPUT->footer();
}

?>
