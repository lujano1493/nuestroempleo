#!/bin/bash

echo  "Se establecerán permisos de ejecución a app/Console/cake"
chmod +x ./app/Console/cake

echo "Se crearán las carpetas necesarias en app/tmp."
mkdir -vp ./app/tmp/{cache/{models,persistent,views},logs,sessions,tests}
sudo chown -R `whoami`:www-data ./app/tmp/
sudo chmod -R 775 ./app/tmp/

echo "Se crearán la carpeta documentos para guardar archivos de candidatos."
mkdir -vp ./documentos
sudo chown -R `whoami`:www-data ./documentos
sudo chmod -R 775 ./documentos

echo "Se crearán las carpetas necesarias en public_html."
mkdir -vp ./public_html/{documentos/{empresas,candidatos},temporales}
sudo chown -R `whoami`:www-data ./public_html/{documentos,temporales}
sudo chmod -R 775 ./public_html/{documentos,temporales}

echo "Copiando archivos de ./docs => ./public_html/documentos"
cp -R ./docs/* ./public_html/documentos

echo  "Se creará link simbólico a public_html/blog"
if [ -f ../blog ]
then
  ln -s ../blog ./public_html/blog
else
  echo "No existe la carpeta ../blog"
fi

echo "Se instalarán las dependencias de Nuestro Empleo (desde composer)."
composer install

echo "configuración de tareas programas "
chmod +x ./scripts/tareaprogramada.sh
./scripts/tareaprogramada.sh