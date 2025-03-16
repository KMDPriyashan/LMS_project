<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Default WAMP username
$password = "";      // Default WAMP password is empty
$dbname = "lms_system";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Create necessary tables if they don't exist
$sql_courses = "CREATE TABLE IF NOT EXISTS courses (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(10) NOT NULL UNIQUE,
    course_title VARCHAR(255) NOT NULL,
    description TEXT,
    credits INT(1) NOT NULL,
    department VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sql_students = "CREATE TABLE IF NOT EXISTS students (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    date_of_birth DATE,
    phone VARCHAR(20),
    program VARCHAR(50) NOT NULL,
    enrollment_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sql_instructors = "CREATE TABLE IF NOT EXISTS instructors (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    instructor_id VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    department VARCHAR(50) NOT NULL,
    position VARCHAR(50) NOT NULL,
    hire_date DATE NOT NULL,
    specialization_areas TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sql_enrollments = "CREATE TABLE IF NOT EXISTS enrollments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    enrollment_id VARCHAR(20) NOT NULL UNIQUE,
    student_id VARCHAR(20) NOT NULL,
    course_code VARCHAR(10) NOT NULL,
    enrollment_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL,
    grade VARCHAR(5),
    completion_date DATE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_code) REFERENCES courses(course_code) ON DELETE CASCADE
)";

if ($conn->query($sql_courses) !== TRUE) {
    die("Error creating courses table: " . $conn->error);
}

if ($conn->query($sql_students) !== TRUE) {
    die("Error creating students table: " . $conn->error);
}

if ($conn->query($sql_instructors) !== TRUE) {
    die("Error creating instructors table: " . $conn->error);
}

if ($conn->query($sql_enrollments) !== TRUE) {
    die("Error creating enrollments table: " . $conn->error);
}
