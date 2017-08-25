<?php
$nivel = 1;
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
$id = optional_param('id', 0, PARAM_INT);

// infraestructura
$PAGE->set_context(context_system::instance());
$PAGE->set_url(
  '/blocks/mallacurricular/pages/crud_list_nivel' . $nivel . '.php',
  array('id' => 0));
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
  $DB->delete_records('malla_nivel' . $nivel, array( 'id' => $id ) );
}

//
// Crear tabla de registros
//
$row = null;
$allrow = array();
$result = $DB->get_records('malla_nivel' . $nivel , null );

foreach( $result as $item ) {

  $url1 = null;
  $url2 = null;
  $link0 = null;
  $link1 = null;
  $link2 = null;

  $url1 = new moodle_url(
      '/blocks/mallacurricular/pages/crud_controller_nivel.php',
      array( 'id' => $item->id, 'nivel' => $nivel )
  );

  $url2 = new moodle_url(
      '/blocks/mallacurricular/pages/crud_list_nivel.php',
      array( 'id'=> $item->id, 'nivel' => $nivel )
  );

  $link1 = html_writer::link($url1, 'Editar');
  $link2 = html_writer::link($url2, 'Borrar');

  $item->padre = "por completar";

  $row = null;
  $row = array( $item->id, $item->padre, $item->nombre . ' (' . $item->codigo . ')', $item->activo, $link1 . ' | ' . $link2 );
  $allrow[] = $row;
}

$table = new html_table();
$table->head = array( 'Id', 'Raiz', 'Nombre', 'Activo', 'Acciones' );
$table->data = $allrow;

// Imprimir pagina
echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();

?>
