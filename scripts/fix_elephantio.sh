#!/bin/bash

# curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());

LINE='curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);'
FIX_LINE='curl_setopt($ch, CURLOPT_COOKIE, session_name() . "=" . session_id());'

ELEPANTHIO_CLIENT_PATH="./vendor/wisembly/elephant.io/lib/ElephantIO/Client.php"

if [ -f "$ELEPANTHIO_CLIENT_PATH" ]
then
  if grep -q "$FIX_LINE" "$ELEPANTHIO_CLIENT_PATH"; then
    echo "Ya se aplicó la corrección en $ELEPANTHIO_CLIENT_PATH"
    exit 0
  fi
  echo "Agregando línea $FIX_LINE"
  echo "en $ELEPANTHIO_CLIENT_PATH"
  sed -i -e "s/\s*$LINE/\t\t$LINE\n\t\t$FIX_LINE/" "$ELEPANTHIO_CLIENT_PATH"
else
  echo "Parece que $ELEPANTHIO_CLIENT_PATH no exite."
fi