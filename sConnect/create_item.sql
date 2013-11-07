CREATE TABLE sconnect_item (
  id INT NOT NULL AUTO_INCREMENT,
  date_posted DATETIME,
  date_sold DATETIME, 
  title VARCHAR(100),
  description TEXT,
  price FLOAT(5,2),
  seller_user_id INT,
  buyer_user_id INT,
  PRIMARY KEY(id)
);
  
CREATE TABLE sconnect_service (
  id INT NOT NULL AUTO_INCREMENT,
  date_posted DATETIME,
  title VARCHAR(100),
  description TEXT,
  seller_user_id INT,
  PRIMARY KEY(id)
);
