/*==============================================================*/
/* DBMS name:      Sybase SQL Anywhere 11                       */
/* Created on:     30/06/2015 05:30:02 p.m.                     */ 
/* Author:         EVJ                                          */
/*==============================================================*/


/*==============================================================*/
/* DROP AND CREATE SCHEMA                                       */
/*==============================================================*/
drop schema public cascade;
create schema public;

/*==============================================================*/
/* Table: COMENTARIOS                                            */
/*==============================================================*/
create table COMENTARIOS 
(
   ID_COMENTARIO        serial                         not null,
   ID_VIAJE             bigint                         null,
   COMENTARIO           character varying(500)         null,
   constraint PK_COMENTARIOS primary key (ID_COMENTARIO)
);

/*==============================================================*/
/* Table: ESTATUS_VIAJE                                         */
/*==============================================================*/
create table ESTATUS_VIAJE 
(
   ID_ESTATUS_VIAJE     serial                         not null,
   DESCRIPCION          character varying(40)          null,
   constraint PK_ESTATUS_VIAJE primary key (ID_ESTATUS_VIAJE)
);

/*==============================================================*/
/* Table: INCIDENTES                                            */
/*==============================================================*/
create table INCIDENTES 
(
   ID_INCIDENTE         serial                         not null,
   ID_VIAJE             bigint                         null,
   LAT_INCIDENTE        character varying(20)          null,
   LONG_INCIDENTE       character varying(20)          null,
   FECHA                timestamp                      null default null,
   constraint PK_INCIDENTES primary key (ID_INCIDENTE)
);

/*==============================================================*/
/* Table: TAXIS                                                 */
/*==============================================================*/
create table TAXIS 
(
   ID_TAXI              serial                         not null,
   PLACAS               character varying(8)           null,
   NIVEL_CONFIANZA      float                          null,
   constraint PK_TAXIS primary key (ID_TAXI)
);

/*==============================================================*/
/* Table: TAXISTAS                                              */
/*==============================================================*/
create table TAXISTAS 
(
   ID_TAXISTA           serial                         not null,
   IDENTIFICADOR        character varying(10)          null,
   ACUMULADO_CALIFICACION      float                          null default null,
   NUMERO_VIAJES        int                            null,
   constraint PK_TAXISTAS primary key (ID_TAXISTA)
);

/*==============================================================*/
/* Table: TAXI_HAS_TAXISTA                                      */
/*==============================================================*/
create table TAXI_HAS_TAXISTA 
(
   ID_TAXI_HAS_TAXISTA  serial                         not null,
   ID_TAXI              bigint                         null,
   ID_TAXISTA           bigint                         null,
   FECHA                timestamp                      null default null,
   constraint PK_TAXI_HAS_TAXISTA primary key (ID_TAXI_HAS_TAXISTA)
);

/*==============================================================*/
/* Table: VIAJES                                                */
/*==============================================================*/
create table VIAJES 
(
   ID_VIAJE             serial                         not null,
   ID_TAXI              bigint                         null,
   ID_ESTATUS_VIAJE     bigint                         null,
   ID_TAXISTA           bigint                         null default null,
   IDENT_DISPOSITIVO    character varying(30)          null,
   LAT_ORIGEN           character varying(20)          null,
   LONG_ORIGEN          character varying(20)          null,
   LAT_DESTINO          character varying(20)          null,
   LONG_DESTINO         character varying(20)          null,
   CALIFICACION         float                          null,
   NIVEL_CONFIANZA      float                          null,
   FECHA                timestamp                      null default null,
   constraint PK_VIAJES primary key (ID_VIAJE)
);

alter table COMENTARIOS
   add constraint FK_COMENTAR_REFERENCE_VIAJES foreign key (ID_VIAJE)
      references VIAJES (ID_VIAJE)
      on update restrict
      on delete restrict;

alter table INCIDENTES
   add constraint FK_INCIDENT_REFERENCE_VIAJES foreign key (ID_VIAJE)
      references VIAJES (ID_VIAJE)
      on update restrict
      on delete restrict;

alter table TAXI_HAS_TAXISTA
   add constraint FK_TAXI_HAS_REFERENCE_TAXIS foreign key (ID_TAXI)
      references TAXIS (ID_TAXI)
      on update restrict
      on delete restrict;

alter table TAXI_HAS_TAXISTA
   add constraint FK_TAXI_HAS_REFERENCE_TAXISTAS foreign key (ID_TAXISTA)
      references TAXISTAS (ID_TAXISTA)
      on update restrict
      on delete restrict;

