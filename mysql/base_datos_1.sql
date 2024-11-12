create table if not exists trabajador(
  id_trabajador int(11) not null auto_increment primary key,
  ci varchar(15) not null,
  exp varchar(20) not null,
  nua varchar(12) not null,
  nombres varchar(150) not null,
  apellido_paterno varchar(50) not null,
  apellido_materno varchar(50) not null,
  direccion varchar(200) not null,
  sexo varchar(15) not null,
  nacionalidad varchar(50) not null,
  fecha_nacimiento date not null,
  antiguedad_anios int(2) not null,
  antiguedad_meses int(2) not null,
  antiguedad_dias int(2) not null,
  estado_trabajador varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists cargo(
	id_cargo int(11) not null auto_increment primary key,
	item varchar(10) not null,
	nivel int(2) not null,
	descripcion varchar(200) not null,
	salario_mensual float(9,2) not null,
	estado_cargo varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists asignacion_cargo(
	id_asignacion_cargo int(11) not null auto_increment primary key,
	fecha_ingreso date not null,
	fecha_salida date not null,
	item varchar(10) not null,
	salario float(9,2) not null,
	cargo varchar(200) not null,
	estado_asignacion varchar(20) not null,
	aportante_afp int(1) not null,
	sindicato int(1) not null,
	socio_fe int(1) not null,
	id_cargo int(11) not null,
	id_trabajador int(11) not null,
	foreign key(id_cargo) references cargo(id_cargo),
	foreign key(id_trabajador) references trabajador(id_trabajador)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists bono_antiguedad(
	id_bono_antiguedad int not null auto_increment primary key,
	anios_arrastre int(2) not null,
	meses_arrastre int(2) not null,
	dias_arrastre int(2) not null,
	fecha_ingreso date not null,
	fecha_calculo date not null,
	anios int(2) not null,
	meses int(2) not null,
	dias int(2) not null,
	gestion int(11) not null,
	mes int(2) not null,
	porcentaje float(9,2) not null,
	monto float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table if not exists reintegro_bono_antiguedad(
	id_reintegro_bono_antiguedad int(11) not null auto_increment primary key,
	gestion_reintegro int(11) not null,
	mes_reintegro int(2) not null,
	porcentaje_reintegro float(9,2) not null,
	monto_reintegro float(9,2) not null,
	id_bono_antiguedad int(11) not null,
	foreign key(id_bono_antiguedad) references bono_antiguedad(id_bono_antiguedad)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists conf_bono_antiguedad(
	id_conf_bono_antiguedad int(11) not null auto_increment primary key,
	anio_i int(2) not null,
	anio_f int(2) not null,
	porcentaje float(9,2) not null,
	estado_bono varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists conf_horas_extra(
	id_conf_horas_extra int(11) not null auto_increment primary key,
	tipo_he varchar(20) not null,
	factor_calculo float(9,2) not null,
	estado varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists horas_extra(
	id_horas_extra int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	tipo_he varchar(20) not null,
	factor_calculo float(9,2) not null,
	cantidad int(11) not null,
	monto float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists conf_aportes(
	id_conf_aporte int(11) not null auto_increment primary key,
	tipo_aporte varchar(100) not null,
	rango_inicial float(9,2) not null,
	rango_final float(9,2) not null,
	porc_aporte float(9,2) not null,
	estado varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists aporte_laboral(
	id_aporte_laboral int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	tipo_aporte varchar(100) not null,
	porc_aporte float(9,2) not null,
	monto_aporte float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists reintegro_aporte_laboral(
	id_aporte_laboral_reintegro int(11) not null auto_increment primary key,
	mes_reintegro int(2) not null,
	gestion_reintegro int(11) not null,
	tipo_aporte_reintegro varchar(100) not null,
	porc_aporte_reintegro float(9,2) not null,
	monto_aporte_reintegro float(9,2) not null,
	id_total_ganado_reintegro int(11) not null,
	foreign key(id_total_ganado_reintegro) references reintegro_total_ganado(id_total_ganado_reintegro)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists suplencia(
	id_suplencia int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	fecha_inicio date not null,
	fecha_fin date not null,
	total_dias int(3) not null,
	cargo_suplencia varchar(200) not null,
	salario_mensual float(9,2) not null,
	monto float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists nombre_planilla(
	id_nombre_planilla int(11)  not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	nombre_planilla varchar(200) not null,
	fecha_creacion date not null,
	estado varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists planilla(
	id_planilla int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	item varchar(10) not null,
	ci varchar(15) not null,
	nua varchar(12) not null,
	nombres varchar(150) not null,
	apellidos varchar(150) not null,
	cargo varchar(200) not null,
	fecha_ingreso date not null,
	dias_pagado int(2) not null,
	haber_mensual float(9,2) not null,
	haber_basico float(9,2) not null,
	bono_antiguedad float(9,2) not null,
	horas_extra float(9,2) not null,
	suplencia float(9,2) not null,
	total_ganado float(9,2) not null,
	sindicato float(9,2) not null,
	categoria_individual float(9,2) not null,
	prima_riesgo_comun float(9,2) not null,
	comision_ente float(9,2) not null,
	total_aporte_solidario float(9,2) not null,
	desc_rciva float(9,2) not null,
	otros_descuentos float(9,2) not null,
	fondo_social float(9,2) not null,
	fondo_empleados float(9,2) not null,
	entidades_financieras float(9,2) not null,
	total_descuentos float(9,2) not null,
	liquido_pagable float(9,2) not null,
	estado_planilla varchar(20) not null,
	fecha_aprobado date not null,
	id_nombre_planilla int(11) not null,
	foreign key(id_nombre_planilla) references nombre_planilla(id_nombre_planilla)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists reintegro_planilla(
	id_planilla_reintegro int(11) not null auto_increment primary key,
	mes_reintegro int(2) not null,
	gestion_reintegro int(11) not null,
	item_reintegro varchar(10) not null,
	ci_reintegro varchar(15) not null,
	nua_reintegro varchar(12) not null,
	nombres_reintegro varchar(150) not null,
	apellidos_reintegro varchar(150) not null,
	cargo_reintegro varchar(200) not null,
	fecha_ingreso_reintegro date not null,
	dias_pagado_reintegro int(2) not null,
	haber_mensual_reintegro float(9,2) not null,
	haber_basico_reintegro float(9,2) not null,
	bono_antiguedad_reintegro float(9,2) not null,
	horas_extra_reintegro float(9,2) not null,
	suplencia_reintegro float(9,2) not null,
	total_ganado_reintegro float(9,2) not null,
	sindicato_reintegro float(9,2) not null,
	categoria_individual_reintegro float(9,2) not null,
	prima_riesgo_comun_reintegro float(9,2) not null,
	comision_ente_reintegro float(9,2) not null,
	total_aporte_solidario_reintegro float(9,2) not null,
	desc_rciva_reintegro float(9,2) not null,
	otros_descuentos_reintegro float(9,2) not null,
	fondo_social_reintegro float(9,2) not null,
	fondo_empleados_reintegro float(9,2) not null,
	entidades_financieras_reintegro float(9,2) not null,
	total_descuentos_reintegro float(9,2) not null,
	liquido_pagable_reintegro float(9,2) not null,
	estado_planilla_reintegro varchar(20) not null,
	fecha_aprobado_reintegro date not null,
	id_planilla int(11) not null,
	foreign key(id_planilla) references planilla(id_planilla)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists usuario(
	id_usuario int(11) not null auto_increment primary key,
	correo varchar(200) not null,
	cuenta varchar(15) not null,
	nombre_apellidos varchar(200) not null,
	password varchar(50) not null,
	nivel varchar(50) not null,
	fecha_registro datetime not null,
	fecha_actualizacion datetime not null,
	fecha_ultimo_ingreso datetime not null,
	ip_actual char(15) not null,
	ip_ultimo char(15) not null,
	estado_usuario tinyint(1) not null,
	id_trabajador int(11) not null,
	id_rol int(11) not null,
	foreign key(id_trabajador) references trabajador(id_trabajador);
	foreign key(id_rol) references rol(id_rol)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table if not exists rol(
    id_rol int not null auto_increment primary key,
    nombre_rol varchar(50) not null,
    estado_rol tinyint(2) not null
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

create table if not exists total_ganado(
	id_total_ganado int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	total_dias float(9,2) not null,
	haber_mensual float(9,2) not null,
	haber_basico float(9,2) not null,
	bono_antiguedad float(9,2) not null,
	nro_horas_extra float(9,2) not null,
	monto_horas_extra float(9,2) not null,
	suplencia float(9,2) not null,
	total_ganado float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists reintegro_total_ganado(
	id_total_ganado_reintegro int(11) not null auto_increment primary key,
	mes_reintegro int(2) not null,
	gestion_reintegro int(11) not null,
	total_dias_reintegro float(9,2) not null,
	haber_mensual_reintegro float(9,2) not null,
	haber_basico_reintegro float(9,2) not null,
	bono_antiguedad_reintegro float(9,2) not null,
	nro_horas_extra_reintegro float(9,2) not null,
	monto_horas_extra_reintegro float(9,2) not null,
	suplencia_reintegro float(9,2) not null,
	total_ganado_reintegro float(9,2) not null,
	id_total_ganado int(11) not null,
	foreign key(id_total_ganado) references total_ganado(id_total_ganado)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists conf_impositiva(
	id_conf_impositiva int(11) not null auto_increment primary key,
	salario_minimo float(9,2) not null,
	cant_sm int(1) not null,
	porcentaje_imp float(9,2) not null,
	estado varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists impositiva(
	id_impositiva int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	ufv_actual float(9,5) not null,
	ufv_pasado float(9,5) not null,
	total_ganado float(9,2) not null,
	aportes_laborales float(9,2) not null,
	sueldo_neto float(9,2) not null,
	minimo_no_imponible float(9,2) not null,
	base_imponible float(9,2) not null,
	impuesto_bi float(9,2) not null,
	presentacion_desc float(9,2) not null,
	impuesto_mn float(9,2) not null,
	saldo_dependiente float(9,2) not null,
	saldo_fisco float(9,2) not null,
	saldo_mes_anterior float(9,2) not null,
	actualizacion float(9,2) not null,
	saldo_total_mes_anterior float(9,2) not null,
	saldo_total_dependiente float(9,2) not null,
	saldo_utilizado float(9,2) not null,
	retencion_pagar float(9,2) not null,
	saldo_siguiente_mes float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists entidad(
	id_entidad int(11) not null auto_increment primary key,
	nombre_entidad varchar(200) not null,
	ubicacion varchar(25) not null,
	direccion varchar(200) not null,
	telefono varchar(50) not null,
	correo varchar(100) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists conf_descuentos(
	id_conf_descuentos int(11) not null auto_increment primary key,
	nombre_descuento varchar(100) not null,
	estado varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists descuentos(
	id_descuentos int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	nombre_descuento varchar(100) not null,
	monto float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists fondo_empleados(
	id_fondo_empleados int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	porcentaje_fe float(9,2) not null,
	total_ganado float(9,2) not null,
	monto_fe float(9,2) not null,
	pago_deuda float(9,2) not null,
	total_fe float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists conf_otros_descuentos(
	id_conf_otros_descuentos int(11) not null auto_increment primary key,
	descripcion varchar(200) not null,
	tipo_operacion varchar(20) not null,
	factor_calculo varchar(50) not null,
	estado varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists otros_descuentos(
	id_otros_descuentos int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	descripcion varchar(200) not null,
	factor_calculo varchar(100) not null,
	monto_od float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


--Pago de Refrigerios y descargos RCIVA

create table if not exists asistencia_refrigerio(
	id_asistencia_refrigerio int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	dias_laborables int(2) not null,
	dias_asistencia int(2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists descargo_refrigerio(
	id_descargo_refrigerio int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	monto_descargo float(9,2) not null,
	monto_refrigerio float(9,2) not null,
	retencion float(9,2) not null,
	total_refrigerio float(9,2) not null,
	id_asistencia_refrigerio int(11) not null,
	foreign key(id_asistencia_refrigerio) references asistencia_refrigerio(id_asistencia_refrigerio)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists conf_refrigerio(
	id_conf_refrigerio int(11) not null auto_increment primary key,
	descripcion varchar(200) not null,
	monto_refrigerio float(9,2) not null,
	estado_refrigerio varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Este calculo de refrigerio se maneja juntamente con la planilla mensual
--se suma al sueldo neto, el cual se encuentra en la planilla impositiva
--no se mescla con el total ganado porque no esta sujeto a descuentos por aportes laborales.
--Ademas se sigue haciendo uso de la tabla conf_refrigerio
create table if not exists refrigerio(
	id_refrigerio int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	dias_laborables int(2) not null,
	dias_asistencia int(2) not null,
	monto_refrigerio float(9,2) not null,
	total_refrigerio float(9,2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
--Planilla de aguinaldos segun la empresa ELAPAS
create table if not exists aguinaldo(
	id_aguinaldo int(11) not null auto_increment primary key,
	gestion int(11) not null,
	meses int(2) not null,
	item int(11) not null,
	ci varchar(15) not null,
	nombre_empleado varchar(100) not null,
	dias int(3) not null,
	sexo char(1) not null,
	cargo varchar(100) not null,
	fecha_ingreso date not null,
	sueldo_1 float(9,2) not null,
	sueldo_2 float(9,2) not null,
	sueldo_3 float(9,2) not null,
	total float(9,2) not null,
	promedio_3_meses float(9,2) not null,
	aguinaldo_anual float(9,2) not null,
	aguinaldo_pagar float(9,2) not null,
	estado varchar(50) not null,
	nro_aguinaldo int(11) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Subsitema de Administracion de Vacaciones

create table if not exists conf_vacacion(
	id_conf_vacacion int(11) not null auto_increment primary key,
	anio_inicio int(2) not null,
	anio_fin int(2) not null,
	dias_vacacion int(2) not null,
	estado_vaca varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists vacacion(
	id_vacacion int(11) not null auto_increment primary key,
	fecha_ingreso date not null,
	anios_empresa int not null,
	meses_empresa int not null,
	dias_empresa int not null,
	dias_vacacion int not null,
	vacacion_acumulada float(9,2) not null, 
	fecha_calculo date not null,
	id_trabajador int(11) not null,
	foreign key(id_trabajador) references trabajador(id_trabajador)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists detalle_vacacion(
	id_detalle_vacacion int(11) not null auto_increment primary key,
	gestion_inicio int not null,
	gestion_fin int not null,
	fecha_calculo date not null,
	cantidad_dias float(9,2) not null,
	dias_utilizados float(9,2) not null,
	id_vacacion int(11) not null,
	foreign key(id_vacacion) references vacacion(id_vacacion)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



create table if not exists papeleta_vacacion(
	id_papeleta_vacacion int(11) not null auto_increment primary key,
	fecha_solicitud date not null,
	fecha_inicio date not null,
	fecha_fin date not null,
	dias_solicitados float(9,2) not null,
	estado varchar(50) not null,
	autorizado_por varchar(300) not null,
	observacion text not null,
	id_detalle_vacacion int(11) not null,
	foreign key(id_detalle_vacacion) references detalle_vacacion(id_detalle_vacacion)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists uso_vacacion(
	id_uso_vacacion int(11) not null auto_increment primary key,
	fecha_registro date not null,
	gestion_inicio int not null,
	gestion_fin int not null,
	fecha_inicio date not null,
	fecha_fin date not null,
	cantidad_dias float(9,2) not null,
	id_papeleta_vacacion int(11) not null,
	foreign key(id_papeleta_vacacion) references papeleta_vacacion(id_papeleta_vacacion)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- Asistencia de trabajadores segun su cargo
create table if not exists asistencia(
	id_asistencia int(11) not null auto_increment primary key,
	mes int(2) not null,
	gestion int(11) not null,
	dias_asistencia int(2) not null,
	dias_laborables int(2) not null,
	id_asignacion_cargo int(11) not null,
	foreign key(id_asignacion_cargo) references asignacion_cargo(id_asignacion_cargo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Ingresos de funcionarios a la EMPRESA
create table if not exists ingreso_funcionario(
	id_ingreso_funcionario int(11) not null auto_increment primary key,
	fecha_registro date not null,
	fecha_ingreso date not null,
	hora_inicio datetime not null,
	hora_fin datetime not null,
	motivo_ingreso text not null,
	observacion text not null,
	autorizado_por int(11) not null,
	estado_ingreso varchar(200) not null,
	id_usuario int(11) not null,
	foreign key(id_usuario) references usuario(id_usuario)	
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Control de salidas de personal
create table if not exists vehiculo(
    id_vehiculo int primary key auto_increment not null,
    placa varchar(15) not null,
    marca varchar(25) not null,
    modelo varchar(50) not null,
    estado tinyint(2) not null
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


create table if not exists tipo_salida(
    id_tipo_salida int primary key auto_increment not null,
    nombre varchar(25)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


create table if not exists salida(
    id_salida int primary key not null auto_increment,
    hora_retorno time not null,
    hora_exac_llegada time not null,
    hora_salida time not null,
    tiempo_solicitado time not null,
    direccion_salida varchar(20) not null,
    motivo varchar(25) not null,
    observaciones varchar(30) not null,
    fecha date not null,
    id_vehiculo int not null,
    id_usuario int not null,
    id_tipo_salida int not null,
    id_chofer int not null,
    estado tinyint(2) not null,
    foreign key(id_vehiculo) references vehiculo(id_vehiculo),
    foreign key(id_usuario) references usuario(id_usuario),
    foreign key(id_tipo_salida) references tipo_salida(id_tipo_salida)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--Telefonos internos
create table if not exists telefono(
    id_telefono int primary key auto_increment not null,
    telf_interno int not null,
    id_cargo int not null,
    foreign key(id_cargo) references cargo(id_cargo)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


--Formularios de solicitudes

create table if not exists solicitud_material(
	id_solicitud_material int(11) primary key auto_increment not null,
	fecha_solicitud date not null,
	programa varchar(20) not null,
	actividad varchar(20) not null,
	destino_uso varchar(200) not null,
	item_solicitante int(11) not null,
	autorizado_por varchar(200) not null,
	estado_solicitud_material varchar(50) not null,
	id_trabajador int(11) not null,
	foreign key(id_trabajador) references trabajador(id_trabajador)
)ENGINE = InnoDB DEFAULT CHARSET = utf8;

create table if not exists detalle_solicitud_material(
	id_detalle_solicitud_material int(11) primary key auto_increment not null,
	cantidad_solicitada int(11) not null,
	unidad_medida varchar(100) not null,
	descripcion varchar(200) not null,
	id_solicitud_material int(11) not null,
	foreign key(id_solicitud_material) references solicitud_material(id_solicitud_material)
)ENGINE = InnoDB DEFAULT CHARSET = utf8;

create table if not exists lavado(
	id_lavado int(11) primary key auto_increment not null,
	fecha_solicitud date not null,
	marca_vehiculo varchar(100) not null,
	tipo_vehiculo varchar(100) not null,
	numero_placa varchar(100) not null,
	jefatura varchar(200) not null,
	gerencia varchar(200) not null,
	estado_lavado varchar(100) not null,
	id_usuario int(11) not null,
	foreign key(id_usuario) references usuario(id_usuario)
)ENGINE = InnoDB DEFAULT CHARSET = utf8;
