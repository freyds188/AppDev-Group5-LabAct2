<?php
include 'db_connect.php'; // Include your database connection script

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the employee ID from the form
    $employee_id = $_POST['employee_id'];
    
    // Get other fields from the form
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $project = $_POST['project'];
    $task = $_POST['task'];

    // Validate inputs (you can add more validations as needed)
    if (empty($first_name) || empty($last_name) || empty($email) || empty($department) || empty($project) || empty($task)) {
        echo "All fields are required.";
        exit;
    }

    // Update employee information in the database
    // Adjust the SQL query according to your table structure
    $sql = "UPDATE employee 
            SET first_name = ?, last_name = ?, email = ?, department_id = (SELECT department_id FROM department WHERE department_name = ?)
            WHERE employee_id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $department, $employee_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to employee list page after successful update
            header("Location: employee_list.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
