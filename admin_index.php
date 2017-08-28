<?php

//
// PAGINA INICIAL DE MANTENIMIENTO
//

require_once('../../config.php');
global $DB, $OUTPUT, $PAGE, $COURSE;

// inicializacion de variables
$settingsnode = null;
$editurl = null;
$editnode = null;
$table = null;

// paramtros requeridos

// infraestructura
$PAGE->set_context(context_system::instance());
$PAGE->set_url(
  '/blocks/mallacurricular/admin_index.php',
  array('id' => 0));
// $PAGE->set_pagelayout('standard');
$PAGE->set_title( get_string("titulo", 'block_mallacurricular') );
$PAGE->set_heading( get_string("titulo", 'block_mallacurricular') );

// NAVIGATION TOP
$settingsnode = $PAGE->settingsnav->add(get_string('titulo', 'block_mallacurricular'));
$editurl = new moodle_url(
  '/blocks/mallacurricular/admin_index.php',
  array('id' => 0));
$editnode = $settingsnode->add('Inicio', $editurl);
$editnode->make_active();

//
// Crear tabla de mantenimiento
//
$row = null;
$allrow = array();

for( $nivel = 1; $nivel < 5; $nivel = $nivel + 1) {

  $url1 = null;
  $url2 = null;
  $link0 = null;
  $link1 = null;
  $link2 = null;

  $url1 = new moodle_url(
      '/blocks/mallacurricular/pages/crud_controller_nivel.php',
      array( 'nivel' => $nivel )
  );

  if( $nivel < 4 ) {
    $url2 = new moodle_url(
        '/blocks/mallacurricular/pages/crud_list_nivel.php',
        array( 'nivel' => $nivel )
    );
  }
  else {
    $url2 = new moodle_url(
        '/blocks/mallacurricular/pages/crud_list_nivel4.php',
        array( 'nivel' => $nivel )
    );
  }

  $link0 = html_writer::start_span() . get_string("nivel" . $nivel, 'block_mallacurricular') . html_writer::start_span();
  $link1 = html_writer::link($url1, 'Crear');
  $link2 = html_writer::link($url2, 'Listar');

  $row = null;
  $row = array( $link0, $link1, $link2 );

  $allrow[] = $row;
}

for( $nivel = 1; $nivel < 3; $nivel = $nivel + 1) {

  $url1 = null;
  $url2 = null;
  $link0 = null;
  $link1 = null;
  $link2 = null;

  $url1 = new moodle_url(
      '/blocks/mallacurricular/pages/crud_controller_dato.php',
      array( 'dato' => $nivel )
  );

  $url2 = new moodle_url(
      '/blocks/mallacurricular/pages/crud_list_dato.php',
      array( 'dato' => $nivel )
  );

  $link0 = html_writer::start_span() . get_string("dato" . $nivel, 'block_mallacurricular') . html_writer::start_span();
  $link1 = html_writer::link($url1, 'Crear');
  $link2 = html_writer::link($url2, 'Listar');

  $row = null;
  $row = array( $link0, $link1, $link2 );

  $allrow[] = $row;
}

$table = new html_table();
$table->head = array('Elemento', 'Crear', 'Listar');
$table->data = $allrow;

// Imprimir pagina
echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();

?>
