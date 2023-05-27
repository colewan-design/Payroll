 <?php
require_once "conn.php";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT question, answer FROM faq";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="accordion">';
        echo '<div class="accordion-item">';
        echo '<h2 class="accordion-header">';
        echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $row["id"] . '" aria-expanded="true" aria-controls="collapse' . $row["id"] . '">';
        echo '<div class="circle-icon"><i class="fa fa-question"></i></div>';
        echo '<span>' . $row["question"] . '</span></button></h2>';
        echo '<div id="collapse' . $row["id"] . '" class="accordion-collapse collapse" aria-labelledby="heading' . $row["id"] . '" data-bs-parent="#accordionExample">';
        echo '<div class="accordion-body">' . $row["answer"] . '</div></div></div></div>';
    }
} else {
    echo "0 results";
}
$conn->close();
?>