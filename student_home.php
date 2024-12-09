<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home</title>
    <link rel="stylesheet" href="./css/headerstyles.css">
    <link rel="stylesheet" href="./css/student_home.css">
    <link rel="stylesheet" href="./css/footer.css">
    <?php include_once './includes/header-link.php'; ?>
</head>

<body>
    <?php
    include_once './includes/student_navbar.php';
    ?>
    <div class="main-content">
        <div class="new-books">
            <h4>NEW BOOKS</h4>
            <div class="book-container">
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/math-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">21st Century Mathematics</h3>
                        <p class="book-author">Rechilda P. Villame, Ju Se T. Ho, Lucy O. Sia, and Misael Jose S. Fisico; Author-Coordinator: Simon L. Chua, D.T.</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/english-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Better English for Philippine High Schools</h3>
                        <p class="book-author">Josephine B. Serrano</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/arpan-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Diksyunaryo sa Ekonomiks</h3>
                        <p class="book-author">Tereso S. Tullao, Jr., PhD</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/science-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">You and the Natural World Series </h3>
                        <p class="book-author">Lilia G. Vengco and Teresita F. Religioso</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/filipino-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Florante at Laura</h3>
                        <p class="book-author">Concepcion D. Javier at Florante C. Garcia; Editor-Koordineytor: Servillano T. Marquez, Jr.
                        </p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/mapeh-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Music, Art, Physical Education, and Health</h3>
                        <p class="book-author">Quennie S. Miranda, Laura R. Jugueta, Guinevere E. Sacdalan, and Maria Teresa R. San Jose; Coordinator: Maria Teresa C. Bayle</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/tle-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Technology and Livelihood Education Series</h3>
                        <p class="book-author">Aida T. Galura</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/math-book2.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Basic Statistics</h3>
                        <p class="book-author">Lydia M. Ybañez</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/values-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Values Education Series for the SEDP</h3>
                        <p class="book-author">Ma. Zilpha Palma-Rallos, Ma. Victoria L. Tuvilla</p>
                    </div>
                </div>
                <div class="book">
                    <a href="view-books.php">
                        <div class="book-image-container"> <!-- New div for the book image -->
                            <img src="./resources/books/religion-book1.png" alt="Book Title" class="book-image">
                        </div>
                    </a>
                    <div class="book-info">
                        <h3 class="book-title">Introduction to World Religions and Belief Systems </h3>
                        <p class="book-author">Napoleon M. Mabaquiao Jr., Ronaldo B. Mactal</p>
                    </div>
                </div>
                <!-- Repeat this structure for each book -->
            </div>
        </div>
    </div>
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
<?php include_once './includes/footer.php'; ?>

</html>