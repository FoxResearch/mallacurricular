<?php

require_once('../../../config.php');

// inicializacion de variables
$settingsnode = null;
$editurl = null;
$editnode = null;
$html = null;
$toform = array();
$fromform = null;
$id = null;

global $DB, $OUTPUT, $PAGE;

// ID del registro a editar
/*
$nivel = optional_param('nivel', '1', PARAM_RAW);
$id = optional_param('id', '0', PARAM_RAW );
*/
require_once('search_view.php');


// infraestructura de la pagina MOODLE
$PAGE->set_context(context_system::instance());
$PAGE->set_url(
  '/blocks/mallacurricular/search/search_controller.php');
$PAGE->set_pagelayout('standard');
$PAGE->set_heading( get_string('search', 'block_mallacurricular') );

// NAVIGATION TOP
$settingsnode = $PAGE->settingsnav->add( get_string('search', 'block_mallacurricular') );
$editurl = new moodle_url(
  '/blocks/mallacurricular/search/search_controller.php' );
$editnode = $settingsnode->add('Inicio', $editurl);
$editnode->make_active();

// Seleccion de la vista
$html = new view_form();

// Manejo de casos posibles
$fromform = $html->get_data();

// Cancelled forms
if( $html->is_cancelled() ) {
    $url = new moodle_url(
      '/blocks/mallacurricular/block_mallacurricular.php' );
    redirect($url);
}

// We need to add code to appropriately act on and store the submitted data
// but for now we will just redirect back to the course main page.
else if ( $fromform != null ) {

    // print_object($fromform);
    // Actualizacion de registros
    if( isset($fromform->nivel1) ) {
      $fromform->nivel1 = trim($fromform->nivel1, ' ');
      if( strlen($fromform->nivel1) > 0 ) $toform['nivel1'] = $fromform->nivel1;
    }

    if( isset($fromform->nivel2) ) {
      $fromform->nivel2 = trim($fromform->nivel2, ' ');
      if( strlen($fromform->nivel2) > 0 ) $toform['nivel2'] = $fromform->nivel2;
    }

    if( isset($fromform->nivel3) ) {
      $fromform->nivel3 = trim($fromform->nivel3, ' ');
      if( strlen($fromform->nivel3) > 0 ) $toform['nivel3'] = $fromform->nivel3;
    }

    if( isset($fromform->nivel4) ) {
      $fromform->nivel4 = trim($fromform->nivel4, ' ');
      if( strlen($fromform->nivel4) > 0 ) $toform['nivel4'] = $fromform->nivel4;
    }

    if( isset($fromform->dato1) ) {
      $fromform->dato1 = trim($fromform->dato1, ' ');
      if( strlen($fromform->dato1 ) > 0 ) $toform['dato1']  = $fromform->dato1;
    }

    if( isset($fromform->dato2) ) {
      $fromform->dato2 = trim($fromform->dato2, ' ');
      if( strlen($fromform->dato2 ) > 0 ) $toform['dato2']  = $fromform->dato2;
    }

    // Redirige para mostrarle el resultado final al usuario
    $editurl = new moodle_url(
        '/blocks/mallacurricular/search/search_list.php',
        $toform );
    redirect( $editurl, 'Resultados de la busqueda' );
}

// form didn't validate or this is the first display
else {

  $toform['displayinfo'] = get_string('search', 'block_mallacurricular');

  // Enviar al formulario
  $html->set_data($toform);

  // Impresion de la pagina
  echo $OUTPUT->header();
  $html->display();
  echo $OUTPUT->footer();
}

?>
