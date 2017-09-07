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
$table1 = null;
$table2 = null;
$table3 = null;
$allrow1 = null;
$allrow2 = null;
$allrow3 = null;
$lista_profesor = null;

// paramtros requeridos: ID del CURSO
$id = optional_param('id', 0, PARAM_INT);

// infraestructura
// infraestructura de la pagina MOODLE
$PAGE->set_context(context_system::instance());
$PAGE->set_url(
  '/blocks/mallacurricular/repo/repo_list.php');
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

//
// Consultar curso
//
$result = get_course( $id );

if( isset($result) ) {

  //
  // GENERALES
  //

  // Curso
  $allrow1[] = array( 'Curso', $result->fullname );

  // cantidad de Estudiantes
  $cantidad = 0;
  $sql = "" .
    "SELECT COUNT(u.id) as cantidad " .
    "FROM       {course} c " .
    "INNER JOIN {context} cx ON c.id = " . $id . " and c.id = cx.instanceid and cx.contextlevel = 50 " .
    "INNER JOIN {role_assignments} ra ON cx.id = ra.contextid AND ra.roleid = 5 " .
    "INNER JOIN {user} u ON ra.userid = u.id  ";
  $result = $DB->get_record_sql( $sql );
  if( isset($result) ) {
    $cantidad = $result->cantidad;
  }

  $allrow1[] = array( 'Estudiantes', $cantidad . " matriculado(s)" );

  // Lista de profesores
  $profesores = 0;
  $lista_profesor = array();

  $sql = "" .
    "SELECT CONCAT( u.firstname, ' ', u.lastname ) as nombre, u.email, u.id " .
    "FROM       {course}           c " .
    "INNER JOIN {context}          cx ON c.id = " . $id . " and c.id = cx.instanceid and cx.contextlevel = 50 " .
    "INNER JOIN {role_assignments} ra ON cx.id = ra.contextid AND ra.roleid = 3 " .
    "INNER JOIN {user}             u  ON ra.userid = u.id  ";
  $result = $DB->get_records_sql( $sql );

  if( isset($result) ) {
    foreach( $result as $item ) {
      $lista_profesor[$profesores] = $item->id;
      $profesores = $profesores + 1;
      $allrow1[] = array(
        get_string('dato4', 'block_mallacurricular') . ' ' . $profesores,
        $item->nombre . ' (' . $item->email . ') ('. $item->id . ')' );
    }
  }

  //
  // COMUNICACINES
  //
  // Lista de foros del curso
  $foros = 0;
  $sql = "" .
    "SELECT f.name, f.id " .
    "FROM   {forum} f " .
    "WHERE  f.course = " . $id . " ";
  $result = $DB->get_records_sql( $sql );

  if( isset($result) ) {
    foreach( $result as $item ) {

      //
      // Mensajes de estudiantres
      $sql2 = "" .
        "SELECT     COUNT( fp.id )      as cantidad " .
        "FROM       {forum_posts}       fp " .
        "INNER JOIN {forum_discussions} fd ON fd.course = " . $id . " and fd.id = fp.discussion " .
        "INNER JOIN {user}              u  ON fp.userId = u.id " .
        "INNER JOIN {role_assignments}  ra ON ra.userid = u.id and ra.roleid = 5 " .
        "WHERE fd.forum = " . $item->id;
      $result2 = $DB->get_record_sql( $sql2 );

      $mensajes_estudiantes = 0;
      if( isset($result2)) {
        $mensajes_estudiantes = $result2->cantidad;
      }

      //
      // Envios de profesor 1
      $mensajes_profesor1 = 0;

      if( isset($lista_profesor[0] )) {
        if( $lista_profesor[0] > 0 ) {
          $sql3 = "" .
            "SELECT     COUNT( fd.id )      as cantidad " .
            "FROM       {forum_discussions} fd " .
            "WHERE      fd.course = " . $id . " " .
            "AND        fd.userid = " . $lista_profesor[0] . " " .
            "AND        fd.forum  = " . $item->id;
          $result3 = $DB->get_record_sql( $sql3 );

          if( isset($result3)) {
            $mensajes_profesor1 = $result3->cantidad;
          }
        }
      }

      //
      // Envios de profesor 2
      $mensajes_profesor2 = 0;

      if( isset($lista_profesor[1] )) {
        if( $lista_profesor[1] > 0 ) {
          $sql4 = "" .
          "SELECT     COUNT( fd.id )      as cantidad " .
          "FROM       {forum_discussions} fd " .
          "WHERE      fd.course = " . $id . " " .
          "AND        fd.userid = " . $lista_profesor[1] . " " .
          "AND        fd.forum  = " . $item->id;
          $result4 = $DB->get_record_sql( $sql4 );

          if( isset($result4)) {
            $mensajes_profesor2 = $result4->cantidad;
          }
        }
      }

      //
      // Respuestas de profesor 1
      $respuestas_profesor1 = 0;

      if( isset($lista_profesor[0] )) {
        if( $lista_profesor[0] > 0 ) {
          $sql5 = "" .
            "SELECT     COUNT( fp.id )      as cantidad " .
            "FROM       {forum_posts}       fp " .
            "INNER JOIN {forum_discussions} fd ON  fd.course = " . $id . " " .
            "                                  AND fd.forum  = " . $item->id . " " .
            "                                  AND fd.id     = fp.discussion " .
            "WHERE                                 fp.userid = " . $lista_profesor[0] . " " .
            "                                  AND fp.parent > 0";
          $result5 = $DB->get_record_sql( $sql5 );

          if( isset($result5)) {
            $respuestas_profesor1 = $result5->cantidad;
          }
        }
      }

      $foros = $foros + 1;
      $allrow2[] = array(
        $foros . ". " . $item->name,
        $mensajes_estudiantes,
        $mensajes_profesor1,
        $mensajes_profesor2,
        $respuestas_profesor1 );
    }
  }

  $allrow3[] = array( 'Trabajo 1', '0', '10', '0', '0' );
  $allrow3[] = array( 'Foro consultas', '5', '3', '2', '3' );
  $allrow3[] = array( 'Foro 3', '2', '2', '3', '1' );
}

$table1 = new html_table();
$table1->head = array( 'GENERAL', 'Valor' );
$table1->data = $allrow1;

$table2 = new html_table();
$table2->head = array( 'FOROS', 'Mensajes Estudiantes', 'Envios Docente 1', 'Envios Docente 2', 'Respuestas Docente 1' );
$table2->data = $allrow2;

$table3 = new html_table();
$table3->head = array( 'ACTIVIDADES', 'Trabajos Enviados', 'Calificados Docente 1', 'Calificados Docente 2', 'Retroalimentados Docente 1' );
$table3->data = $allrow3;

// Imprimir pagina
echo $OUTPUT->header();
echo html_writer::table($table1);
echo html_writer::table($table2);
echo html_writer::table($table3);
echo $OUTPUT->footer();
?>
