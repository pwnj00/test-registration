CREATE TABLE users
(
  id serial NOT NULL,
  username character varying(255) NOT NULL,
  password character(40) NOT NULL,
  ip inet,
  created integer NOT NULL,
  visited integer NOT NULL,
  CONSTRAINT pk_user_id PRIMARY KEY (id),
  CONSTRAINT user_pass UNIQUE (username, password)
);

CREATE OR REPLACE FUNCTION create_user(u_username varchar, u_password char, u_ip inet, cur_timestamp int)
RETURNS integer AS
$$
INSERT INTO users(username, password, ip, created, visited) VALUES($1, $2, $3, $4, $4)
RETURNING id;
$$
LANGUAGE 'sql' VOLATILE;

CREATE OR REPLACE FUNCTION get_user_id_by_username(u_username varchar)
RETURNS int AS
$$
SELECT id FROM users 
WHERE username = $1;
$$
LANGUAGE 'sql' VOLATILE;

CREATE OR REPLACE FUNCTION auth_user(u_username varchar, u_password char, cur_timestamp integer)
RETURNS TABLE (id int, username varchar, ip inet, created int, visited int) AS
$$
UPDATE users
SET visited = $3
WHERE username = $1 AND password = $2
RETURNING id, username, ip, created, visited
$$
LANGUAGE 'sql' VOLATILE;

CREATE OR REPLACE FUNCTION get_user_by_id(u_id int)
RETURNS TABLE (id int, username varchar, ip inet, created int, visited int) AS
$$
SELECT id, username, ip, created, visited FROM users 
WHERE id = $1;
$$
LANGUAGE 'sql' VOLATILE;
