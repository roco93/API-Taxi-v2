#!/bin/bash

echo "Las pruebas a los metodos que se conectan al LABPLC estan comentados\n"
# echo "placas=A12345,lat_origen=88,long_origen=12\n"
# echo "Respuesta: Muestra la nformacion de la placa ingresada. Se crea el viaje\n"
# for i in 1 2 3 4 5;
# do
#     echo "curl : $i\n"
#    curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/evaluaciones/A12345/88/12
# done


# echo "Si placa es vacia,lat_origen=88,long_origen=12\n"
# echo "Respuesta:ERROR, al faltar parametros en la url\n"
# for i in 1 2 3 4 5;
# do
#     echo "curl : $i\n"
#    curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/evaluaciones//88/12
   
# done

# echo "Si lat_origen es vacia ,placas=A12345,long_origen=12"
# echo "Respuesta:ERROR, al faltar parametros en la url\n"
# for i in 1 2 3 4 5;
# do
#     echo "curl : $i\n"
#    curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/evaluaciones/A12345//12
   
# done

# echo "Si long_origen es vacia,placas=A12345,lat_origen=88"
# echo "Respuesta:ERROR, al faltar parametros en la url\n"
# for i in 1 2 3 4 5;
# do
#     echo "curl : $i\n"
#    curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/evaluaciones/A12345/88/
   
# done

echo "Si no se pasan parametros"
echo "Respuesta: Muestra mensaje indicando que el metodo get no esta definido\n"
for i in 1 2 3 4 5;
do
    echo "curl : $i\n"
   	curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/evaluaciones/
   
done

# echo "placas=S12345"
# echo "Placa no existe en LABPLC\n"
# echo "Respuesta: Los datos referentes al taxi, concesionario, taxistas son vacios\n"
# for i in 1 2 3 4 5;
# do
#     echo "curl : $i\n"
#    	curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/evaluaciones/S12345/88/12
   
# done

echo "Metodo POST\n"
echo "Respuesta: Mensaje indicando que el metodo no esta definido\n"
for i in 1 2 3 4 5;
do
    echo "curl : $i\n"
   	curl -X POST -d 'something=value' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/evaluaciones/
   
done

echo "Metodo PUT\n"
echo "Respuesta: Mensaje indicando que el metodo no esta definido\n"
for i in 1 2 3 4 5;
do
	echo "curl : $i\n"
	curl -X PUT -d 'something=value' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Evaluaciones/$i
done

echo "Metodo DELETE\n"
echo "Respuesta: Mensaje indicando que el metodo no esta definido\n"
for i in 1 2 3 4 5;
do
	echo "curl :$i\n"
	curl -X DELETE http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Evaluaciones/$i

done