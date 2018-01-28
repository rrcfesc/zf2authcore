[![Build Status](https://travis-ci.org/rrcfesc/zf2authcore.svg?branch=master)](https://travis-ci.org/rrcfesc/zf2authcore)
# Core base
Esta libreria proveé, todos los métodos para hacer TDD, haciendo uso de una capa de abstracción en la cual se usa una capa donde está el mapeado de la base de datos, en otro el DAO y la tercera capa el uso de una capa llamada SERVICE.

# Instalación y configuración

## Configuración container Docker
Se esta dando un ejemplo de un container usando el stack LAMP (Linux Apache Mysql Php), esta imagen deberá de compilarse de acuerdo a tu id de usuario, para esto deberas de descargar el proyecto de github

```bash
$ git clone https://github.com/rrcfesc/dockerFilesMagento2.git
$ cd dockerFilesMagento2
$ id -u TUUSUARIO #Outputexample 1001
```
Modifica el archivo llamado DockerFile y realiza los siguientes movimientos, cambiando por el id de tu usuario.

```git
diff --git a/Dockerfile b/Dockerfile
index 060b995..aea3144 100644
--- a/Dockerfile
+++ b/Dockerfile
@@ -5,8 +5,8 @@ MAINTAINER 'Ricardo Ruiz Cruz'
 ENV SERVER_NAME                'localhost'
 ENV WEBSERVER_USER     'www-data'
 ENV MAGENTO_USER       'magento2'
-ENV CURRENT_USER_UID   "1001"
-ENV MAGENTO_GROUP       "2000"
+ENV CURRENT_USER_UID   "IDUSER"
+ENV MAGENTO_GROUP       "IDUSER"

 RUN apt-get update
 RUN apt-get install wget apt-utils tcl build-essential -y
diff --git a/extraFiles/000-default.conf b/extraFiles/000-default.conf
index cafe674..e69ed8b 100644
--- a/extraFiles/000-default.conf
+++ b/extraFiles/000-default.conf
@@ -9,7 +9,7 @@
        #ServerName www.example.com

        ServerAdmin webmaster@localhost
-       DocumentRoot /var/www/html/pub
+       DocumentRoot /var/www/html
```
Al terminar de hacer estos cambios por favor compilar, modifica el docker-compose.yml por el nombre de tu container.

## Carácteristicas que provee
Se integran lo siguientes proyectos, los cuales se pueden integrar fácilmente, lo cual se puede hacer un fork, hacer uso de los métodos ya diseñados para agrandar tus Entities de tu base de datos.

		https://github.com/bjyoungblood/BjyAuthorize
		https://github.com/doctrine/DoctrineORMModule
			