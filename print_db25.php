<?php 
    require 'connect_db.php';
    

    $messagesPerPage = 25;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    

    // Validate and sanitize the current page number
    if ($currentPage <= 0) {
        $currentPage = 1;
    }   

    $offset = ($currentPage - 1) * $messagesPerPage;

    // Retrieve total number of rows
    $totalRows = $database->query("SELECT COUNT(*) as total FROM guestbook")->fetchColumn();
    $totalPages = ceil($totalRows / $messagesPerPage);

    $sql = "SELECT * FROM guestbook ORDER BY created_at DESC LIMIT $messagesPerPage OFFSET $offset";
    $result = $database->query($sql);
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

<?php 
    if ($result->rowCount() > 0) {
        // Output messages as a table
        echo '<table class="table">';
        echo '<thead class="thead-dark">';
        echo '<tr><th>User Name</th><th>Email</th><th>Homepage</th><th>Text</th><th>IP Address</th><th>Browser</th><th>Created At</th><th>File name</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        
        while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['user_name'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['homepage'] . '</td>';
            echo '<td>' . $row['text'] . '</td>';
            echo '<td>' . $row['ip_address'] . '</td>';
            echo '<td>' . $row['browser'] . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '<td>' . $row['file_name'] . '</td>';
            echo '</tr>';
        }
        


        
        echo '</tbody>';
        echo '</table>';

            // Pagination
            echo '<nav aria-label="Page navigation">';
            echo '<ul class="pagination">';

            // Previous page
            if ($currentPage > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Previous</a></li>';
            }

            // Page numbers
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li class="page-item ' . ($currentPage == $i ? "active" : "") . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }

            // Next page
            if ($currentPage < $totalPages) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Next</a></li>';
            }

            echo '</ul>';
            echo '</nav>';



    } else {
        echo 'No messages found.';
    }


    ?>
</body>

</html>

