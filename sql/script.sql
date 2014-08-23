/*
	configuracion 

	DEV: sqlplus64 NE/QWERTYU12@NE_DEV
	PRO: sqlplus64 NE/ZVXCMNBCGS@NE_PRO	
*/

desc teventos;

/*
Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 EVENTO_CVE					    NUMBER
 CIA_CVE					    NUMBER
 EVENTO_NOMBRE					    VARCHAR2(250)
 EVENTO_RESENA					    CLOB
 EVENTO_DIR					    VARCHAR2(128)
 LATITUD					    FLOAT(126)
 LONGITUD					    FLOAT(126)
 EVENTO_TIPO					    NUMBER
 EVENTO_FECINI					    DATE
 EVENTO_FECFIN					    DATE
 CIUDAD_CVE					    NUMBER
 EVENTO_STATUS					    NUMBER
 EVENTO_CP					    VARCHAR2(8)
 EVENTO_CALLE					    VARCHAR2(256)
 CU_CVE 					    NUMBER
 CREATED					    DATE
 MODIFIED					    DATE
*/
alter table teventos add ( evento_redsocial number );
alter table teventos add ( evento_link varchar2(64) );
desc t;
column column_name format a30
set linesize 300
set autocommit off

select candidato_cve,cc_email,cc_status from tcuentacandidato where rownum<=1 order by candidato_cve desc nulls last;

update tcuentacandidato set cc_status=-3 where  