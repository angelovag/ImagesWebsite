<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

// Database connection file
include("config.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
  <link href="css/style.image.details.css" rel="stylesheet" />
    <link href="css/style.comments.css" rel="stylesheet" />
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
          <a href="welcome.php" class="navbar-brand">
            <img src="images/logo-black.png" alt="">
          </a>
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item">
                  <a class="nav-link" href="welcome.php">Начало <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="portfolio.php">Снимки </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="users-users.php">Потребители </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.html">Контакти</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Моят профил
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <!-- Dropdown Items -->
                    <a class="dropdown-item" href="upload_form.php">Качване на снимка</a>
                    <a class="dropdown-item" href="#">Промяна на профил</a>
                    <a class="dropdown-item" href="logout.php">Изход</a>
                  </div>
                </li>

              </ul>
              <!-- <form class="form-inline">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
              </form> -->
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>


    <!-- gallery section -->
    <div class="gallery-container">

      <h1 class="fw-light text-center text-lg-start mt-4 mb-0">Галерия</h1>
      <hr class="mt-2 mb-5">

      <!-- dispaly image -->

      <div class="image-container">
        <?php
        $imageId = $_GET['id'];
        $imageDetailsQuery = "SELECT * FROM images WHERE id = $imageId";
        $imageDetailsResult = mysqli_query($conn, $imageDetailsQuery);

        if ($imageDetailsResult && $image = mysqli_fetch_assoc($imageDetailsResult)) {

        ?>
          <img src="uploads/<?php echo $image['filename']; ?>" alt="">

          <!-- comment form -->
          <form action="add_comment.php" method="post">
            <input type="hidden" name="image_id" id="image_id" value="<?php echo $imageId; ?>">
            <label for="comment">Добавете коментар:</label>
            <textarea name="comment" id="comment" rows="4"></textarea>
            <button type="submit">Добави</button>
          </form>

          <!-- display existing comments -->

          <h4>Коментари:</h4>

          <!-- Display existing comments -->
          <div class="comment-container">
            <?php

                $commentsQuery = "SELECT c.*, u.name FROM comments c JOIN users u ON c.user_id = u.user_id WHERE c.image_id = $imageId";
                $commentsResult = mysqli_query($conn, $commentsQuery);

                if ($commentsResult) {
                    while ($comment = mysqli_fetch_assoc($commentsResult)) {
            ?>
            <p><strong><?php echo $comment['name']; ?>:</strong> <?php echo $comment['comment_text']; ?></p>
            <?php
                  }
              } else {
                  echo "Error fetching comments: " . mysqli_error($conn);
              }
            ?>
          </div>


          <!-- delete image button -->
          <form action="delete_image.php" method="post">
            <input type="hidden" name="image_id" value="<?php echo $imageId; ?>">
            <button type="submit">Изтрий изображението</button>
          </form>

        <?php
        } else {
            echo "Image not found.";
        }
        ?>

      </div>

    </div>
  <!-- end gallery section -->


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
              <li class>
                <a href="welcome.php">
                  Начало
                </a>
              </li>
              <li>
                <a href="portfolio.php">
                  Снимки
                </a>
              </li>
              <li>
                <a href="users-users.php">
                  Потребители
                </a>
              </li>
              <li>
                <a href="contact.html">
                  Контакти
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