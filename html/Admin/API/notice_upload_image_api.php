<?php
// Check if the request contains a file

$time = date("YmdHis");

if (isset($_FILES['image'])) {
  $file = $_FILES['image'];

  // You may want to perform additional validation and sanitization here

  // Define a target directory to save the image
  $targetDirectory = '../../../../STATIC/img/notice/';
  $targetFile = $targetDirectory . $time.basename($file['name']);

  // Move the uploaded file to the target directory
  if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    // Send a response with the image URL
    echo json_encode(['url' => "http://jeojeon.com/STATIC/img/notice/".$time.basename($file['name'])]);
  } else {
    // Send an error response
    echo json_encode(['error' => 'Failed to upload the image']);
  }
} else {
  // Send an error response if no file is found
  echo json_encode(['error' => 'No file found']);
}
?>
