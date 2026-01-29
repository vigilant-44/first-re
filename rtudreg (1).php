<?php
// Start the session
session_start();

// Initialize students array in session if not already set
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Handle "Clear All Students" action
if (isset($_POST['clear_all'])) {
    $_SESSION['students'] = []; // Clear the array
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['clear_all'])) {

    // Collect form data
    $name = trim($_POST['name']);
    $reg_no = trim($_POST['reg_no']);
    $gender = $_POST['gender'];
    $course = trim($_POST['course']);
    $year = $_POST['year'];

    // Array to store errors
    $errors = [];

    // Basic validation
    if (empty($name)) {
        $errors[] = "Student name is required.";
    }

    if (empty($reg_no)) {
        $errors[] = "Registration number is required.";
    }

    if (empty($course)) {
        $errors[] = "Course is required.";
    }

    if (empty($year)) {
        $errors[] = "Year of study is required.";
    }

    // If no errors, store student in session array
    if (count($errors) == 0) {
        $_SESSION['students'][] = [
            "name" => $name,
            "reg_no" => $reg_no,
            "gender" => $gender,
            "course" => $course,
            "year" => $year
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            width: 400px;
            margin-bottom: 20px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin: 5px 0 10px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>

<h2>Student Registration Form</h2>

<!-- Display validation errors -->
<?php
if (!empty($errors)) {
    echo "<div class='error'><ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul></div>";
}
?>

<form method="POST" action="">
    <label>Student Name</label>
    <input type="text" name="name">

    <label>Registration Number</label>
    <input type="text" name="reg_no">

    <label>Gender</label>
    <select name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>

    <label>Course</label>
    <input type="text" name="course">

    <label>Year of Study</label>
    <select name="year">
        <option value="">Select Year</option>
        <option value="1">Year 1</option>
        <option value="2">Year 2</option>
        <option value="3">Year 3</option>
        <option value="4">Year 4</option>
    </select>

    <input type="submit" value="Register Student">
</form>

<!-- Clear All Students Button -->
<form method="POST" action="">
    <button type="submit" name="clear_all">Clear All Students</button>
</form>

<h2>Registered Students</h2>

<?php if (!empty($_SESSION['students'])) : ?>
<table>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Reg No</th>
        <th>Gender</th>
        <th>Course</th>
        <th>Year</th>
    </tr>

    <?php
    $count = 1;
    foreach ($_SESSION['students'] as $student) {
        echo "<tr>";
        echo "<td>" . $count++ . "</td>";
        echo "<td>" . $student['name'] . "</td>";
        echo "<td>" . $student['reg_no'] . "</td>";
        echo "<td>" . $student['gender'] . "</td>";
        echo "<td>" . $student['course'] . "</td>";
        echo "<td>" . $student['year'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<p><strong>Total Students:</strong> <?php echo count($_SESSION['students']); ?></p>

<?php else: ?>
<p>No students registered yet.</p>
<?php endif; ?>

</body>
</html>
