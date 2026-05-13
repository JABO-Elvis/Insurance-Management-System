
CREATE DATABASE IF NOT EXISTS FinalExam2026;
USE FinalExam2026;

-- Create the Logger2026 table
CREATE TABLE Logger2026 (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);

-- Insert two test users to login with
INSERT INTO Logger2026 (username, password) VALUES ('admin', '1234');
INSERT INTO Logger2026 (username, password) VALUES ('student', 'pass123');


-- =============================================
-- STEP 2: CREATE DATABASE FOR QUESTION 2
-- =============================================
CREATE DATABASE DBGroupA2026;
USE DBGroupA2026;

-- Create the Fees2026 table with 10 fields
CREATE TABLE IF NOT EXISTS Fees2026 (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    student_name      VARCHAR(150) NOT NULL,
    student_id        VARCHAR(50)  NOT NULL,
    academic_year     VARCHAR(20),
    no_of_courses     INT,
    total_credits     INT,
    amount_per_credit DECIMAL(10,2),
    registration_fees DECIMAL(10,2),
    final_project     DECIMAL(10,2),
    graduation_fees   DECIMAL(10,2),
    total_fees        DECIMAL(10,2)
);
