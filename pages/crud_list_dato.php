<?php

require_once('../../../config.php');
global $DB, $OUTPUT, $PAGE, $COURSE;

// inicializacion de variables
$settingsnode = null;
$editurl = null;
$editnode = null;
$table = null;
$result = null;
$id = null;

// paramtros requeridos
$dato = optional_param('dato', 0, PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$padre = $dato - 1;

// infraestructura
$PAGE->set_context(context_system::instance());
$PAGE->set_url(
  '/blocks/mallacurricular/pages/crud_list_dato.php',
  array('nivel' => $dato));
// $PAGE->set_pagelayout('standard');
$PAGE->set_title( get_string('titulo', 'block_mallacurricular') );
$PAGE->set_heading( get_string('titulo', 'block_mallacurricular') );

// NAVIGATION TOP
$settingsnode = $PAGE->settingsnav->add(get_string('titulo', 'block_mallacurricular'));
$editurl = new moodle_url(
  '/blocks/mallacurricular/admin_index.php',
  array('id' => 0) );
$editnode = $settingsnode->add('Inicio', $editurl);
$editnode->make_active();

//
// Eliminar registro solicitado
//
if( $id != null ) {
  $DB->delete_records("malla_dato" . $dato, array( 'id' => $id ) );
}

//
// Crear tabla de registros
//
$row = null;
$allrow = array();
$result = $DB->get_records('malla_dato' . $dato , null );

foreach( $result as $item ) {

  $url1 = null;
  $url2 = null;
  $link0 = null;
  $link1 = null;
  $link2 = null;

  $url1 = new moodle_url(
      '/blocks/mallacurricular/pages/crud_controller_dato.php',
      array( 'id' => $item->id, 'dato' => $dato )
  );

  $url2 = new moodle_url(
      '/blocks/mallacurricular/pages/crud_list_dato.php',
      array( 'id'=> $item->id, 'dato' => $dato )
  );

  $link1 = html_writer::link($url1, 'Editar');
  $link2 = html_writer::link($url2, 'Borrar');


  $row = null;
  $row = array( $item->id, $item->nombre . ' (' . $item->codigo . ')', $item->activo, $link1 . ' | ' . $link2 );
  $allrow[] = $row;
}

$table = new html_table();
$table->head = array( 'Id', 'Nombre', 'Activo', 'Acciones' );
$table->data = $allrow;

// Imprimir pagina
echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();

?>
