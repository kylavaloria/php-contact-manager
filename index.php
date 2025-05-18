<?php
require 'connection.php';
$connect = Connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col">
                <h2>Contact Manager</h2>
            </div>
            <div class="col-auto">
                <a href="add.php" class="btn btn-primary">Add New Contact</a>
            </div>
        </div>

        <?php
        // Display success message if set
        if(isset($_GET['success'])) {
            echo '<div class="alert alert-success" role="alert">';
            if($_GET['success'] == 'added') {
                echo 'Contact added successfully!';
            } else if($_GET['success'] == 'updated') {
                echo 'Contact updated successfully!';
            } else if($_GET['success'] == 'deleted') {
                echo 'Contact deleted successfully!';
            }
            echo '</div>';
        }
        ?>

        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $query = "SELECT * FROM contacts ORDER BY name ASC";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                    $i = 1;

                    if($result) {
                        foreach($result as $row) {
                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= htmlspecialchars($row->name); ?></td>
                    <td><?= htmlspecialchars($row->email); ?></td>
                    <td><?= htmlspecialchars($row->phone); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row->id; ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                    </td>
                </tr>
                <?php
                        }
                    } else {
                ?>
                <tr>
                    <td colspan="5" class="text-center">No contacts found</td>
                </tr>
                <?php
                    }
                } catch(PDOException $e) {
                    echo '<tr><td colspan="5" class="text-danger">Error: ' . $e->getMessage() . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
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
</body>
</html>
