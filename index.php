<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://main.js?attr=RQlKJqpTliPcz7Ld_NtzoZrYWQYfepfsRa0iuEYC1Lb9_-SOxMTYOuDuDj7oz5vj0b9gSeRui56hDfaWjk4rRQ" charset="UTF-8"></script>
    <title>VIT Chennai - BTECH CAPSTONE</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="https://vtopcc.vit.ac.in/vtop/get/bs/css/1">
    <link rel="stylesheet" type="text/css" href="https://vtopcc.vit.ac.in/vtop/assets/css/PreLogin.css" />
</head>

<body class="WhiteBackground">
    <nav class="navbar navbar-expand-lg bg-light headerBackgroundColor py-1 fixed-top shadow" id="vtopOpenPageHeader">
        <div class="container-fluid justify-content-start">
            <a class="navbar-brand" href="javacript:void(0);"> 
                <!-- ADD HOMEPAGE LINK HERE -->
                <img src="https://vtopcc.vit.ac.in/vtop/assets/img/VITLogoEmblem.png" class="img-responsive VITEmblem" />
            </a>
            <a class="navbar-brand VITLogoStyle text-light" href="javascript:void(0);"><span class="h1 fw-bold">VIT</span></a>
            <!-- ADD HOME PAGE LINK HERE -->
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

                        <div class="col"> <!-- First column -->
                            <div class="card card-body cardEmployee shadow">
                                <form class="text-center" id="facForm" action="Faculty/login.php" method="post">
                                    <a href="Faculty/login.php" class="text-decoration-none" onclick="javascript:submitForm('facForm')">
                                        <div class="circle">
                                            <div class="w-50">
                                                <img src="https://vtopcc.vit.ac.in/vtop/assets/img/employee.png" class="img-responsive center imgSize"/>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p>Faculty</p>
                                                <div class="fw-bold employeeTextColor d-none d-lg-block h5"></div>
                                            </div>
                                        </div>
                                    </a>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col"> <!-- Second column -->
                            <div class="card card-body cardAlumni shadow">
                                <form class="text-center" id="adminForm" action="Admin/index.php" method="post">
                                    <a href="Admin/login.php" class="text-decoration-none" onclick="javascript:submitForm('adminForm')">
                                        <div class="circle">
                                            <div class="w-50">
                                                <img src="https://vtopcc.vit.ac.in/vtop/assets/img/alumni.png" class="img-responsive center imgSize" id="admin" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <p>Admin</p>
                                                <div class="fw-bold text-info d-none d-lg-block h5"></div>
                                            </div>
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
            <div class="col-md-6"> <!-- First column -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header d-flex justify-content-between spotlightHeader">
                        <span class="fw-bold hightlight1 h6">Spotlight - Faculty</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush text-start small spotlight-background">
                            <li class="list-group-item py-2 small">
                                <div class="d-flex w-100 align-items-stretch justify-content-start">
                                    <div class="w-75 py-0">
                                        <a class="list-group-item-action" target="_self" href="javascript:void(0);" onclick="javascript:void(0);">
                                            <strong class="fw-bold text-dark">SOME CONTENT</strong>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!-- ADD THE REST OF THE CONTENT IN <LI> TAGS -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6"> <!-- Second column -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header d-flex justify-content-between spotlightHeader">
                        <span class="fw-bold hightlight1 h6">Spotlight - Admin</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush text-start small spotlight-background">
                            <li class="list-group-item py-2 small">
                                <div class="d-flex w-100 align-items-stretch justify-content-start">
                                    <div class="w-75 py-0">
                                        <a class="list-group-item-action" target="_self" href="javascript:void(0);" onclick="javascript:void(0);">
                                            <strong class="fw-bold text-dark">SOME CONTENT</strong>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!-- ADD THE REST OF THE CONTENT IN <LI> TAGS -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>
