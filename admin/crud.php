<?php
include('../config/config.php');

// Read operation
if (isset($_POST['merch_read'])) {
    $merch_id = $_POST['id'];
    $result = mysqli_query($conn, "SELECT * FROM merch WHERE merch_id = $merch_id");
    $record = mysqli_fetch_assoc($result);

    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Read Record</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f4f4f4;
                      margin: 0;
                      padding: 0;
                  }

                  .container {
                      max-width: 600px;
                      margin: 20px auto;
                      padding: 20px;
                      background-color: #fff;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }

                  h3 {
                      color: #333;
                  }

                  img {
                      max-width: 100%;
                      height: auto;
                      margin-top: 10px;
                  }

                  a {
                      display: block;
                      margin-top: 10px;
                      color: #black;
                      text-decoration: none;
                  }

                  a:hover {
                      text-decoration: underline;
                  }
              </style>
          </head>
          <body>
              <div class='container'>
                  <h3>Merchandise Details</h3>
                  <p><strong>Name:</strong> {$record['name']}</p>
                  <p><strong>Description:</strong> {$record['description']}</p>
                  <p><strong>Price:</strong> {$record['price']}</p>
                  <p><strong>Stock:</strong> {$record['stock_quantity']}</p>
                  <img src='./img/{$record['image_url']}' alt='Image' style='max-width: 100%;'>
                  <a clas='btn btn-success' href='index.php?active=merch'>Back to List</a>
              </div>
          </body>
          </html>";
}

// Read operation
if (isset($_POST['event_read'])) {
    $event_id = $_POST['id'];
    $result = mysqli_query($conn, "SELECT * FROM events WHERE event_id = $event_id");
    $record = mysqli_fetch_assoc($result);

    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Read Record</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f4f4f4;
                      margin: 0;
                      padding: 0;
                  }

                  .container {
                      max-width: 600px;
                      margin: 20px auto;
                      padding: 20px;
                      background-color: #fff;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }

                  h3 {
                      color: #333;
                  }

                  img {
                      max-width: 100%;
                      height: auto;
                      margin-top: 10px;
                  }

                  a {
                      display: block;
                      margin-top: 10px;
                      color: #black;
                      text-decoration: none;
                  }

                  a:hover {
                      text-decoration: underline;
                  }
              </style>
          </head>
          <body>
              <div class='container'>
                  <h3>Event Details</h3>
                  <p><strong>Title:</strong> {$record['title']}</p>
                  <p><strong>Description:</strong> {$record['description']}</p>
                  <p><strong>Event Date:</strong> {$record['event_date']}</p>
                  <p><strong>location:</strong> {$record['location']}</p>
                  <img src='./img/{$record['image_url']}' alt='Image' style='max-width: 100%;'>
                  <a clas='btn btn-success' href='index.php?active=events'>Back to List</a>
              </div>
          </body>
          </html>";
}

// Read operation
if (isset($_POST['news_read'])) {
    $news_id = $_POST['id'];
    $result = mysqli_query($conn, "SELECT * FROM news WHERE news_id = $news_id");
    $record = mysqli_fetch_assoc($result);

    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Read News</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f4f4f4;
                      margin: 0;
                      padding: 0;
                  }

                  .container {
                      max-width: 600px;
                      margin: 20px auto;
                      padding: 20px;
                      background-color: #fff;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }

                  h3 {
                      color: #333;
                  }

                  img {
                      max-width: 100%;
                      height: auto;
                      margin-top: 10px;
                  }

                  .author, .date {
                      font-size: 0.9em;
                      color: #555;
                  }

                  a {
                      display: block;
                      margin-top: 10px;
                      color: black;
                      text-decoration: none;
                  }

                  a:hover {
                      text-decoration: underline;
                  }
              </style>
          </head>
          <body>
              <div class='container'>
                  <h3>News Details</h3>
                  <p><strong>Title:</strong> {$record['title']}</p>
                  <p class='author'><strong>Author:</strong> {$record['author']}</p>
                  <p class='date'><strong>Published Date:</strong> " . ($record['published_date'] ?: "Not Published") . "</p>
                  <p><strong>Content:</strong> {$record['content']}</p>
                  <img src='./img/{$record['image_url']}' alt='News Image'>
                  <a class='btn btn-success' href='index.php?active=news'>Back to List</a>
              </div>
          </body>
          </html>";
}


