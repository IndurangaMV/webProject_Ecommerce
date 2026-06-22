INSERT INTO category (c_name) VALUES
('Development Boards'),
('Sensors'),
('Power Supplies'),
('Transformers'),
('Bulbs'),
('Motors'),
('Displays'),
('Batteries'),
('Measurement Tools'),
('Connectors'),
('Modules'),
('Arduino Accessories');

INSERT INTO product (p_name, price, category, seller_id) VALUES
('Arduino UNO R3',1100,1,3),
('Arduino Mega 2560',2200,1,3),
('NodeMCU ESP8266',950,1,3),
('ESP32 Dev Board',1800,1,3),
('HC-SR04 Ultrasonic Sensor',350,2,3),
('DHT11 Temperature Sensor',250,2,3),
('IR Obstacle Sensor',300,2,3),
('MQ-2 Gas Sensor',450,2,3),
('12V 5A SMPS',1500,3,3),
('12V 10A SMPS',2000,3,3),
('24V 5A Power Supply',2800,3,3),
('220V to 12V Transformer',1800,4,3),
('220V to 24V Transformer',2200,4,3),
('LED Bulb 5W',350,5,3),
('LED Bulb 12W',550,5,3),
('N20 Gear Motor',700,6,3),
('775 DC Motor',1200,6,3),
('16x2 LCD Display',400,7,3),
('18650 Battery',750,8,3),
('Digital Multimeter DT830D',1500,9,3);

INSERT INTO user
(username,password,email,contact_no,gender,user_type,district,address,zip_code,image_id,approval,status)
VALUES
('admin','1234','admin@gmail.com','0711111111',1,1,1,'Colombo','10000',NULL,1,'ACTIVE'),

('seller1','1234','seller1@gmail.com','0712222222',1,2,1,'Colombo','10001',NULL,1,'ACTIVE'),
('seller2','1234','seller2@gmail.com','0713333333',1,2,2,'Gampaha','11000',NULL,1,'ACTIVE'),
('seller3','1234','seller3@gmail.com','0714444444',2,2,3,'Kalutara','12000',NULL,1,'ACTIVE'),

('kamal','1234','kamal@gmail.com','0771234567',1,3,4,'Kandy','20000',NULL,1,'ACTIVE'),
('nimal','1234','nimal@gmail.com','0771234568',1,3,5,'Matale','21000',NULL,1,'ACTIVE'),
('sunil','1234','sunil@gmail.com','0771234569',1,3,6,'Kurunegala','60000',NULL,1,'ACTIVE'),
('amal','1234','amal@gmail.com','0771234570',1,3,7,'Galle','80000',NULL,1,'ACTIVE'),
('saman','1234','saman@gmail.com','0771234571',1,3,8,'Matara','81000',NULL,1,'ACTIVE'),
('kasun','1234','kasun@gmail.com','0771234572',1,3,9,'Badulla','90000',NULL,1,'ACTIVE'),
('tharindu','1234','tharindu@gmail.com','0771234573',1,3,10,'Ratnapura','70000',NULL,1,'ACTIVE'),
('dilshan','1234','dilshan@gmail.com','0771234574',1,3,11,'Jaffna','40000',NULL,1,'ACTIVE'),
('nadeesha','1234','nadeesha@gmail.com','0771234575',2,3,12,'Anuradhapura','50000',NULL,1,'ACTIVE'),
('shehani','1234','shehani@gmail.com','0771234576',2,3,13,'Polonnaruwa','51000',NULL,1,'ACTIVE'),
('sachini','1234','sachini@gmail.com','0771234577',2,3,14,'Hambantota','82000',NULL,1,'ACTIVE');

INSERT INTO product (p_name, price, category, seller_id) VALUES
('LM2596 Buck Converter',250,11,3),
('L298N Motor Driver',450,11,3),
('Servo Motor SG90',550,6,3),
('Jumper Wire Set',300,12,3),
('Breadboard 830 Points',400,12,3),
('Relay Module 2 Channel',450,11,3),
('DS3231 RTC Module',350,11,3),
('MAX7219 LED Matrix Module',600,11,3),
('OLED Display 0.96"',950,7,3),
('INA219 Current Sensor',500,2,3);