<!-- index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Students</title>
</head>
<body>

    <!-- Your HTML content here -->

    <button onclick="displayStudents()">Display Students</button>

    <div id="studentDetails"></div>

    <script>
        function displayStudents() {
            // Use AJAX to call the PHP script
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Update the page with the retrieved student details
                    document.getElementById("studentDetails").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data.php", true);
            xhttp.send();
        }
    </script>

</body>
</html>
