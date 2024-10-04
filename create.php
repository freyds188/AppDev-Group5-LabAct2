<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Employee Management System</title>
    <style>
        .text-white-bold {
            color: white;
            font-weight: 750;
        }
    </style>
</head>

<body style="background-color: #006989;">
    <nav class="navbar navbar-light justify-content-center fs-2 mt-5 mb-5 text-white-bold">
        Employee Form
    </nav>
    <div class="container">
        <div class="text-center mt-5 mb-3 text-white">
            <h3>Add New Employee</h3>
            <p class="text-white">Complete the Form to Add new Employee</p>
        </div>
        <div class="container d-flex justify-content-center">
            <form action="submit_form.php" method="post" style="width: 50vw; min-width: 200px; background-color: #005C78; border-radius: 10px; padding: 20px;">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label text-center text-white">First Name:</label>
                        <input type="text" class="form-control" name="firstName" placeholder="Daniel">
                    </div>
                    <div class="col">
                        <label class="form-label text-center text-white">Last Name:</label>
                        <input type="text" class="form-control" name="lastName" placeholder="Remero">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-center text-white">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="abczxc@gmail.com">
                </div>
                <div class="mb-3">
                    <label class="form-label text-center text-white">Department:</label>
                    <select class="form-control" name="department" id="department">
                        <option value="" selected disabled>Select Department</option>
                        <option value="IT">IT</option>
                        <option value="Human Resource">Human Resource</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Sales">Sales</option>
                        <option value="Customer Service">Customer Service</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-center text-white">Project:</label>
                    <select class="form-control" name="project" id="project">
                        <option value="" selected disabled>Select Project</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-center text-white">Task:</label>
                    <select class="form-control" name="task" id="task">
                        <option value="" selected disabled>Select Task</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-success" name="submit">Save</button>
                    <a href="employee_list.php" class="btn btn-dark">List</a>
                    <a href="index.php" class="btn btn-danger">Logout</a> <!-- Logout button -->
                </div>
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
            // Function to update project and task options based on selected department
            function updateOptions() {
                const selectedDepartment = departmentSelect.value;
                const {
                    projects,
                    tasks
                } = departmentOptions[selectedDepartment] || {
                    projects: [],
                    tasks: []
                };
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
            // Initial call to populate options based on default department select value
            updateOptions();
            // Event listener for department select change
            departmentSelect.addEventListener("change", updateOptions);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
