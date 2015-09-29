#!/bin/bash
#Pruebas a la API de Taxistas
#Realizado por: Bryan Velazquez



echo "Metodo POST a la API Taxistas"
for i in 1 2 3 4 5;
do
	echo "curl \n: $i"
	curl -X POST -d 'identificador=15676&acumulado_calificacion=8.5&numero_viajes=12' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas
done




echo "metodo PUT a la API Taxistas"
for i in 1 2 3 4 5;
do
    echo "curl \n: $i"
    curl -X PUT -d 'numero_viajes=45' http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas/$i	
   
done


echo "metodo DELETE a la API Taxistas"
for i in 1 2 3 4 5;
do
    echo "curl \n: $i"
    curl -X DELETE http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas/$i	
   
done



#Datos enviados: Para esta prueba se realiza un metodo GET a la API Taxistas mandando el parametro identificador del taxista
#Datos esperados: La consulta debe devolver un arreglo con los siguientes campos:
#[nombre, Apellido_Paterno, Apellido_Materno, Identificador, Vigencia, Antiguedad]

echo "identificador = 15676"
echo "El taxista si existe en la base de datos del laboratorio para la ciudad y en nuestra base de datos"
echo "Resultado = Muestra los datos del taxista"
for i in 1 2;
do
	echo "curl \n: $i"
	curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas/15676
done



echo "identificador = vacio (%20%)"
echo "Se espera obtener todos los taxistas que estan en nuestra base de datos"
echo "Resultado: Se muestran todos los taxistas que se encuentran en nuetsra base de datos"

for i in 1 2;
do
	echo "curl \n: $i"
curl -X GET --limit 10k http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas
done


#Datos enviados: Para esta prueba se realiza un metodo GET a la API Taxistas mandando nombre y apellidos de taxista como parametros
#Datos esperados: La consulta debe devolver un arreglo con los siguientes campos:
#[nombre, Apellido_Paterno, Apellido_Materno, Identificador, Vigencia, Antiguedad]

echo "nombre = Ramon, apellido_paterno = Gonzalez, apellido_materno = Rangel"
echo "El taxista si existe en la base de datos del laboratorio para la ciudad y en nuestra base de datos"
echo "Resultado = Muestra los datos del taxista"

for i in 1 2;
do
	echo "curl \n: $i"
curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas/ramon/gonzalez/rangel
done

echo "nombre = Miguel, apellido_paterno = Jaimez, apellido_materno = Abascal"
echo "Los datos del taxista ingresado no existe en la base de datos del laboratorio para la ciudad"
echo "Resultado: Muestra un mensaje indicando que no existe el taxista"

for i in 1 2;
do
	echo "curl \n: $i"
curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas/miguel/jaimez/abascal
done

echo "nombre = Jesus, apellido_paterno = Martinez, apellido_materno = Gonzalez"
echo "El taxista si existe en la base de datos del laboratorio para la ciudad pero no esta en nuestra base de datos"
echo "Resultado = Muestra los datos del taxista y lo agrega a nuestra base de datos "
for i in 1 2;
do
	echo "curl \n: $i"

curl -X GET http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/taxistas/jesus/martinez/gonzalez
done


