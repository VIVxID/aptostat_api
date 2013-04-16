
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- Report
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Report`;

CREATE TABLE `Report`
(
    `IdReport` INTEGER NOT NULL AUTO_INCREMENT,
    `Timestamp` DATETIME NOT NULL,
    `ErrorMessage` VARCHAR(255) NOT NULL,
    `CheckType` VARCHAR(40) NOT NULL,
    `Source` VARCHAR(255) NOT NULL,
    `IdService` INTEGER NOT NULL,
    `Hidden` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`IdReport`),
    INDEX `Report_FI_1` (`IdService`),
    CONSTRAINT `Report_FK_1`
        FOREIGN KEY (`IdService`)
        REFERENCES `Service` (`IdService`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Service
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Service`;

CREATE TABLE `Service`
(
    `IdService` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`IdService`),
    UNIQUE INDEX `Service_U_1` (`Name`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Incident
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Incident`;

CREATE TABLE `Incident`
(
    `IdIncident` INTEGER NOT NULL AUTO_INCREMENT,
    `Title` VARCHAR(255) NOT NULL,
    `Timestamp` DATETIME NOT NULL,
    PRIMARY KEY (`IdIncident`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Message
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Message`;

CREATE TABLE `Message`
(
    `IdMessage` INTEGER NOT NULL AUTO_INCREMENT,
    `IdIncident` INTEGER NOT NULL,
    `Flag` VARCHAR(255) NOT NULL,
    `Timestamp` DATETIME NOT NULL,
    `Text` VARCHAR(255) NOT NULL,
    `Author` VARCHAR(30) NOT NULL,
    `Hidden` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`IdMessage`),
    INDEX `Message_FI_1` (`IdIncident`),
    CONSTRAINT `Message_FK_1`
        FOREIGN KEY (`IdIncident`)
        REFERENCES `Incident` (`IdIncident`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- ReportStatus
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ReportStatus`;

CREATE TABLE `ReportStatus`
(
    `IdReport` INTEGER NOT NULL,
    `Timestamp` DATETIME NOT NULL,
    `Flag` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`IdReport`,`Timestamp`),
    CONSTRAINT `ReportStatus_FK_1`
        FOREIGN KEY (`IdReport`)
        REFERENCES `Report` (`IdReport`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- IncidentReport
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `IncidentReport`;

CREATE TABLE `IncidentReport`
(
    `IdIncident` INTEGER NOT NULL,
    `IdReport` INTEGER NOT NULL,
    PRIMARY KEY (`IdIncident`,`IdReport`),
    INDEX `IncidentReport_FI_1` (`IdReport`),
    CONSTRAINT `IncidentReport_FK_1`
        FOREIGN KEY (`IdReport`)
        REFERENCES `Report` (`IdReport`)
        ON DELETE CASCADE,
    CONSTRAINT `IncidentReport_FK_2`
        FOREIGN KEY (`IdIncident`)
        REFERENCES `Incident` (`IdIncident`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
