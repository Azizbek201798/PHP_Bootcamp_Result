CREATE TABLE usersinfo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_chat_id INT,
  user_convertion_type VARCHAR(255),
  user_amount DECIMAL(10, 2),
  user_data_time DATETIME
);

INSERT INTO convertor (UserId, convertation, amount)
VALUES (3325687, 'usd2uzs', '500000');

CREATE TABLE saveuser (
  user_chat_id INT,
  user_callback_data VARCHAR(255),
  user_data_time DATETIME
);