<?php

require_once('../../../config.php');
global $DB, $OUTPUT, $PAGE, $COURSE;

// inicializacion de variables
$settingsnode = null;
$editurl  = null;
$editnode = null;
$table    = null;
$result   = null;
$id       = null;

// paramtros requeridos
/*
$nivel = optional_param('nivel', 0, PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$padre = $nivel - 1;
*/
$sql    = null;
$nivel1 = null;
$nivel2 = null;
$nivel3 = null;
$nivel4 = null;
$dato1  = null;
$dato2  = null;
$nivel1 = optional_param('nivel1', '', PARAM_RAW);
$nivel2 = optional_param('nivel2', '', PARAM_RAW);
$nivel3 = optional_param('nivel3', '', PARAM_RAW);
$nivel4 = optional_param('nivel4', '', PARAM_RAW);
$dato1  = optional_param('dato1' , '', PARAM_RAW);
$dato2  = optional_param('dato2' , '', PARAM_RAW);

// infraestructura
$PAGE->set_context( context_system::instance() );
$PAGE->set_url    ( '/blocks/mallacurricular/search/search_list.php', null );
$PAGE->set_pagelayout('standard');
$PAGE->set_title  ( get_string('search', 'block_mallacurricular') );
$PAGE->set_heading( get_string('search', 'block_mallacurricular') );

// NAVIGATION TOP
$settingsnode = $PAGE->settingsnav->add(get_string('search', 'block_mallacurricular'));
$editurl  = new moodle_url(
  '/blocks/mallacurricular/search/search_controller.php', null );
$editnode = $settingsnode->add('Inicio', $editurl);
$editnode->make_active();

//
// Crear tabla de registros
//
$row    = null;
$allrow = array();

$sql2 = "" .
"SELECT  " .
"CONCAT( N4.nombre, ' (', N4.codigo, ')' ) as nivel4, " .
"CONCAT( N3.nombre, ' (', N3.codigo, ')' ) as nivel3, " .
"CONCAT( N2.nombre, ' (', N2.codigo, ')' ) as nivel2, " .
"CONCAT( N1.nombre, ' (', N1.codigo, ')' ) as nivel1, " .
"CONCAT( D1.nombre, ' (', D1.codigo, ')' ) as dato1, " .
"CONCAT( D2.nombre, ' (', D2.codigo, ')' ) as dato2, " .
"N4.id_dato3 " .
"FROM {malla_nivel4}      N4      " .
"LEFT JOIN {malla_nivel3} N3 ON N4.id_nivel3 = N3.id " .
"LEFT JOIN {malla_nivel2} N2 ON N3.id_nivel2 = N2.id " .
"LEFT JOIN {malla_nivel1} N1 ON N2.id_nivel1 = N1.id " .
"LEFT JOIN {malla_dato1}  D1 ON N4.id_dato1  = D1.id " .
"LEFT JOIN {malla_dato2}  D2 ON N4.id_dato2  = D2.id " .
"WHERE " .
"    ((N4.nombre LIKE '%" . $nivel4 . "%') OR (N4.codigo LIKE '%" . $nivel4 . "%')) " .
"AND ((N3.nombre LIKE '%" . $nivel3 . "%') OR (N3.codigo LIKE '%" . $nivel3 . "%')) " .
"AND ((N2.nombre LIKE '%" . $nivel2 . "%') OR (N2.codigo LIKE '%" . $nivel2 . "%')) " .
"AND ((N1.nombre LIKE '%" . $nivel1 . "%') OR (N1.codigo LIKE '%" . $nivel1 . "%')) ";

if( strlen($dato1) > 0 )
  $sql2 = $sql2 . "AND ((D1.nombre LIKE '%" . $dato1 . "%') OR (D1.codigo LIKE '%" . $dato1 . "%')) ";
if( strlen($dato2) > 0 )
  $sql2 = $sql2 . "AND ((D2.nombre LIKE '%" . $dato2 . "%') OR (D2.codigo LIKE '%" . $dato2 . "%')) ";

$sql2 = $sql2 . "ORDER BY " .
"CONCAT( N1.nombre, ' (', N1.codigo, ')' ), " .
"CONCAT( N2.nombre, ' (', N2.codigo, ')' ), " .
"CONCAT( N3.nombre, ' (', N3.codigo, ')' ), " .
"CONCAT( N4.nombre, ' (', N4.codigo, ')' )  ";

$result = $DB->get_records_sql( $sql2 , null );

foreach( $result as $item ) {

  if( isset($item->id_dato3) ) {
    $url1 = new moodle_url(
        '/course/view.php',
        array( 'id' => $item->id_dato3 )
    );
    $link1 = html_writer::link($url1, $item->nivel4 );
  }
  else {
    $link1 = $item->nivel4;
  }

  $row = null;
  $row = array( $item->nivel1, $item->nivel2, $item->nivel3, $link1, $item->dato1, $item->dato2 );
  $allrow[] = $row;
}

$table = new html_table();
$table->head = array(
  get_string('nivel1', 'block_mallacurricular'),
  get_string('nivel2', 'block_mallacurricular'),
  get_string('nivel3', 'block_mallacurricular'),
  get_string('nivel4', 'block_mallacurricular'),
  get_string('dato1' , 'block_mallacurricular'),
  get_string('dato2' , 'block_mallacurricular')
);
$table->data = $allrow;

// Imprimir pagina
echo $OUTPUT->header();
echo html_writer::table($table);
// echo print_object($result);
echo $OUTPUT->footer();

?>