alter table VIAJES
   add constraint FK_VIAJES_REFERENCE_TAXIS foreign key (ID_TAXI)
      references TAXIS (ID_TAXI)
      on update restrict
      on delete restrict;

alter table VIAJES
   add constraint FK_VIAJES_REFERENCE_ESTATUS_ foreign key (ID_ESTATUS_VIAJE)
      references ESTATUS_VIAJE (ID_ESTATUS_VIAJE)
      on update restrict
      on delete restrict;



/*==============================================================*/
/* ------------------      DATOS DE PRUEBA      ----------------*/
/*==============================================================*/


/*==============================================================*/
/* INSERTS TAXIS                                                */
/*==============================================================*/
DO $$
BEGIN
 FOR i IN 1..100 LOOP
   INSERT INTO taxis(placas, nivel_confianza) VALUES ('A'||round(random()* 99999), random()*(10-1)+1 ); 
 END LOOP;




/*==============================================================*/
/* INSERTS TAXISTAS                                              */
/*==============================================================*/


 FOR i IN 1..200 LOOP
   INSERT INTO taxistas(identificador, acumulado_calificacion, numero_viajes) VALUES (''||round(random()* 999999), round(CAST ((random()*(10-1)+1) as numeric),1),floor(random()*(10-1)+1) ); 
 END LOOP;



/*==============================================================*/
/* INSERTS TAXI_HAS_TAXISTA                                     */
/*==============================================================*/


 FOR i IN 1..100 LOOP
   INSERT INTO taxi_has_taxista(id_taxi, id_taxista) VALUES ((SELECT id_taxi FROM taxis  ORDER BY RANDOM() LIMIT 1),(SELECT id_taxista FROM taxistas  ORDER BY RANDOM() LIMIT 1));
 END LOOP;


/*==============================================================*/
/* INSERTS ESTATUS_VIAJE                                        */
/*==============================================================*/
INSERT INTO estatus_viaje(descripcion) VALUES ('estatus 1');
INSERT INTO estatus_viaje(descripcion) VALUES ('estatus 2');
INSERT INTO estatus_viaje(descripcion) VALUES ('estatus 3');
INSERT INTO estatus_viaje(descripcion) VALUES ('estatus 4');

/*==============================================================*/
/* INSERTS VIAJES, COMENTARIOS, INCIDENTES                      */
/*==============================================================*/

  
 FOR i IN 1..500 LOOP
    INSERT INTO viajes(id_taxi, id_estatus_viaje, id_taxista, ident_dispositivo, lat_origen, long_origen, lat_destino, long_destino, calificacion, nivel_confianza, fecha) VALUES ((SELECT id_taxi FROM taxis  ORDER BY RANDOM() LIMIT 1),(SELECT id_estatus_viaje FROM estatus_viaje ORDER BY RANDOM() LIMIT 1),(SELECT id_taxista FROM taxistas ORDER BY RANDOM() LIMIT 1) ,(SELECT ('123456'||(SELECT floor(RANDOM()*(50-1)+1)))),(SELECT round (CAST ((SELECT (RANDOM()*(20-19)+19)) as numeric),8)),(SELECT round (CAST ((SELECT (RANDOM()*(-99-(-100))-100)) as numeric),8)),(SELECT round (CAST ((SELECT (RANDOM()*(20-19)+19)) as numeric),8)),(SELECT round (CAST ((SELECT (RANDOM()*(-99-(-100))-100)) as numeric),8)),((SELECT floor(RANDOM()*(6-0)+0))),((SELECT round (CAST ((SELECT (RANDOM()*(11-0)+0)) as numeric),5))),(NOW() - interval '2 hours' * (SELECT floor(RANDOM()*(5000-1)+1))));
    INSERT INTO comentarios(id_viaje, comentario) VALUES ((SELECT currval(pg_get_serial_sequence('viajes','id_viaje'))), 'bla bla bla');
    IF ((SELECT floor (RANDOM()*(500-1)+1)))>400 THEN
      INSERT INTO incidentes(id_viaje, lat_incidente, long_incidente, fecha) VALUES ((SELECT currval(pg_get_serial_sequence('viajes','id_viaje'))), (SELECT round (CAST ((SELECT (RANDOM()*(20-19)+19)) as numeric),8)),(SELECT round (CAST ((SELECT (RANDOM()*(-99-(-100))-100)) as numeric),8)), (SELECT fecha FROM viajes WHERE id_viaje = (SELECT currval(pg_get_serial_sequence('viajes','id_viaje')))) + (i * interval '1 minute'));
    END IF;
  END LOOP;
END$$;

/*==============================================================*/
/* END SQL STAMENTS                                             */
/*==============================================================*/