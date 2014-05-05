<!DOCTYPE html>
<html>
<head>
  <title>Our Modal Dialog Example</title>
  <style>
  /* This is the CSS for the normal div */
  .normal {
    background-color: lightblue;
    width: 900px;
    min-height: 200px;
    padding: 20px;
  }

  /* This is the CSS for the modal dialog window */
  .modal {
    background-color: white;
    color: black;
    border: 1px solid gray;
    padding: 20px;
    display: block;
    position: absolute;
    top: 10px;
    right: 10px;
    width: 400px;
    height: 300px;
  }
  </style>
</head>

<body>
  <div class="normal">
    This is a regular div inline with the page (default
    position in CSS is static).
  </div>
  <div class="modal">
    This is a div that will be position absolute to the
    top-right of the page and overlays the rest of the
    content.
  </div>
</body>
</html>
