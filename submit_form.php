<?php
include 'db_connect.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $project = mysqli_real_escape_string($conn, $_POST['project']);
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    // Start a transaction for data integrity
    mysqli_autocommit($conn, false);
    // Insert data into department table if not already exists
    $departmentId = null;
    $sqlDepartment = "SELECT department_id FROM department WHERE 
department_name = '$department'";
    $resultDepartment = $conn->query($sqlDepartment);
    if ($resultDepartment->num_rows > 0) {
        $row = $resultDepartment->fetch_assoc();
        $departmentId = $row['department_id'];
    } else {
        $sqlInsertDepartment = "INSERT INTO department (department_name) 
VALUES ('$department')";
        if ($conn->query($sqlInsertDepartment)) {
            $departmentId = $conn->insert_id;
        } else {
            mysqli_rollback($conn);
            header("Location: add.php?msg=Error inserting department: " . $conn->error);
            exit();
        }
    }
    // Insert data into project table if not already exists
    $projectId = null;
    $sqlProject = "SELECT project_id FROM project WHERE project_name = '$project'";
    $resultProject = $conn->query($sqlProject);
    if ($resultProject->num_rows > 0) {
        $row = $resultProject->fetch_assoc();
        $projectId = $row['project_id'];
    } else {
        $sqlInsertProject = "INSERT INTO project (project_name) VALUES ('$project')";
        if ($conn->query($sqlInsertProject)) {
            $projectId = $conn->insert_id;
        } else {
            mysqli_rollback($conn);
            header("Location: add.php?msg=Error inserting project: " . $conn->error);
            exit();
        }
    }
    // Insert data into employee table
    $sqlInsertEmployee = "INSERT INTO employee (first_name, last_name, email, department_id)
    VALUES ('$firstName', '$lastName', '$email', '$departmentId')";
    if ($conn->query($sqlInsertEmployee)) {
        $employeeId = $conn->insert_id;
        // Optionally, insert into task table if needed
        if (!empty($task)) {
            $sqlInsertTask = "INSERT INTO task (task_name, project_id, assigned_to)
                              VALUES ('$task', '$projectId', '$employeeId')";
            if (!$conn->query($sqlInsertTask)) {
                mysqli_rollback($conn);
                header("Location: add.php?msg=Error inserting task: " .
                    $conn->error);
                exit();
            }
        }
        // Commit transaction if all queries succeed
        mysqli_commit($conn);
        // Redirect to employee_list.php with success message
        header("Location: employee_list.php?msg=Employee added successfully");
        exit();
    } else {
        mysqli_rollback($conn);
        // Redirect to add.php with error message
        header("Location: add.php?msg=Error inserting employee: " . $conn->error);
        exit();
    }
} else {
    // Redirect to add.php if form was not submitted properly
    header("Location: add.php?msg=Form submission error");
    exit();
}
$conn->close();
