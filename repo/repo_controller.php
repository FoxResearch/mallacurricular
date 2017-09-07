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
$id = optional_param('id', '0', PARAM_RAW );

require_once('repo_view.php');

// infraestructura de la pagina MOODLE
$PAGE->set_context(context_system::instance());
$PAGE->set_url(
  '/blocks/mallacurricular/repo/repo_controller.php');
$PAGE->set_pagelayout('standard');
$PAGE->set_title( get_string("reporte", 'block_mallacurricular') );
$PAGE->set_heading( get_string('reporte', 'block_mallacurricular') );

// NAVIGATION TOP
$settingsnode = $PAGE->settingsnav->add( get_string('reporte', 'block_mallacurricular') );
$editurl = new moodle_url(
  '/blocks/mallacurricular/repo/repo_controller.php',
  array('id' => 0) );
$editnode = $settingsnode->add( 'Inicio', $editurl );
$editnode->make_active();

// Seleccion de la vista
$html = new view_form();

// Manejo de casos posibles
$fromform = $html->get_data();

// Cancelled forms
if( $html->is_cancelled() ) {
    $courseurl = new moodle_url(
      '/blocks/mallacurricular/admin_index.php');
    redirect($courseurl);
}

// We need to add code to appropriately act on and store the submitted data
// but for now we will just redirect back to the course main page.
else if ( $fromform != null ) {

    // Redirige para mostrarle el resultado final al usuario
    $editurl = new moodle_url(
        '/blocks/mallacurricular/repo/repo_list.php',
        array('id' => $id ));
    redirect($editurl, $message);
}

// form didn't validate or this is the first display
else {

    $toform['displayinfo'] = get_string('reporte', 'block_mallacurricular');

    // Enviar al formulario
    $html->set_data($toform);

    // Impresion de la pagina
    echo $OUTPUT->header();
    $html->display();
    echo $OUTPUT->footer();
}

?>
