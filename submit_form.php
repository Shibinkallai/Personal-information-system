<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Leave empty if there's no password
$dbname = "registration_form";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form fields
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $institution = $_POST['institution'];
    $degree = $_POST['degree'];
    $graduationYear = $_POST['graduation_year'];
    $company = $_POST['company'];
    $position = $_POST['position'];
    $yearsService = $_POST['years_service'];
    $contactName = $_POST['contact_name'];
    $relationship = $_POST['relationship'];
    $contactPhone = $_POST['contact_phone'];

    $photoPath = '';
    if (isset($_FILES['upload_doc']) && $_FILES['upload_doc']['error'] == 0) {
        $uploadDir = 'uploads/';
        $photoName = basename($_FILES['upload_doc']['name']);
        $photoPath = $uploadDir . $photoName;

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['upload_doc']['tmp_name'], $photoPath)) {
            echo "File uploaded successfully!";
        } else {
            echo "Error uploading file.";
        }
    }

    // Insert data into database
    $sql = "INSERT INTO users (firstname, lastname, email, phone, city, institution, degree, graduation_year, company, position, years_service, contact_name, relationship, contact_phone, photo_path)
            VALUES ('$firstname', '$lastname', '$email', '$phone', '$city', '$institution', '$degree', '$graduationYear', '$company', '$position', '$yearsService', '$contactName', '$relationship', '$contactPhone', '$photoPath')";

    if ($conn->query($sql) === TRUE) {
        echo "Form submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
