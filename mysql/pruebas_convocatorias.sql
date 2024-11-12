CREATE TABLE IF NOT EXISTS `postulante` (
    `id_postulante` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre_postulante` VARCHAR(100) NOT NULL,
    `ci_postulante` VARCHAR(15) NOT NULL,
    `telefono_postulante` VARCHAR(50) NOT NULL,
    `correo_postulante` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_postulante`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `convocatoria` (
    `id_convocatoria` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre_convocatoria` VARCHAR(150) NOT NULL,
    `mes_convocatoria` VARCHAR(20) NOT NULL,
    `gestion_convocatoria` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_convocatoria`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `preguntas_convocatoria` (
    `id_preguntas` INT(11) NOT NULL AUTO_INCREMENT,
    `enunciado_preguntas` VARCHAR(150) NOT NULL,
    `calificacion_preguntas` INT(11) NOT NULL,
    `id_convocatoria` INT NOT NULL,
    FOREIGN KEY (id_convocatoria) REFERENCES convocatoria (id_convocatoria),
    PRIMARY KEY (`id_preguntas`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `asignacion_convocatoria` (
    `id_asignacion_convocatoria` INT(11) NOT NULL AUTO_INCREMENT,
    `id_convocatoria` INT NOT NULL,
    `id_postulante` INT NOT NULL,
    FOREIGN KEY (id_convocatoria) REFERENCES convocatoria (id_convocatoria),
    FOREIGN KEY (id_postulante) REFERENCES postulante (id_postulante),
    PRIMARY KEY (`id_asignacion_convocatoria`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `respuesta_convocatoria` (
    `id_respuesta_convocatoria` INT(11) NOT NULL AUTO_INCREMENT,
    `calificacion_respuesta` INT(11) NOT NULL,
    `id_asignacion_convocatoria` INT NOT NULL,
    FOREIGN KEY (id_asignacion_convocatoria) REFERENCES asignacion_convocatoria (id_asignacion_convocatoria),
    PRIMARY KEY (`id_respuesta_convocatoria`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `files` (
    `id_file` INT(11) NOT NULL AUTO_INCREMENT,
    `id_trabajador` INT(11) NOT NULL,
    `tipo` VARCHAR(50) NOT NULL,
    `detalle` VARCHAR(50) NOT NULL,
    `fecha_creacion` DATETIME NOT NULL,
    `fecha_inicio` DATE,
    `fecha_fin` DATE,
    FOREIGN KEY (id_trabajador) REFERENCES trabajador (id_trabajador),
    PRIMARY KEY (`id_file`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `marcaciones_zkteco` (
    `id_marcaciones` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` VARCHAR(50),
    `timestamp` DATETIME,
    `status` INT(11),
    `punch` INT(11),
    `device_name` VARCHAR(50),
    `origin` VARCHAR(30),
    PRIMARY KEY (`id_marcaciones`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;



CREATE TABLE IF NOT EXISTS `partidas_detalle` (
    `id_partida_detalle` INT(11) NOT NULL AUTO_INCREMENT,
    `concepto_partida` VARCHAR(100),
    `tipo_detalle_partida` VARCHAR(100),
    `id_partida` INT,
    PRIMARY KEY (`id_partida_detalle`),
    FOREIGN KEY (`id_partida`) REFERENCES `partidas` (`id_partida`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `partidas` (
  `id_partida` int(11) NOT NULL,
  `codigo_partida` varchar(6) NOT NULL,
  `nombre_partida` text NOT NULL,
  `tipo_partida` varchar(200) NOT NULL,
  `estado_partida` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `conf_asistencia` (
    `id_conf_asistencia` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre_asistencia` VARCHAR(50),
    `inicio_mañana` TIME NULL,
    `fin_mañana` TIME NULL,
    `inicio_tarde` TIME NULL,
    `fin_tarde` TIME NULL,
    `estado` VARCHAR(30),
    PRIMARY KEY (`id_conf_asistencia`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;