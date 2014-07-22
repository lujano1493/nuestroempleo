#!/bin/bash

# Compilando los assets.
#
# Cuando se pasa la opción -s prod|dev, compilará en los servidores remotos.
# ./scripts/compilar.sh -s prod|dev

ACOMPRESS_PATH="./app/Config/asset_compress.ini"
CORE_PATH="./app/Config/core.php"

remote()
{
  if [[ "prod" == "$1" ]]; then
    echo "Compilando en PRODUCCIÓN"
    ssh root@148.243.72.186 "cd /var/www/nuestroempleo && ./scripts/compilar.sh"
  elif [[ "dev" == "$1" ]]; then
    echo "Compilando en DESARROLLO"
    ssh root@148.243.72.195 "cd /var/www/nuestroempleo && ./scripts/compilar.sh"
  else
    echo "Environment no existe."
  fi
}

uglify()
{
  # Restaura la configuración previa de asset_compress
  if [[ "$1" == "restore" ]]; then
    echo "Restableciento Uglifyjs: $FILTER_TEMP"
    sed -i -e "s@[;]*filters\[\]\s*=\s*Uglifyjs@$FILTER_TEMP@g" "$ACOMPRESS_PATH"

    echo "Restableciento node: $NODE_TEMP"
    sed -i -e "s@node\s*=\s*\/.*\/node@$NODE_TEMP@g" "$ACOMPRESS_PATH"

    echo "Restableciento uglify: $UGLIFY_TEMP"
    sed -i -e "s@uglify\s*=\s*\/.*\/uglifyjs\s*[-mt]*@$UGLIFY_TEMP@g" "$ACOMPRESS_PATH"

    return 0
  fi

  # Obtiene la configuración por default.
  FILTER_TEMP=`sed -n '/[;]*filters\[\]\s*=\s*Uglifyjs/p' "$ACOMPRESS_PATH"`
  NODE_TEMP=`sed -n '/node\s*=\s*\/.*\/node/p' "$ACOMPRESS_PATH"`
  UGLIFY_TEMP=`sed -n '/uglify\s*=\s*\/.*\/uglifyjs\s*[-mt]*/p' "$ACOMPRESS_PATH"`

  # Activa el filtro de uglify.
  echo "Activando Uglifyjs"
  sed -i -e "s@[;]*filters\[\]\s*=\s*Uglifyjs@filters\[\] = Uglifyjs@g" "$ACOMPRESS_PATH"

  # Configura el path de node.
  echo "Configurando node: $1"
  sed -i -e "s@node\s*=\s*\/.*\/node@node = "$1"@g" "$ACOMPRESS_PATH"

  # Configura el path de uglify.
  echo "Configurando uglify: $2 -mt"
  sed -i -e "s@uglify\s*=\s*\/.*\/uglifyjs\s*[-mt]*@uglify = "$2" -mt@g" "$ACOMPRESS_PATH"
}

# Obtiene las opciones.
while getopts ":s:" opt; do
  case $opt in
    s)
      remote $OPTARG
      exit 1
      ;;
  esac
done

#Obtiene la configuración del cache.
CACHE_ENGINE=`grep -E "('cache_engine',)" "$CORE_PATH" | grep -oE "(Redis|File)"`
NODEPATH=`which node`
UGLIFYPATH=`which uglifyjs`

# Si existen node y uglify
if [[ -n "$NODEPATH" && -n "$UGLIFYPATH"  ]]; then
  uglify $NODEPATH $UGLIFYPATH
fi

# Si cache engine es diferent de File, lo establece a file.
if [[ "$CACHE_ENGINE" != "File" ]]; then
  echo "Cambiando cache_engine a File."
  sed -i -e "s/Configure::write('cache_engine',\s*'"$CACHE_ENGINE"');/Configure::write('cache_engine', 'File');/g" "$CORE_PATH"
fi

# Compila.
echo "Limpiando compilaciones previas"
rm ./public_html/js/*.v*.js
rm ./public_html/css/*.v*.css
echo "Compilando con AssetCompress."
./app/Console/cake AssetCompress.AssetCompress build

# Si node y uglify existen, ya compiló. Entonces restaura asset_compress.ini a su origen.
if [[ -n "$NODEPATH" && -n "$UGLIFYPATH"  ]]; then
  uglify 'restore'
fi

# Restaura cache_engine a su origen.
if [[ "$CACHE_ENGINE" != "File" ]]; then
  echo "Reestableciendo cache_engine a Redis."
  sed -i -e "s/Configure::write('cache_engine',\s*'File');/Configure::write('cache_engine', '"$CACHE_ENGINE"');/g" "$CORE_PATH"
fi