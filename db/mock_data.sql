CREATE TABLE user_accounts (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	password TEXT,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE mock_data (
	id INT AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(50),
	last_name VARCHAR(50),
	email VARCHAR(50),
	gender VARCHAR(50)
);

INSERT INTO mock_data (id, first_name, last_name, email, gender) VALUES 
(1, 'Olvan', 'Jumel', 'ojumel0@google.cn', 'Male'),
(2, 'Reeta', 'Curgenven', 'rcurgenven1@1und1.de', 'Female'),
(3, 'Lucius', 'Faherty', 'lfaherty2@linkedin.com', 'Male'),
(4, 'Pooh', 'Batrip', 'pbatrip3@cdbaby.com', 'Male'),
(5, 'Hercule', 'Shakespear', 'hshakespear4@sitemeter.com', 'Male'),
(6, 'Verney', 'Berks', 'vberks5@nbcnews.com', 'Male'),
(7, 'Zandra', 'Blacklawe', 'zblacklawe6@alibaba.com', 'Female'),
(8, 'Sybilla', 'Pirrone', 'spirrone7@yellowbook.com', 'Female'),
(9, 'Trefor', 'Brimilcombe', 'tbrimilcombe8@reference.com', 'Male'),
(10, 'Felizio', 'Gittus', 'fgittus9@networkadvertising.org', 'Male');
