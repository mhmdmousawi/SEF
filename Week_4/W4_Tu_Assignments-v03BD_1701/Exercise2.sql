/* Creating database*/
CREATE DATABASE HospitalRecords;

/* Select Database to use*/
USE HospitalRecords;

/*-------------------------------------------*/

/* Drop Table */
DROP TABLE if exists `AnestProcedures`; 

/* Creating table */
create table AnestProcedures (
				proc_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				anest_name VARCHAR(20) NOT NULL ,
				start_time TIME not null,
				end_time TIME not null
			);

/* Adding records */
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Albert','08:00', '11:00');
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Albert','09:00', '13:00');
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Kamal','08:00', '13:30');
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Kamal','09:00', '15:30');
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Kamal','10:00', '11:30');
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Kamal','12:30', '13:30');
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Kamal','13:30', '14:30');
INSERT INTO AnestProcedures(anest_name,start_time,end_time) VALUES ('Kamal','18:30', '19:00');


WITH AllRecords (IN anest_name) AS(
	select anest_name 
	from AnestProcedures
)select *
from AllRecords;


/* Drop PROCEDURE */
DROP PROCEDURE IF EXISTS `OVERLAP`; 


CREATE PROCEDURE OVERLAP(IN startPoint int, start_time_old TIME, end_time_old TIME, depth int)
BEGIN
	DECLARE n INT DEFAULT 0;
	DECLARE result INT DEFAULT 0;
	DECLARE start_time_new INT DEFAULT 0;
	DECLARE end_time_new INT DEFAULT 0;

	SELECT COUNT(*) FROM AnestProcedures INTO n;
	IF (startPoint<n)
	THEN

		SET result = result + MAX(
									CALL OVERLAP(startPoint+1,),
									CALL OVERLAP(startPoint+1,)
									);
	END IF;
	select 0;
End;

CALL OVERLAP(0,'08:00','11:00',1);
