
ALTER TABLE `usuario_convocatoria` ADD `observaciones` TEXT NULL AFTER `doc_estado`;

TRUNCATE TABLE `menu`;

INSERT INTO `menu` (`id_menu`, `id_padre`, `href`, `descripcion`, `estado`, `es_padre`, `rol`, `prioridad`) VALUES
(1, 0, 'rtc/administracion', 'Administrar', 1, 1, 1, 1),
(3, 1, 'administrador/usuarios', 'Usuarios', 0, 0, 1, 1),
(4, 0, 'transversal/cambio_pass', 'Cambiar Contraseña', 1, 1, 1, 80),
(10, 0, 'ciudadano/principal', 'Perfil', 1, 1, 3, 1),
(23, 1, 'administrador/convocatorias', 'Convocatorias', 1, 0, 1, 1),
(24, 0, 'ciudadano/convocatorias', 'Convocatorias', 1, 1, 3, 1),
(25, 1, 'administrador/convocatorias/reporte', 'Reporte', 1, 0, 1, 1),
(26, 0, 'transversal/cambio_pass', 'Cambiar Contraseña', 1, 1, 3, 80),
(27, 0, 'coordinador/principal', 'Validar Documentos', 1, 1, 2, 1);



--NUEVA TABLA

CREATE TABLE IF NOT EXISTS `coordinadores` (
  `id_coordinador` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `estado` char(2) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_coordinador`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `coordinadores`
--

INSERT INTO `coordinadores` (`id_coordinador`, `nombres`, `apellidos`, `email`, `id_ciudad`, `estado`) VALUES
(1, 'JAVIER ANTONIO', 'MONTEALEGRE ORTIZ', 'jamontealegreo@dane.gov.co', 8001, 'AC'),
(2, 'ROBERTO ANDRES ', 'FERNANDEZ FERNANDEZ', 'rafernandezf@dane.gov.co', 13001, 'AC'),
(3, 'LOLY LUZ', 'AMAYA FERNANDEZ', 'llamayaf@dane.gov.co', 44001, 'AC'),
(4, 'ALTICA MARIA', 'ACOSTA MENDEZ', 'amacostam@dane.gov.co', 88001, 'AC'),
(5, 'ANTONIO JOSE', 'MIRANDA GALLARDO', 'ajmirandag@dane.gov.co', 47001, 'AC'),
(6, 'OSCAR DE JESUS', 'DAZA LEMUS', 'ojdazal@dane.gov.co', 20001, 'AC'),
(7, 'SAAC ELI', 'RUIZ ALVAREZ', 'seruiza@dane.gov.co', 70001, 'AC'),
(8, 'GABRIEL FELIPE', 'HERRAN FLORES', 'gfherranf@dane.gov.co', 11001, 'AC'),
(9, 'DANNY JASMIN', 'BAHOS MELO', 'djbahosm@dane.gov.co', 18001, 'AC'),
(10, 'DIANA MARCELA', 'TORRES CARDOZO', 'dmtorresc@dane.gov.co', 41001, 'AC'),
(11, 'AURA LILIANA', 'ANGEL HOLGUIN', 'alangelh@dane.gov.co', 15001, 'AC'),
(12, 'DILSA NOALBI', 'SANCHEZ CAGUA', 'dnsanchezc@dane.gov.co', 95001, 'AC'),
(13, 'JIMMY BERNAL', 'SAENZ MORENO', 'jbsaenzm@dane.gov.co', 94001, 'AC'),
(14, 'WILMA CONSUELO', 'GOMEZ VELANDIA', 'vcgomezv@dane.gov.co', 68001, 'AC'),
(15, 'ANA YOLANDA', 'DUARTE ISCALA', 'ayduartei@dane.gov.co', 54001, 'AC'),
(16, 'CARMEN ROSA', 'BENITEZ RAYO', 'crbenitezr@dane.gov.co', 76001, 'AC'),
(17, 'JAMES', 'LOZANO RODRIGUEZ', 'jlozanor@dane.gov.co', 19001, 'AC'),
(18, 'ROBERT FELIPE', 'BURBANO GOMEZ', 'rfburbanog@dane.gov.co', 52001, 'AC'),
(19, 'INES RUBIRA', 'CANAMEJOY ESCOBAR', 'ircanamejoye@dane.gov.co', 86001, 'AC'),
(20, 'JHOM HAROLD', 'GARCIA ALZATE', 'jhgarciaa@dane.gov.co', 17001, 'AC'),
(21, 'JOSE MARIO', 'MONROY MATOMA', 'jmmonroym@dane.gov.co', 73001, 'AC'),
(22, 'PEDRO PABLO', 'HERNANDEZ HURTADO', 'pphernandezh@dane.gov.co', 66001, 'AC'),
(23, 'MARIA CATALINA', 'FRANCO ROA', 'mcfrancor@dane.gov.co', 63001, 'AC'),
(24, 'JOSE NELSON', 'ALZATE RIOS', 'jnalzater@dane.gov.co', 5001, 'AC'),
(25, 'ALIDIS ESTHER', 'HUMANEZ ALVAREZ', 'aehumaneza@dane.gov.co', 23001, 'AC'),
(26, 'MARIA ROSMIRA', 'MORENO ROBLEDO', 'mrmorenor@dane.gov.co', 27001, 'AC');