// Read operation
if (isset($_POST['spotlight_read'])) {
    $spotlight_id = $_POST['id'];
    $result = mysqli_query($conn, "SELECT * FROM spotlight WHERE spotlight_id = $spotlight_id");
    $record = mysqli_fetch_assoc($result);

    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Read Spotlight</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f4f4f4;
                      margin: 0;
                      padding: 0;
                  }

                  .container {
                      max-width: 600px;
                      margin: 20px auto;
                      padding: 20px;
                      background-color: #fff;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }

                  h3 {
                      color: #333;
                  }

                  img {
                      max-width: 100%;
                      height: auto;
                      margin-top: 10px;
                  }

                  .video-container {
                      position: relative;
                      width: 100%;
                      padding-bottom: 56.25%; /* 16:9 aspect ratio */
                      margin-top: 10px;
                      overflow: hidden;
                  }

                  .video-container video {
                      position: absolute;
                      top: 0;
                      left: 0;
                      width: 100%;
                      height: 100%;
                  }

                  a {
                      display: block;
                      margin-top: 10px;
                      color: black;
                      text-decoration: none;
                  }

                  a:hover {
                      text-decoration: underline;
                  }
              </style>
          </head>
          <body>
              <div class='container'>
                  <h3>Spotlight Details</h3>
                  <p><strong>Title:</strong> {$record['title']}</p>
                  <p><strong>Description:</strong> {$record['description']}</p>
                  <p><strong>Video:</strong></p>
                  <div class='video-container'>
                      <video controls>
                          <source src='./vid/{$record['video_url']}' type='video/mp4'>
                          Your browser does not support the video tag.
                      </video>
                  </div>
                  <a class='btn btn-success' href='index.php?active=spotlight'>Back to List</a>
              </div>
          </body>
          </html>";
}
// Read operation for program details
if (isset($_POST['program_read'])) {
    $program_id = $_POST['id'];
    $result = mysqli_query($conn, "SELECT * FROM programs WHERE program_id = $program_id");
    $record = mysqli_fetch_assoc($result);

    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Read Program</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f4f4f4;
                      margin: 0;
                      padding: 0;
                  }

                  .container {
                      max-width: 800px;
                      margin: 20px auto;
                      padding: 20px;
                      background-color: #fff;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }

                  h3 {
                      color: #333;
                  }

                  img {
                      max-width: 100%;
                      height: auto;
                      margin-top: 10px;
                  }

                  .category {
                      font-style: italic;
                      color: #555;
                  }

                  a {
                      display: block;
                      margin-top: 10px;
                      color: black;
                      text-decoration: none;
                  }

                  a:hover {
                      text-decoration: underline;
                  }
              </style>
          </head>
          <body>
              <div class='container'>
                  <h3>Program Details</h3>
                  <p><strong>Title:</strong> {$record['title']}</p>
                  <p><strong>Description:</strong> {$record['description']}</p>
                  <p><strong>Category:</strong> <span class='category'>{$record['category']}</span></p>
                  <img src='./img/{$record['image_url']}' alt='Program Image'>
                  <p><strong>Created At:</strong> {$record['created_at']}</p>
                  <a class='btn btn-success' href='index.php?active=programs'>Back to Programs List</a>
              </div>
          </body>
          </html>";
}

// Merch Edit operation
if (isset($_POST['merch_edit'])) {
    $merch_id = $_POST['id'];
    header("Location: merch_edit.php?merch_id=$merch_id");
    exit();
}

// Event Edit operation
if (isset($_POST['event_edit'])) {
    $event_id = $_POST['id'];
    header("Location: event_edit.php?event_id=$event_id");
    exit();
}

// News Edit operation
if (isset($_POST['news_edit'])) {
    $news_id = $_POST['id'];
    header("Location: news_edit.php?news_id=$news_id");
    exit();
}

// Spotlight Edit operation
if (isset($_POST['spotlight_edit'])) {
    $spotlight_id = $_POST['id'];
    header("Location: spotlight_edit.php?spotlight_id=$spotlight_id");
    exit();
}

// Program Edit operation
if (isset($_POST['program_edit'])) {
    $program_id = $_POST['id'];
    header("Location: program_edit.php?program_id=$program_id");
    exit();
}

// -------------------- DELETE SECTION ------------------------

// Merch Delete operation
if (isset($_POST['merch_delete'])) {
    $merch_id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM merch WHERE merch_id = $merch_id");
    header("Location: index.php?active=merch");
    exit();
}

// Event Delete operation
if (isset($_POST['event_delete'])) {
    $event_id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM events WHERE event_id = $event_id");
    header("Location: index.php?active=events");
    exit();
}

// News Delete operation
if (isset($_POST['news_delete'])) {
    $news_id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM news WHERE news_id = $news_id");
    header("Location: index.php?active=news");
    exit();
}

// Spotlight Delete operation
if (isset($_POST['spotlight_delete'])) {
    $spotlight_id = $_POST['spotlight_delete'];
    mysqli_query($conn, "DELETE FROM spotlight WHERE spotlight_id = $spotlight_id");
    header("Location: index.php?active=spotlight");
    exit();
}

if (isset($_POST['delete_program'])) {
    $program_id = $_POST['id']; // Use 'id' to get the program ID from the form
    $query = "DELETE FROM programs WHERE program_id = $program_id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?active=programs");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Admins Delete operation
if (isset($_POST['admin_delete'])) {
    $admin_id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM admins WHERE admin_id = $admin_id");
    header("Location: index.php?active=admins");
    exit();
}

// -------------------- OTHERS SECTION ------------------------

// Handle the publish news request
if (isset($_POST['publish_news'])) {
    $news_id = $_POST['id'];

    // Update the category and published_date
    $query = "UPDATE news SET category = 'General', published_date = NOW() WHERE news_id = $news_id";
    
    if (mysqli_query($conn, $query)) {
        echo "
        ...
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>Swal.fire('Success!', 'News has been published!', 'success').then(function() {window.location = 'index.php?active=news';});</script>";
    } else {
        echo "...
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>Swal.fire('Error!', 'Failed to publish news.', 'error').then(function() {window.location = 'index.php?active=news';});</script>";
    }
}


?>
