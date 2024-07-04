CREATE TABLE daily (
    id INT AUTO_INCREMENT PRIMARY KEY,
    arrived_at DATETIME,
    leaved_at DATETIME,
    required_work INT,
    worked_off INT
);