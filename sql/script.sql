CREATE TABLE `system_wejsc_i_wyjsc_klientow_w_galerii`.`inputs_outputs` (`id` INT NOT NULL AUTO_INCREMENT , `datetime` DATETIME NOT NULL , `direction` BOOLEAN NOT NULL , `camera_number` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `system_wejsc_i_wyjsc_klientow_w_galerii`.`inputs_outputs_hours` (`id` INT NOT NULL AUTO_INCREMENT , `date` DATE NOT NULL , `hour` TINYINT UNSIGNED NOT NULL , `input` INT UNSIGNED NOT NULL , `output` INT UNSIGNED NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
