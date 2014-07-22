#!/bin/bash
#script

#verificamos si estamos en produccion

remote()
{

  INS="cd /var/www/nuestroempleo && ./scripts/tareaprogramada.sh"
  if [[ "prod" == "$1" ]]; then
    echo "Configurando tareas automaticas en PRODUCCIÓN"
    ssh root@148.243.72.186 "$INS"
  elif [[ "dev" == "$1" ]]; then
    echo "Configurando tareas automaticas en DESARROLLO"
    ssh root@148.243.72.195 "$INS"
  else
      echo "No existe opción"
  fi
}

if [[ "$#" -eq  "1" ]]; then
  remote "$1"
  exit 1
fi

if [ "$NODE_ENV" != "pro" ]; then
   echo "Verifique que el entorno sea producción";
   exit 1
fi
#obtenemos el path de la carpeta actual
PATH_CAKE=${PWD}
#completamos el path referente al comando cake
PATH_CAKE="${PATH_CAKE}/app/Console"
#agregando variable de entorno para produccion
ENV_PRO="#NODE_ENV=dev";
echo "Configurando path cake "
LINE='PATH_CAKE'
tareas="./scripts/tareas.cron"
if [ -f "$tareas" ]
then
  if grep -q "$PATH_CAKE" "$tareas"; then
    echo "Ya se aplicó path en $tareas"
  fi
  echo "Agregando línea $PATH_CAKE"
  echo "en $tareas"
  sed -i -e "s#\s*$LINE#$PATH_CAKE#" "$tareas"
  sed -i -e "s-\s*$ENV_PRO-NODE_ENV=pro-" "$tareas"
else
  echo "Parece que $tareas no exite."
  exit 1
fi
#agragamos las tareas de nuestro empleo que se realizaran automaticamente
crontab "$tareas"