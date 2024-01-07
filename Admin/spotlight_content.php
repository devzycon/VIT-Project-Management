<?php
include 'inc/header.php';
Session::CheckSession();

$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
    echo $logMsg;
}
$msg = Session::get('msg');
if (isset($msg)) {
    echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);

$host = "localhost";
$dbname = "db_admin";
$username = "root";
$password = "";

try {
    // Create a new PDO connection
    $your_pdo_connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $your_pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the error
    error_log("PDO Error: " . $e->getMessage());

    // Set appropriate HTTP status code
    http_response_code(500);

    // Echo the error message
    echo 'Error during PDO operation.';
    exit;
}

$spotlightData = $your_pdo_connection->query("SELECT * FROM spotlight")->fetchAll(PDO::FETCH_OBJ);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['description'])) {
    // Handle form data from the form
    $title = $_POST['title'];
    $description = $_POST['description'];

    try {
        $mysqli = new mysqli($host, $username, $password, $dbname);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        // Escape the values to prevent SQL injection
        $title = $mysqli->real_escape_string($title);
        $description = $mysqli->real_escape_string($description);

        // Prepare and execute the SQL statement
        $result = $mysqli->query("INSERT INTO spotlight (title, description) VALUES ('$title', '$description')");

        // Check for errors
        if (!$result) {
            var_dump($mysqli->error);  // Output detailed error information
            die("Error during SQL execution: " . $mysqli->error);
        }

        // Close the connection
        $mysqli->close();

        // Redirect to spotlight_content.php after successful insertion
        header('Location: spotlight_content.php');
        exit;
    } catch (Exception $e) {
        // Log the error
        error_log("Exception: " . $e->getMessage());

        // Set appropriate HTTP status code
        http_response_code(500);

        // Echo the error message
        echo 'Exception during processing: ' . $e->getMessage();
        exit;
    }
}
?>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
function addItem() {
    // Get title and description from the form
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;

    // Check if title and description are not empty
    if (title.trim() === '' || description.trim() === '') {
        console.error('Title and description are required.');
        return;
    }

    // Update the URL to point to the new PHP file
    fetch('add_spotlight_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'title': title,
            'description': description,
            'submit': 'submit'
        }),
    })
    .then(response => {
        // Check if the response is valid JSON
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();  // This line parses the JSON asynchronously
    })
    .then(data => {
        // Handle the received data
        console.log('Received data:', data);

        // Log to check if it reaches this point
        console.log('Updating table...');

        // You can perform additional actions based on the data received
    })
    .catch(error => {
        // Handle fetch or network errors, or the case where the response is not valid JSON
        console.error('Error during the fetch request:', error);
    });
}
function deleteItem(itemId) {
    // Send a request to delete_spotlight_item.php
    fetch('delete_spotlight_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'itemId': itemId,
        }),
    })
    .then(response => {
        // Check if the response is valid JSON
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();  // Parse the JSON asynchronously
    })
    .then(data => {
        // Handle the received data
        console.log('Received data:', data);

        // Log to check if it reaches this point
        console.log('Updating table...');

        // Remove the deleted item from the table
        var itemRow = document.getElementById('itemRow-' + itemId);
        if (itemRow) {
            itemRow.remove();
        }

        // Reload the page after deletion
        location.reload();
    })
    .catch(error => {
        // Handle fetch or network errors, or the case where the response is not valid JSON
        console.error('Error during the fetch request:', error);
    });
}

</script>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-lightbulb mr-2"></i>Spotlight Items</h3>
    </div>

    <div class="card-body pr-2 pl-2">
    <!-- Display existing spotlight items -->
        <table class="table table-striped table-bordered" style="width:100%" id="spotlightTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($spotlightData as $item): ?>
                    <tr id="itemRow-<?php echo $item->id; ?>">
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo $item->description; ?></td>
                        <td>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal<?php echo $item->id; ?>">Delete</button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editItemModal<?php echo $item->id; ?>">Edit</button>
                        </td>
                    </tr>
                <!-- Modal for confirmation before deletion -->
                <div class="modal fade" id="deleteItemModal<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteItemModalLabel<?php echo $item->id; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteItemModalLabel<?php echo $item->id; ?>">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this item?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" onclick="deleteItem(<?php echo $item->id; ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for editing item -->
                <div class="modal fade" id="editItemModal<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel<?php echo $item->id; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editItemModalLabel<?php echo $item->id; ?>">Edit Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Form for editing item -->
                                <form method="POST" action="edit_spotlight_item.php">
                                    <input type="hidden" name="itemId" value="<?php echo $item->id; ?>">
                                    <div class="form-group">
                                        <label for="editTitle">Title:</label>
                                        <input type="text" class="form-control" id="editTitle" name="editTitle" value="<?php echo $item->title; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editDescription">Description:</label>
                                        <textarea class="form-control" id="editDescription" name="editDescription" rows="3" required><?php echo $item->description; ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Form for adding new item -->
<div class="card mt-3">
    <div class="card-header">
        <h3><i class="fas fa-lightbulb mr-2"></i>Add New Spotlight Item</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="spotlight_content.php">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Item</button>
        </form>
    </div>
</div>
