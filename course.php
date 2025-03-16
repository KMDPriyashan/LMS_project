<?php
// Include database configuration
require_once 'db_config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize inputs
    $course_code = mysqli_real_escape_string($conn, $_POST['courseCode']);
    $course_title = mysqli_real_escape_string($conn, $_POST['courseTitle']);
    $description = mysqli_real_escape_string($conn, $_POST['courseDescription']);
    $credits = intval($_POST['courseCredits']);
    $department = mysqli_real_escape_string($conn, $_POST['courseDepartment']);
    $start_date = mysqli_real_escape_string($conn, $_POST['courseStartDate']);
    $end_date = mysqli_real_escape_string($conn, $_POST['courseEndDate']);
    $status = mysqli_real_escape_string($conn, $_POST['courseStatus']);

    // Validate required fields
    if (
        empty($course_code) || empty($course_title) || empty($credits) ||
        empty($department) || empty($start_date) || empty($end_date) || empty($status)
    ) {
        echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled']);
        exit;
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO courses (course_code, course_title, description, credits, department, start_date, end_date, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisiss", $course_code, $course_title, $description, $credits, $department, $start_date, $end_date, $status);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Course added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
    }

    // Close statement
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close database connection
$conn->close();
