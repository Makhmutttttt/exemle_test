<?php

$comment = 'asdfsadf<script>alert("sadf")</script>';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Page</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">


  
</head>

<body class="body">
    <div class="container px-4">
        <div class="my_container mt-3 container_my">
            <div class="row">
                <div class="col-12 mb-6">
                <form action="process_form.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">User Name:</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" required pattern="[A-Za-z0-9]+" placeholder="Enter your user name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="homepage" class="form-label">Homepage:</label>
                        <input type="url" class="form-control" id="homepage" name="homepage" placeholder="Enter your homepage URL">
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Text:</label>
                        <textarea class="form-control" id="text" name="text" required placeholder="Enter your message"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fileToUpload">Example file input</label>
                        <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload">
                    </div>
                    <button type="submit" value="Upload Image" name="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>