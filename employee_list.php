<?php
include 'db_connect.php'; // Include database connection

// Initialize search term
$searchTerm = '';

// Check if search form is submitted
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
}

// Query to fetch employees, optionally filtered by search term
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
        WHERE e.first_name LIKE '%$searchTerm%' 
           OR e.last_name LIKE '%$searchTerm%'
           OR e.email LIKE '%$searchTerm%'
           OR d.department_name LIKE '%$searchTerm%'
           OR p.project_name LIKE '%$searchTerm%'
           OR t.task_name LIKE '%$searchTerm%'
        ORDER BY e.employee_id";

// Execute query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #006989, #003f5c);
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .navbar {
            background: linear-gradient(90deg, #007bff, #00aaff);
            color: #fff;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #fff;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #00aaff);
            border: none;
            padding: 10px 20px;
            font-weight: 500;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #007bff);
            transform: translateY(-2px);
        }

        .btn-success:hover, .btn-danger:hover {
            opacity: 0.8;
        }

        .container {
            margin-top: 50px;
            position: relative;
        }

        h3, h4 {
            color: #fff;
            font-weight: 600;
        }

        .search-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .form-control {
            width: 100%;
            max-width: 350px;
            border-radius: 20px;
            padding: 10px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
        }

        .table {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.2);
        }

        .table td, .table th {
            padding: 16px;
            text-align: center;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.1);
            color: white;
        }
    </style>
    <title>Employee List</title>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5 text-white">
        Employee List and Search
    </nav>

    <div class="container">
        <!-- Add Employee Button in Top Right Corner -->
        <a href="create.php" class="btn btn-primary" style="position: absolute; top: 20px; right: 30px;">Add Employee</a>

        <div class="text-center mb-4">
            <h3 class="text-white">Search Employee</h3>
            <form action="employee_list.php" method="POST" class="search-container">
                <input type="text" name="searchTerm" value="<?php echo $searchTerm; ?>" placeholder="Search by name, email, department..." class="form-control">
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="text-white mb-4">
            <h4>Employee List</h4>
            <table class="table table-bordered table-striped text-white table-hover">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['employee_id']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['department_name']; ?></td>
                                <td><?php echo $row['project_name']; ?></td>
                                <td><?php echo $row['task_name']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['employee_id']; ?>" class="btn btn-success">Edit</a>
                                    <a href="delete.php?id=<?php echo $row['employee_id']; ?>" class="btn btn-danger" onclick="return confirmDelete();">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-white">No employees found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> Employee Management System
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this employee? This action cannot be undone.");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>
