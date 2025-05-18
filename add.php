<?php
require 'connection.php';
$connect = Connect();

// Process form submission
if(isset($_POST['submit'])) {
    try {
        // Sanitize and validate inputs
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

        // If no errors, proceed with insertion
        if(empty($errors)) {
            $query = "INSERT INTO contacts (name, email, phone) VALUES (:name, :email, :phone)";
            $statement = $connect->prepare($query);

            $data = [
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone
            ];

            $statement->execute($data);

            // Redirect to index with success message
            header('Location: index.php?success=added');
            exit;
        }
    } catch(PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Contact</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col">
                <h2>Add New Contact</h2>
            </div>
            <div class="col-auto">
                <a href="index.php" class="btn btn-secondary">Back to Contacts</a>
            </div>
        </div>

        <?php
        // Display any errors
        if(!empty($errors)) {
            echo '<div class="alert alert-danger" role="alert">';
            echo '<ul class="mb-0">';
            foreach($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }

        // Display database error if any
        if(isset($error_message)) {
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        }
        ?>

        <form method="POST" action="add.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?= isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                <small class="text-danger" id="nameError"></small>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                <small class="text-danger" id="emailError"></small>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone"
                       value="<?= isset($phone) ? htmlspecialchars($phone) : ''; ?>" required>
                <small class="text-danger" id="phoneError"></small>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Save Contact</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let phone = document.getElementById('phone').value;
        let isValid = true;

        // Clear previous error messages
        document.getElementById('nameError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('phoneError').textContent = '';

        if (name.length > 100) {
            document.getElementById('nameError').textContent = 'Name must not exceed 100 characters.';
            isValid = false;
        }

        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
            isValid = false;
        }

        if (phone.length > 20) {
            document.getElementById('phoneError').textContent = 'Phone number must not exceed 20 characters.';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
    </script>
</body>
</html>
