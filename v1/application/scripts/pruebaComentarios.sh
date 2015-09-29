#!/bin/bash
#Pruebas a la API de Taxistas
#Realizado por: Cecilia Hernandez Vasquez

#Datos enviados: Para esta prueba se realiza un metodo GET a la API Comentarios sin parametros 
#Datos esperados: un json con los primeros 5 comentarios
#{"id_comentarios":"1","id_viaje":"1","comentarios":"-----------"}


echo "metodo GET a la API Comentarios\n"
for i in 1 2 3 4 5;
do
    echo "curl \n: $i"
   curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/comentarios
done


#Datos enviados: Para esta prueba se realiza un metodo GET a la API Comentarios enviando un id_taxista
#Datos esperados: un json con los comentarios relacionados con ese taxista
#{"id_viaje":"216","id_taxista":"6","id_comentarios":"216","comentarios":"bla bla bla"}

echo "metodo GET a la API Comentarios id_taxista\n"
for i in 1 2 3 4 5;
do
    echo "curl \n: $i"
   curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/comentarios/6
   #curl -X POST  http://localhost/taxi/v1/index.php/comentarios/6
done
 curl -X POST  http://localhost/taxi/v1/index.php/comentarios/6


# Se realizan POST's a la API de Comentarios
# Este metodo de la API inserta un comentario a la base de datos de comentarios 
# en la BD. Devuelve un JSON con la confirmacion de la tarea realizada
#

echo "metodo POST's a la API Comentarios\n"
for i in 1 2 3 4 5;
do
    echo "curl \n: $i"
     #curl -X POST -d 'id_viaje=8&comentarios=blablalvla' http://localhost/taxi/v1/index.php/comentarios
     curl -X POST -d 'id_viaje=8&comentarios=blablalvla'  http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/comentarios	
   curl -X POST -d http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/comentarios	
done


# Se realizan PUT a la API de Comentarios
# Este metodo de la API actualiza un viaje al ocurrir un incidente y guarda el incidente 
# en la BD. Devuelve un JSON con la confirmacion de la tarea realizada

echo "metodo PUT a la API Comentarios\n"
for i in 1 2 3 4 5;
do
    echo "curl \n: $i"
    #curl -X PUT -d "comentario=blabla"  http://localhost/taxi/v1/index.php/comentarios/5
    curl -X PUT -d 'comentario=blabla5' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/comentarios/5	
   
done

# Se realizan DELETE a la API de Comentarios
# Este metodo de la API actualiza un viaje al ocurrir un incidente y guarda el incidente 
# en la BD. Devuelve un JSON con la confirmacion de la tarea realizada

echo "metodo DELETE a la API Comentarios"
for i in 1 2 3 4 5;
do
    echo "curl \n: $i"
    #curl -X DELETE  http://localhost/taxi/v1/index.php/comentarios/$i
    curl -X DELETE http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/comentarios/$i
   
done




