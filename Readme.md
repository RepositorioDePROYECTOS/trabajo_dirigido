## PHP
Se usara php5.3 para este proyecto

## Estructura
```
└── 📁planillas-elapas
    └── .env
    └── .gitignore
    └── 📁archivo
    └── 📁asistencia_poconas
        └── .env
        └── 📁poconas
            └── asistencia.py
        └── Readme.md
        └── 📁urrielagoitia
            └── asistencia.py
    └── 📁backups
        └── bd_planilla (5).sql
    └── 📁control
    └── docker-compose.yml
    └── Dockerfile
    └── 📁documents
    └── 📁files
    └── index.php
    └── modal_index_ajax.php
    └── 📁modelo
    └── 📁mysql
    └── 📁php
        └── php.ini
        └── php_info.php
    └── Readme.md
    └── requirements.txt
    └── 📁vista
```

## Crear el contenedor
Es necesario crear el contenedor parausar la version especifica de PHP
``` bash
## Crear y luego montar la imagen
$ docker compose build
## De manera directa
$ docker compose up -d
```

## Dependencias necesarias para el proyecto
Se usa Servicios externos de Python para las marcaciones
``` bash
$ http://192.168.16.30:3010/ejecutar_marcaciones_poconas
$ http://192.168.16.30:3011/ejecutar_marcaciones_ptar
```