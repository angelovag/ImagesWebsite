<?php

// Database connection file
include('config.php');

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the index page
    header('Location: login_admin.html');
    exit;
}

// Query to retrieve last 5 registered users based on user_id
$query1 = "SELECT * FROM users ORDER BY user_id DESC LIMIT 5";

$result1 = $conn->query($query1);

// Query to retrieve images with user information, ordered by upload date
$query2 = "SELECT images.*, users.name
        FROM images
        JOIN users ON images.user_id = users.user_id
        ORDER BY images.upload_date DESC, id DESC LIMIT 5";

$result2 = $conn->query($query2);

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Ace</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Dosis:500|Raleway:400,600,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/style.users.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
  <div class="hero_area">

    <div class="main slick_main">
    </div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a href="index_admin.php" class="navbar-brand">
            <img src="images/logo-black.png" alt="">
          </a>
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index_admin.php">Начало <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="portfolio-admin.php">Снимки </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="users.php">Потребители </a>
                </li>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>


    <!-- end users section -->

    <!-- users section -->
    <div class="users-container">
        <h1 class="fw-light text-center text-lg-start mt-4 mb-0">Последните 5 регистрирани потребителя</h1>
        <hr class="mt-2 mb-5">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Име</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                if ($result1) {
                    while ($row = mysqli_fetch_assoc($result1)) {
                        echo '<tr>';
                        echo '<td>' . $row['user_id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($conn);
                }
                ?>

                </tbody>
            </table>

            <h1 class="fw-light text-center text-lg-start mt-4 mb-0">Последни 5 качени снимки</h1>
            <hr class="mt-2 mb-5">

            <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Снимка #</th>
                        <th>Име</th>
                        <th>Път</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                if ($result2) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td><img class="img-fluid img-thumbnail" style="height: 200px;" src="uploads/' . $row['filename'] . '" alt=""></td>';
                        echo '<td>' . $row['upload_date'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($conn);
                }
                ?>

                </tbody>
            </table>
          </div>
        </div>
    </div>
    <!-- end users section -->

  <!-- info section -->
  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info-logo">
            <a href="">
              <img src="images/info-logo.png" alt="">
            </a>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 offset-lg-1">
          <div class="info-nav">
            <h4>
              Меню
            </h4>
            <ul>
              <li class="active">
                <a href="index_admin.php">
                  Начало
                </a>
              </li>
              <li class="">
                <a href="portfolio-admin.php">
                  Снимки
                </a>
              </li>
              <li class="">
                <a href="users.php">
                  Потребители
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info_section -->


  <!-- footer section -->
  <section class="container-fluid footer_section">
    <p>
      &copy; 2020 All Rights Reserved By
      <a href="https://html.design/">Free Html Templates</a><br>
      Distributed By
      <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>
  <!-- end google map js -->


  <script>
    $('.slider-for').slick({
      autoplay: true,
      autoplaySpeed: 3000,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      dots: true,
      centerMode: true,
      focusOnSelect: true,

    });
  </script>

  <script>
    $('.slick-carousel').slick({
      infinite: true,
      slidesToShow: 3, // Shows a three slides at a time
      slidesToScroll: 1, // When you click an arrow, it scrolls 1 slide at a time
      responsive: [{
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 420,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 3,
        }
      }

      ]
    });
  </script>

</body>

</html>