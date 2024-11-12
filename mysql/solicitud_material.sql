

CREATE TABLE IF NOT EXISTS `solicitud_material` (
  `id_solicitud_material` int(11) NOT NULL AUTO_INCREMENT,
  `nro_solicitud_material` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `programa_solicitud_material` varchar(2) NOT NULL,
  `actividad_solicitud_material` varchar(2) NOT NULL,
  `oficina_solicitante` varchar(100) NOT NULL,
  `item_solicitante` int(3) NOT NULL,
  `nombre_solicitante` varchar(200) NOT NULL,
  `justificativo` text NOT NULL,
  `autorizado_por` varchar(200) NOT NULL,
  `visto_bueno` varchar(200) NOT NULL,
  `gerente_area` varchar(200) NOT NULL,
  `observacion` text,
  `existencia_material` char(2) NOT NULL,
  `fecha_despacho` date DEFAULT NULL,
  `fecha_registro_adquisiciones` date DEFAULT NULL,
  `estado_solicitud_material` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_solicitud_material`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;
--
ALTER TABLE `solicitud_material`
  ADD CONSTRAINT `solicitud_material_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);




CREATE TABLE IF NOT EXISTS `solicitud_servicio` (
  `id_solicitud_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nro_solicitud_servicio` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `programa_solicitud_servicio` varchar(2) NOT NULL,
  `actividad_solicitud_servicio` varchar(2) NOT NULL,
  `oficina_solicitante` varchar(100) NOT NULL,
  `item_solicitante` int(3) NOT NULL,
  `nombre_solicitante` varchar(200) NOT NULL,
  `justificativo` text NOT NULL,
  `autorizado_por` varchar(200) NOT NULL,
  `visto_bueno` varchar(200) NOT NULL,
  `gerente_area` varchar(200) NOT NULL,
  `observacion` text,
  `fecha_registro_adquisiciones` date DEFAULT NULL,
  `estado_solicitud_servicio` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_solicitud_servicio`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

ALTER TABLE `solicitud_servicio`
  ADD CONSTRAINT `solicitud_servicio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

  
CREATE TABLE IF NOT EXISTS `detalle_servicio` (
  `id_detalle_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  `unidad_medida` varchar(50) NOT NULL,
  `cantidad_solicitada` float(9,2) NOT NULL,
  `precio_unitario` float(9,2) NOT NULL,
  `id_solicitud_servicio` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle_servicio`),
  KEY `id_solicitud_servicio` (`id_solicitud_servicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;






CREATE TABLE IF NOT EXISTS `solicitud_activo` (
  `id_solicitud_activo` int(11) NOT NULL AUTO_INCREMENT,
  `nro_solicitud_activo` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `programa_solicitud_activo` varchar(2) NOT NULL,
  `actividad_solicitud_activo` varchar(2) NOT NULL,
  `oficina_solicitante` varchar(100) NOT NULL,
  `item_solicitante` int(3) NOT NULL,
  `nombre_solicitante` varchar(200) NOT NULL,
  `justificativo` text NOT NULL,
  `autorizado_por` varchar(200) NOT NULL,
  `visto_bueno` varchar(200) NOT NULL,
  `gerente_area` varchar(200) NOT NULL,
  `observacion` text,
  `existencia_activo` char(2) NOT NULL,
  `fecha_despacho` date DEFAULT NULL,
  `fecha_registro_adquisiciones` date DEFAULT NULL,
  `estado_solicitud_activo` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_solicitud_activo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;
--
ALTER TABLE `solicitud_activo`
  ADD CONSTRAINT `solicitud_activo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

CREATE TABLE IF NOT EXISTS `detalle_activo` (
  `id_detalle_activo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  `unidad_medida` varchar(50) NOT NULL,
  `cantidad_solicitada` float(9,2) NOT NULL,
  `cantidad_despachada` float(9,2) NOT NULL,
  `precio_unitario` float(9,2) NOT NULL,
  `id_solicitud_activo` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle_activo`),
  KEY `id_solicitud_activo` (`id_solicitud_activo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

CREATE TABLE IF NOT EXISTS `activo` (
  `id_activo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `unidad_medida` varchar(50) NOT NULL,
  `cantidad` int(5) NOT NULL,
  PRIMARY KEY (`id_activo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1802 ;