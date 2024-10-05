<?php
// Include your database connection script
include 'db_connect.php';

// Check if ID is provided and numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // 1. Delete associated tasks
        $delete_tasks_sql = "DELETE FROM task WHERE assigned_to = ?";
        $stmt_tasks = $conn->prepare($delete_tasks_sql);
        $stmt_tasks->bind_param("i", $employee_id);
        $stmt_tasks->execute();
        $stmt_tasks->close();

        // 2. Delete employee record
        $delete_employee_sql = "DELETE FROM employee WHERE employee_id = ?";
        $stmt_employee = $conn->prepare($delete_employee_sql);
        $stmt_employee->bind_param("i", $employee_id);
        $stmt_employee->execute();
        $stmt_employee->close();

        // 3. Delete associated department (if any)
        $delete_department_sql = "DELETE FROM department WHERE department_id = ?";
        $stmt_department = $conn->prepare($delete_department_sql);
        $stmt_department->bind_param("i", $employee_id);
        $stmt_department->execute();
        $stmt_department->close();

        // 4. Delete associated projects (if any)
        $delete_projects_sql = "DELETE FROM project WHERE project_id = ?";
        $stmt_projects = $conn->prepare($delete_projects_sql);
        $stmt_projects->bind_param("i", $employee_id);
        $stmt_projects->execute();
        $stmt_projects->close();
        // Optionally reset auto-increment values
        $reset_tables = ['employee', 'department', 'project', 'task'];
        foreach ($reset_tables as $table) {
            $reset_auto_increment_sql = "ALTER TABLE $table AUTO_INCREMENT = 1";
            $conn->query($reset_auto_increment_sql);
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to employee list with success message
        header('Location: employee_list.php?msg=Employee, associated tasks, department, and projects deleted successfully');
        exit;
    } catch (Exception $e) {
        // Rollback the transaction if any errors occurred
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle case where ID is missing or not numeric
    echo "Invalid employee ID";
    exit;
}