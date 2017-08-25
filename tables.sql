
CREATE TABLE mdl_malla_nivel1 (
    id BIGINT(10) NOT NULL auto_increment,
    nombre VARCHAR(250),
    codigo VARCHAR(250),
    activo TINYINT(1) DEFAULT 1,
CONSTRAINT  PRIMARY KEY (id)
)
 ENGINE = InnoDB
 DEFAULT COLLATE = utf8mb4_unicode_ci ROW_FORMAT=Compressed
 COMMENT='Primer Nivel (CARRERA PROFESIONAL). Ejemplo: Carrera Profesional Tecnica de Administración Bancaria';

CREATE TABLE mdl_malla_nivel2 (
    id BIGINT(10) NOT NULL auto_increment,
    id_nivel1 BIGINT(20),
    nombre VARCHAR(250),
    codigo VARCHAR(250),
    activo TINYINT(1) DEFAULT 1,
CONSTRAINT  PRIMARY KEY (id)
)
 ENGINE = InnoDB
 DEFAULT COLLATE = utf8mb4_unicode_ci ROW_FORMAT=Compressed
 COMMENT='Segundo Nivel (PLAN PROFESIONAL). Ejemplo: Plan Curricular PL2017-885';

CREATE TABLE mdl_malla_nivel3 (
    id BIGINT(10) NOT NULL auto_increment,
    id_nivel2 BIGINT(10),
    nombre VARCHAR(250) NULL,
    codigo VARCHAR(250) NULL,
    activo TINYINT(1) NULL DEFAULT 1,
CONSTRAINT  PRIMARY KEY (id)
)
 ENGINE = InnoDB
 DEFAULT COLLATE = utf8mb4_unicode_ci ROW_FORMAT=Compressed
 COMMENT='Tercer Nivel (CURSO DEL PLAN). Ejemplo: Finanzas';

 CREATE TABLE mdl_malla_nivel4 (
     id BIGINT(10) NOT NULL auto_increment,
     id_nivel3 BIGINT(10),
     nombre VARCHAR(250) NULL,
     codigo VARCHAR(250) NULL,
     activo TINYINT(1) NULL DEFAULT 1,
     id_dato1 BIGINT(10) NULL,
     id_dato2 BIGINT(10) NULL,
     id_dato3 BIGINT(10) NULL,
 CONSTRAINT  PRIMARY KEY (id)
 )
  ENGINE = InnoDB
  DEFAULT COLLATE = utf8mb4_unicode_ci ROW_FORMAT=Compressed
  COMMENT='Cuarto Nivel (CURSO DICTADO). Ejemplo: Finanzas dictado el 28/08 en la Sede Los Olivos';

CREATE TABLE mdl_malla_dato1 (
    id BIGINT(10) NOT NULL auto_increment,
    nombre LONGTEXT COLLATE utf8mb4_unicode_ci,
    codigo LONGTEXT COLLATE utf8mb4_unicode_ci,
    activo TINYINT(1) DEFAULT 1,
CONSTRAINT  PRIMARY KEY (id)
)
 ENGINE = InnoDB
 DEFAULT COLLATE = utf8mb4_unicode_ci ROW_FORMAT=Compressed
 COMMENT='SEDE donde se imparte el CURSO DICTADO';

 CREATE TABLE mdl_malla_dato1 (
     id BIGINT(10) NOT NULL auto_increment,
     nombre LONGTEXT COLLATE utf8mb4_unicode_ci,
     codigo LONGTEXT COLLATE utf8mb4_unicode_ci,
     activo TINYINT(1) DEFAULT 1,
 CONSTRAINT  PRIMARY KEY (id)
 )
  ENGINE = InnoDB
  DEFAULT COLLATE = utf8mb4_unicode_ci ROW_FORMAT=Compressed
  COMMENT='CICLO donde se imparte el CURSO DICTADO';
