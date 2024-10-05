<?php
include 'db_connect.php'; // Include your database connection script

// Check if ID is provided and numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Query to fetch employee details
    $sql = "SELECT
                e.employee_id AS employee_id,
                e.first_name AS first_name,
                e.last_name AS last_name,
                e.email AS email,
                d.department_name AS department_name,
                p.project_name AS project_name,
                t.task_name AS task_name
            FROM employee e
            LEFT JOIN department d ON e.department_id = d.department_id
            LEFT JOIN task t ON e.employee_id = t.assigned_to
            LEFT JOIN project p ON t.project_id = p.project_id
            WHERE e.employee_id = $employee_id";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Extract data from $row for use in form
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $department = $row['department_name'];
        $project = $row['project_name'];
        $task = $row['task_name'];
    } else {
        // Handle case where no employee with provided ID is found
        echo "Employee not found";
        exit;
    }
} else {
    // Handle case where ID is not provided or not valid
    echo "Invalid employee ID";
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>SUBWAY</title>
    <style>
        .text-white-bold {
            color: white;
            font-weight: 750;
        }
    </style>
</head>

<body style="background-color: #006989;">
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5 text-white-bold">
        Employee Form
    </nav>
    <div class="container">
        <div class="text-center mb-4 text-white">
            <h3>Edit Employee</h3>
            <p class="text-white">Complete the Form to edit new Employee</p>
        </div>

        <div class="container d-flex justify-content-center">
        <form action="update_employee.php" method="post" style="width: 50vw; min-width: 200px; background-color: #005C78; border-radius: 10px; padding: 20px;">
    <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
    <div class="row mb-3">
        <div class="col">
            <label class="form-label text-center text-white">First Name:</label>
            <input type="text" class="form-control" name="firstName" value="<?php echo $first_name; ?>">
        </div>
        <div class="col">
            <label class="form-label text-center text-white">Last Name:</label>
            <input type="text" class="form-control" name="lastName" value="<?php echo $last_name; ?>">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label text-center text-white">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label text-center text-white">Department:</label>
        <select class="form-control" name="department" id="department">
            <option value="<?php echo $department; ?>" selected><?php echo $department; ?></option>
            <!-- Options will be dynamically populated by JavaScript -->
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label text-center text-white">Project:</label>
        <select class="form-control" name="project" id="project">
            <option value="<?php echo $project; ?>" selected><?php echo $project; ?></option>
            <!-- Options will be dynamically populated by JavaScript -->
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label text-center text-white">Task:</label>
        <select class="form-control" name="task" id="task">
            <option value="<?php echo $task; ?>" selected><?php echo $task; ?></option>
            <!-- Options will be dynamically populated by JavaScript -->
        </select>
    </div>
    <div>
        <button type="submit" class="btn btn-success" name="submit">Save</button>
        <a href="employee_list.php" class="btn btn-danger">Cancel</a>
    </div>
</form>
            </form>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    const departmentSelect = document.getElementById("department");
    const projectSelect = document.getElementById("project");
    const taskSelect = document.getElementById("task");

    // Define the options for each department
    const departmentOptions = {
        IT: {
            projects: ["Application", "Campaign"],
            tasks: ["Layout Design", "Planning"]
        },
        'Human Resource': {
            projects: ["Training Sessions"],
            tasks: ["Trainer"]
        },
        Marketing: {
            projects: ["Feedback"],
            tasks: ["Planning"]
        },
        Sales: {
            projects: ["Sales Training"],
            tasks: ["Trainer"]
        },
        'Customer Service': {
            projects: ["Feedback"],
            tasks: ["Layout Design"]
        }
    };

    // Function to populate department options
    function populateDepartmentOptions() {
        // Clear existing options
        departmentSelect.innerHTML = '';

        // Add default option
        const defaultOption = document.createElement("option");
        defaultOption.text = 'Select Department';
        defaultOption.disabled = true;
        departmentSelect.appendChild(defaultOption);

        // Add options for each department
        Object.keys(departmentOptions).forEach(key => {
            const option = document.createElement("option");
            option.text = key;
            option.value = key;
            departmentSelect.appendChild(option);
        });
    }

    // Function to update project and task options based on selected department
    function updateOptions() {
        const selectedDepartment = departmentSelect.value;
        const { projects, tasks } = departmentOptions[selectedDepartment] || { projects: [], tasks: [] };

        // Clear existing options
        projectSelect.innerHTML = '<option value="" selected disabled>Select Project</option>';
        taskSelect.innerHTML = '<option value="" selected disabled>Select Task</option>';

        // Add new options
        projects.forEach(project => {
            const option = document.createElement("option");
            option.text = project;
            option.value = project;
            projectSelect.appendChild(option);
        });

        tasks.forEach(task => {
            const option = document.createElement("option");
            option.text = task;
            option.value = task;
            taskSelect.appendChild(option);
        });
    }

    // Initial call to populate department options
    populateDepartmentOptions();

    // Event listener for department select change
    departmentSelect.addEventListener("change", updateOptions);
});

</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>


</html>