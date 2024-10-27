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
                  <h3>Merchandise Details</h3>
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


?>
