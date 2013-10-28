CREATE TABLE sconnect_user (
  user_id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(30),
  last_name VARCHAR(30),
  student_id VARCHAR(20),
  login_pwd VARCHAR(32),
  contact_email VARCHAR(40),
  contact_phone VARCHAR(20),
  PRIMARY KEY(user_id)
);