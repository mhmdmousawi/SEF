

/* Creating database*/
CREATE DATABASE FinanceDB;

/* Select Database to use*/
USE FinanceDB;

-------------------------------------------

/* Drop Table */
DROP TABLE if exists `FiscalYearTable` ; 

/* Creating table */
CREATE Table FiscalYearTable (
				fiscal_year INT(4) NOT NULL,
				start_date DATE NOT NULL,
				end_date DATE NOT NULL,
				CONSTRAINT fy_primary_key PRIMARY KEY (fiscal_year)
			);

/* DROP Triggers */
DROP Trigger if exists `wrongFiscalYear`;
DROP Trigger if exists `startBeforeEnd`;
DROP Trigger if exists `overLap`;

/* select trigger */ 
/*show triggers where `Trigger` like 'wrongFiscalYear%'\G ; */


/* Trigger 1 wrongFiscalYear */

CREATE TRIGGER wrongFiscalYear
BEFORE INSERT ON FiscalYearTable 
FOR EACH ROW 
BEGIN  
	DECLARE msg varchar(200);
	IF (NEW.fiscal_year > 9999)
	THEN 
		set msg = "Please insert a proper fiscal year!";
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg;
	END IF;
END;

/* Insert query */
/*INSERT INTO FiscalYearTable (fiscal_year, start_date, end_date) 
VALUES ('19081', '1981-08-24','1982-08-24');
*/


/* Trigger 2 startBeforeEnd */

CREATE TRIGGER startBeforeEnd
BEFORE INSERT ON FiscalYearTable 
FOR EACH ROW 
BEGIN
	DECLARE msg varchar(200);
	IF (DATEDIFF(NEW.end_date, NEW.start_date) <= 0 )
	THEN 
		set msg = "Start date should be before end date!";
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg;
	END IF;
END;


/* Trigger 3 OverLap */

CREATE TRIGGER overLap
BEFORE INSERT ON FiscalYearTable 
FOR EACH ROW 
BEGIN
	DECLARE msg varchar(200);
	IF( 
		(
			SELECT fiscal_year 
			FROM FiscalYearTable AS FYT
			WHERE 
				(
					DATEDIFF(New.start_date, FYT.start_date) >= 0
					AND 
					DATEDIFF(FYT.end_date, New.start_date) >= 0
				)
				OR
				(
					DATEDIFF(New.end_date, FYT.start_date) >= 0
					AND 
					DATEDIFF(FYT.end_date, New.end_date) >= 0
				)
		) IS NOT NULL
	)
	THEN 
		set msg = "OverLap between Fiscal Years!";
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg;
	END IF;
END



/* Insert query test startBeforeEnd */
INSERT INTO FiscalYearTable (fiscal_year, start_date, end_date) 
VALUES ('2001', '2001-01-20','2001-01-05');



/* Insert query test OverLap */
INSERT INTO FiscalYearTable (fiscal_year, start_date, end_date) 
VALUES ('2001', '2001-01-20','2001-02-20');

INSERT INTO FiscalYearTable (fiscal_year, start_date, end_date) 
VALUES ('2002', '2001-02-01','2001-3-01');




/* Constrains:
*	1. wrongFiscalYear
*	1. startBeforeEnd
*	2. overLap
*
*
*/
