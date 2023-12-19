<?php
include 'Admin/classes/spotlight.php';
$host = "localhost";
$dbname = "db_admin";
$username = "root";
$password = "";

try {
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

$spotlight = new Spotlight($your_pdo_connection);
// Fetch spotlight items
$spotlightData = $spotlight->selectAllSpotlightData();

?>

<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://main.js?attr=RQlKJqpTliPcz7Ld_NtzoZrYWQYfepfsRa0iuEYC1Lb9_-SOxMTYOuDuDj7oz5vj0b9gSeRui56hDfaWjk4rRQ" charset="UTF-8"></script>
    <title>VIT Chennai - BTECH CAPSTONE</title>
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="PreLogin.css" />
</head>
<style>
    .larger-text {
        font-size: 14px;
    }
</style>

<body class="WhiteBackground">
    <nav class="navbar navbar-expand-lg bg-light headerBackgroundColor py-1 fixed-top shadow" id="vtopOpenPageHeader">
        <div class="container-fluid justify-content-start">
            <a class="navbar-brand" href="javacript:void(0);"> 
                <img src="images/vitlogo.webp" class="img-responsive VITEmblem" />
            </a>
            <a class="navbar-brand VITLogoStyle text-light" href="javascript:void(0);"><span class="h1 fw-bold">VIT</span></a>
                &nbsp;&nbsp;
                <span class="navbar-text text-light">&nbsp;Chennai Campus</span>

        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row WhiteBackground pb-5">
            <div class="col-12">
                <div class="card card-body border-0 ">
                    <div class="d-flex flex-column justify-content-center">
                        <strong class="h2 align-self-center primaryTextColor1 fw-bold text-center"><b> B.Tech Capstone Project Management System</b></strong>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 py-3 g-2 g-sm-5"> 

                    <div class="col">
                        <div class="card card-body cardEmployee shadow" style="display: flex; align-items: center;">
                            <form class="text-center" id="facForm" action="Faculty/login.php" method="post">
                                <a href="Faculty/login.php" class="text-decoration-none" onclick="javascript:submitForm('facForm')" style="display: flex; align-items: center;">
                                    <div style="flex-shrink: 0; overflow: hidden; border-radius: 50%; margin-right: 15px;">
                                        <img src="images/faculty.png" class="img-responsive center imgSize" style="max-width: 100%; height: auto; object-fit: cover;"/>
                                    </div>
                                    <div style="flex-grow: 1;">
                                        <p style="margin: 0; font-weight: bold; font-size: 18px;">Faculty</p>
                                        <div class="fw-bold employeeTextColor d-none d-lg-block h5"></div>
                                    </div>
                                </a>
                            </form>
                        </div>
                    </div>

                        
                    <div class="col">
                        <div class="card card-body cardAlumni shadow" style="display: flex; align-items: center;">
                            <form class="text-center" id="adminForm" action="Admin/index.php" method="post">
                                <a href="Admin/login.php" class="text-decoration-none" onclick="javascript:submitForm('adminForm')" style="display: flex; align-items: center;">
                                    <div style="flex-shrink: 0; overflow: hidden; border-radius: 50%; margin-right: 15px;">
                                        <img src="images/admin.png" class="img-responsive center imgSize" id="admin" style="max-width: 100%; height: auto; object-fit: cover;">
                                    </div>
                                    <div style="flex-grow: 1;">
                                        <p style="margin: 0; font-weight: bold; font-size: 18px;">Admin</p>
                                        <div class="fw-bold text-info d-none d-lg-block h5"></div>
                                    </div>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="row mt-1 mb-3"> 
            <div class="md-6"> 
                <div class="card border-0 shadow-lg">
                    <div class="card-header d-flex justify-content-between spotlightHeader">
                        <span class="fw-bold hightlight1 h6">Spotlight</span>
                    </div>
                    <div class="card-body">
                        <ul id="spotlightList" class="list-group list-group-flush text-start small spotlight-background">
                            <!-- Spotlight content will be dynamically added here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <script>
        var offsetHeight = document.getElementById('vtopOpenPageHeader').offsetHeight;
        document.body.style.marginTop = offsetHeight + 'px';

        function sessionExpiredCall() {
            var form = document.getElementById("sessionExpireCheckForm");
            form.submit();
        }

        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
        function updateSpotlight() {
        fetch('get_spotlight_data.php')
            .then(response => response.json())
            .then(data => {
                const spotlightList = document.getElementById('spotlightList');
                spotlightList.innerHTML = ''; // Clear existing content

                data.forEach(item => {
                    const listItem = document.createElement('li');
                    listItem.className = 'list-group-item py-2 small';
                    listItem.innerHTML = `<div class="d-flex w-100 align-items-stretch justify-content-start">
                                            <div class="w-75 py-0">
                                                <strong class="fw-bold text-dark larger-text">${item.description}</strong>
                                            </div>
                                        </div>`;
                    spotlightList.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error('Error during the fetch request:', error);
            });
    }

    // Call the update function on page load
    document.addEventListener('DOMContentLoaded', function () {
        updateSpotlight();

        // Refresh the page every 30 seconds
        setInterval(function () {
            location.reload();
        }, 30000); // 30 seconds in milliseconds
    });
    </script>
</body>
</html>
