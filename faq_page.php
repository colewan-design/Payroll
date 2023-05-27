<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
    <style>
      
        body {
          margin: 0;
        }
      
        .accordion, h1 {
          width: 70%;
          margin: 0 auto;
        }
        h1{
            text-align: center;
            font-size: 70px;
            font-weight: 600;
            background-image: url(./this.png);
            background-size: 250px;
            background-repeat: repeat;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
        }
      </style>
</head>
<body class="gradient">
 <h1>Frequentely Asked Questions</h1>
<?php
// Include config file
require_once "conn.php";
 
// Attempt select query execution
$sql = "SELECT * FROM faq";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            echo '<div class="accordion-item">
                    <h2 class="accordion-header" id="heading'.$row['id'].'">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$row['id'].'" aria-expanded="false" aria-controls="collapse'.$row['id'].'">
                            '.$row['question'].'
                        </button>
                    </h2>
                    <div id="collapse'.$row['id'].'" class="accordion-collapse collapse" aria-labelledby="heading'.$row['id'].'" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            '.$row['answer'].'
                        </div>
                    </div>
                </div>';
        }
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
 
// Close connection
mysqli_close($conn);
?>
    
</body>
</html>