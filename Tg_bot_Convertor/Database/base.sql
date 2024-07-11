CREATE TABLE convertor (
    id INT AUTO_INCREMENT,
    UserId BIGINT,
    convertation TEXT,
    amount TEXT,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

INSERT INTO convertor (UserId, convertation, amount)
VALUES (3325687, 'usd2uzs', '500000');