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
$nivel = 4;
$id = optional_param('id', 0, PARAM_INT);
$padre = $nivel - 1;

// infraestructura
$PAGE->set_context(context_system::instance());
$PAGE->set_url(
  '/blocks/mallacurricular/pages/crud_list_nivel.php',
  array('nivel' => $nivel));
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
  $DB->delete_records("malla_nivel" . $nivel, array( 'id' => $id ) );
}

//
// Crear tabla de registros
//
$row = null;
$allrow = array();
$result = $DB->get_records_sql(
    "SELECT N4.id, CONCAT( N4.nombre, ' (', N4.codigo, ')' ) as nombre, N4.activo, " .
    "CONCAT( N3.nombre, ' (', N3.codigo, ')' ) as padre, " .
    "CONCAT( D1.nombre, ' (', D1.codigo, ')' ) as sede, " .
    "CONCAT( D2.nombre, ' (', D2.codigo, ')' ) as ciclo " .
    "FROM {malla_nivel4} N4 " .
    "LEFT JOIN {malla_dato1}  D1 ON N4.id_dato1  = D1.id " .
    "LEFT JOIN {malla_dato2}  D2 ON N4.id_dato2  = D2.id " .
    "LEFT JOIN {malla_nivel3} N3 ON N4.id_nivel3 = N3.id "
    , null );

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

  $row = null;
  $row = array( $item->id, $item->padre, $item->sede, $item->ciclo, $item->nombre, $item->activo, $link1 . ' | ' . $link2 );
  $allrow[] = $row;
}

$table = new html_table();
$table->head = array(
  'Id',
  get_string('nivel3','block_mallacurricular'),
  get_string('dato1','block_mallacurricular'),
  get_string('dato2','block_mallacurricular'),
  'Descripcion', 'Activo', 'Acciones' );
$table->data = $allrow;

// Imprimir pagina
echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();

?>
