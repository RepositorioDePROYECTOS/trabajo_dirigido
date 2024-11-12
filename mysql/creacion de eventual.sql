create table if not exists eventual(
  id_eventual int(11) not null auto_increment primary key,
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
  profesion varchar(50) not null,
  estado_eventual varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
create table if not exists formacion_eventual(
  id_formacion_eventual int(11) not null auto_increment primary key,
  grado_formacion varchar(100) not null,
  titulo_academico varchar(200) not null,
  id_eventual int(11) not null,
  foreign key(id_eventual) references eventual(id_eventual)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists cargo_eventual(
	id_cargo_eventual int(11) not null auto_increment primary key,
	item varchar(10) not null,
	nivel int(2) not null,
	descripcion varchar(200) not null,
	salario_mensual float(9,2) not null,
	estado_cargo varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists asignacion_cargo_eventual(
	id_asignacion_cargo_eventual int(11) not null auto_increment primary key,
	fecha_ingreso date not null,
	fecha_salida date not null,
	item varchar(10) not null,
	salario float(9,2) not null,
	cargo varchar(200) not null,
	estado_asignacion varchar(20) not null,
	id_cargo_eventual int(11) not null,
	id_eventual int(11) not null,
	foreign key(id_cargo_eventual) references cargo_eventual(id_cargo_eventual),
	foreign key(id_eventual) references eventual(id_eventual)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists eventual(
	id_eventual int(11) not null auto_increment primary key,
    nombres varchar(150) not null,
    apellido_paterno varchar(50) not null,
    apellido_materno varchar(50) not null,
    item varchar(10) not null,
	nivel int(2) not null,
	descripcion varchar(200) not null,
    seccion varchar(200) not null,
	salario_mensual float(9,2) not null,
	estado_eventual varchar(20) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

