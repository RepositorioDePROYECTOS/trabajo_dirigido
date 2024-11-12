create table if not exists tipo_estante(
    id_tipo_estante int primary key AUTO_INCREMENT not null,
    categoria varchar(20) not null,
    descripcion varchar(200)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
create table if not EXISTS estante(
    id_estante int primary key AUTO_INCREMENT not null,
    nro_estante varchar(20) not null,
    nro_filas int(2) not null,
    estado TINYINT(2) not null,
    id_tipo_estante int not null,
    foreign key(id_tipo_estante) references tipo_estante(id_tipo_estante)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
create table if not exists fila(
    id_fila int primary key AUTO_INCREMENT not null,
    nro_fila int(2) not null,
    estado TINYINT(2) not null,
    id_estante int not null,
    foreign key(id_estante) references estante(id_estante)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
create table if not exists caja(
    id_caja int primary key AUTO_INCREMENT not null,
    nro_caja int(12) not null,
    estado TINYINT(2) not null,
    id_fila int not null,
    foreign key(id_fila) references fila(id_fila)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
create table if not exists usuario_elapas(
    id_usuario_elapas int primary key AUTO_INCREMENT not null,
    codigo_catastral_actual int(11) not null,
    codigo_catastral_antiguo int(11) not null,
    numero_cuenta int(11) not null,
    nombre_usuario varchar(200) not null,
    documento varchar(12) not null,
    direccion varchar(200) not null,
    categoria varchar(30),/*domestico, comercial, etc*/
    paralelo char(2) not null,/*si o no*/
    codigo_catastral_origen int(11) not null,
    numero_cuenta_origen int(11) not null,
    estado varchar(20) not null /*activo o deshabilitado*/
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
create table if not exists expediente(
    id_expediente int primary key AUTO_INCREMENT not null,
    fecha_registro datetime not null,
    nombre_archivo varchar(50) not null,
    nro_fojas int not null,
    observacion text,
    archivo varchar(50) not null,
    id_usuario_elapas int(11),
    foreign key(id_usuario_elapas) references usuario_elapas(id_usuario_elapas)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
create table if not exists asignar_caja(
    id_asignar_caja int primary key AUTO_INCREMENT not null,
    fecha_asignacion date not null,
    codigo_archivo varchar(20) int not null,
    id_caja int not null,
    id_expediente int not null,
    foreign key(id_caja) references caja(id_caja),
    foreign key(id_expediente) references expediente(id_expediente)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;