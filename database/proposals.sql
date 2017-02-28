PRAGMA foreign_keys = on;

DROP TABLE IF EXISTS Proposals;
DROP TABLE IF EXISTS Admins;

CREATE TABLE Admins (
  username VARCHAR PRIMARY KEY,
  password VARCHAR
);

CREATE TABLE Proposals (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	title VARCHAR,
	author VARCHAR,
	description VARCHAR,
	date DATE,
	validation INTEGER,
	nVotes INTEGER
);