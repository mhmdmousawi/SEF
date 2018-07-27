
/* Claims Table Creation */
CREATE TABLE `Claims` (
  `claim_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`claim_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/* Defendants Table Creation */
CREATE TABLE `Defendants` (
  `claim_id` int(11) DEFAULT NULL,
  `defendant_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  KEY `fk_Defendants_1_idx` (`claim_id`),
  KEY `index2` (`defendant_name`),
  CONSTRAINT `fk_Defendants_1` FOREIGN KEY (`claim_id`) REFERENCES `Claims` (`claim_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* LegalEvents Table Creation */
CREATE TABLE `LegalEvents` (
  `claim_id` int(11) DEFAULT NULL,
  `defendant_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `claim_status` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `change_date` date DEFAULT NULL,
  KEY `fk_LegalEvents_2_idx` (`defendant_name`),
  KEY `fk_LegalEvents_to_claim_status_idx` (`claim_status`),
  KEY `fk_LegalEvents_to_claims` (`claim_id`),
  CONSTRAINT `fk_LegalEvents_to_claim_status` FOREIGN KEY (`claim_status`) REFERENCES `ClaimStatusCodes` (`claim_status`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_LegalEvents_to_claims` FOREIGN KEY (`claim_id`) REFERENCES `Claims` (`claim_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_LegalEvents_to_defendants` FOREIGN KEY (`defendant_name`) REFERENCES `Defendants` (`defendant_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* ClaimStatusCodes Table Creation */
CREATE TABLE `ClaimStatusCodes` (
  `claim_status` varchar(2) CHARACTER SET utf8 NOT NULL,
  `claim_status_desc` varchar(45) DEFAULT NULL,
  `claim_seq` int(1) DEFAULT NULL,
  PRIMARY KEY (`claim_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- DELETE FROM `LegalMedicalClaimsDB`.`Claims`;
-- DELETE FROM `LegalMedicalClaimsDB`.`Defendants`;
-- DELETE FROM `LegalMedicalClaimsDB`.`ClaimStatusCodes`;
-- DELETE FROM `LegalMedicalClaimsDB`.`LegalEvents`;

/* Claims Table Insertion */
insert into Claims value(1, 'Bassem Dghaidi' );
insert into Claims value(2, 'Omar Breidi'  );
insert into Claims value(3, 'Marwan Sawwan' );

/* Defendants Table Insertion */
INSERT INTO Defendants (claim_id,defendant_name) VALUES(1,'Jean Skaff');
INSERT INTO Defendants (claim_id,defendant_name) VALUES(1,'Elie Meouchi');
INSERT INTO Defendants (claim_id,defendant_name) VALUES(1,'Radwan Sameh');
INSERT INTO Defendants (claim_id,defendant_name) VALUES(2,'Joseph Eid');
INSERT INTO Defendants (claim_id,defendant_name) VALUES(2,'Paul Syoufi');
INSERT INTO Defendants (claim_id,defendant_name) VALUES(2,'Radwan Sameh');
INSERT INTO Defendants (claim_id,defendant_name) VALUES(3,'Issam Awwad');

/* ClaimStatusCodes Table Insertion */
INSERT into ClaimStatusCodes VALUES('AP','Awaiting review panel',1);
INSERT into ClaimStatusCodes VALUES('OR','Panel opinion rendered',2);
INSERT into ClaimStatusCodes VALUES('SF','Suit filed',3);
INSERT into ClaimStatusCodes VALUES('CL','Closed',4);

/* LegalEvents Table Insertion */
insert into LegalEvents values(1 ,'Jean Skaff', 'AP','2016-01-01');
insert into LegalEvents values(1,'Jean Skaff','OR','2016-02-02' );
insert into LegalEvents values(1,'Jean Skaff','SF','2016-03-01');
insert into LegalEvents values( 1,'Jean Skaff','CL','2016-04-01');
insert into LegalEvents values(1,'Radwan Sameh','AP','2016-01-01');
insert into LegalEvents values(1,'Radwan Sameh','OR','2016-02-02');
insert into LegalEvents values(1 ,'Radwan Sameh','SF','2016-03-01');
insert into LegalEvents values(1,'Elie Meouchi','AP','2016-01-01');
insert into LegalEvents values(1,'Elie Meouchi','OR','2016-02-02');
insert into LegalEvents values(2,'Radwan Sameh','AP','2016-01-01');
insert into LegalEvents values(2,'Radwan Sameh','OR','2016-02-01');
insert into LegalEvents values(2,'Paul Syoufi','AP','2016-01-01');
insert into LegalEvents values(3,'Issam Awwad','AP','2016-01-01');

-- trigger before inserting
/*Changes in claim status for each defendant occur in a known sequence, determined by law, as shown in
the ClaimStatusCodes table:*/