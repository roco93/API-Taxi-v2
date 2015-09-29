# !/bin/bash
#Pruebas a la API de Viajes
#Realizado por: Cecilia Hernandez Vasquez

echo "Metodo GET"
echo "id_viaje = 12 "
echo "Este id_viaje existe en la base de datos."
echo "Respuesta: Muestra los datos del viaje 12"
for i in 1 2 3 4 5;
do
    echo "curl : $i"
   curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes/12
done

echo "\nMetodo GET"
echo "id_viaje = 600" 
echo "Este id_viaje no existe en la base de datos"
echo "Respuesta: Muestra un mensaje indicando que no existe el viaje"
for i in 1 2 3 4 5;
do
    echo "curl: $i"
   curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes/600
done

echo "\nMetodo GET"
echo "id_viaje = ''" 
echo "Con el id_viaje vacio se traen todos los viajes en la Bn"
echo "Respuesta: Muestra los datos de todos los viajes en la BD"
curl -X GET --limit 10k http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes


echo "\nMetodo POST"
echo "Respuesta: Muestra mensaje indicando que este metodo no tiene contenido"
for i in 1 2 3 4 5;
do
    echo "curl : $i"
   curl -X POST -d 'something=value' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes
   echo "\n"
done

echo "\nMetodo PUT"
echo "id_viaje = 500" 
echo "Este viaje existe en la base de datos"
echo "Respuesta: Muestra la confirmacion de la operacion"
for i in 1 2 3 4 5;
do
    echo "curl : $i"
   curl -X PUT -d 'id_taxi=80&id_estatus_viaje=4&id_taxista=120&ident_dispositivo=45798231&lat_destino=66&long_destino=44&calificacion=5&nivel_confianza=78&fecha=2014-08-26 00:02:40.467' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes/500
   echo "\n"
done

echo "\nMetodo PUT"
echo "id_viaje = 700" 
echo "Este viaje no existe en la base de dato"
echo "Respuesta: Muestra la mensaje de error"
for i in 1 2 3 4 5;
do
    echo "curl : $i"
   curl -X PUT -d 'id_taxi=80&id_estatus_viaje=4&id_taxista=120&ident_dispositivo=45798231&lat_destino=66&long_destino=44&calificacion=5&nivel_confianza=78&fecha="2014-08-26 00:02:40.467"' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes/700
   echo "\n"
done

echo "\nMetodo PUT"
echo "id_viaje = 499 , algun otro campo vacio"
echo "Este viaje existe en la base de datos"
echo "Respuesta: NULL, al faltar algun campo para la actualizacion"
for i in 1 2 3 4 5;
do
    echo "curl : $i"
   curl -X PUT -d 'id_taxi=80&id_taxista=120&ident_dispositivo=45798231&lat_destino=66&long_destino=44&calificacion=5&nivel_confianza=78&fecha="2014-08-26 00:02:40.467"' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes/499
   echo "\n"
done

echo "\nMetodo DELETE"
echo "Respuesta: Muestra mensaje de que el cntenido del metodo es vacio"
for i in 1 2 3 4 5;
do
    echo "curl : $i"
   curl -X DELETE  http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/viajes/500
   echo "\n"
done	