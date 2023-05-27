<?php

//fetch_data.php

$connect = new PDO("mysql:host=bsu-info.tech;dbname=u455679702_cps", "u455679702_cps", "OpK3RKh]!h9");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET')
{
 $data = array(
  ':name'   => "%" . $_GET['name'] . "%",
  ':id'   => "%" . $_GET['id'] . "%",
  ':sg'   => "%" . $_GET['sg'] . "%",
  ':step'     => "%" . $_GET['step'] . "%",
  ':salary'    => "%" . $_GET['salary'] . "%",
  ':position'    => "%" . $_GET['position'] . "%"
 );
 $query = "SELECT * FROM data WHERE name LIKE :name AND id LIKE :id AND sg LIKE :sg AND step LIKE :step AND salary LIKE :salary AND position LIKE :position ORDER BY id DESC";

 $statement = $connect->prepare($query);
 $statement->execute($data);
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output[] = array(
   'id'    => $row['id'],   
   'name'  => $row['name'],
   'id'   => $row['id'],
   'sg'   => $row['sg'],
   'step'    => $row['step'],
   'salary'   => number_format($row['salary'],2),
   'position'   => $row['position'],
  );
 }
 header("Content-Type: application/json");
 echo json_encode($output);
}

if($method == "POST")
{
 $data = array(
  ':name'  => $_POST['name'],
  ':id'  => $_POST["id"],
  ':sg'  => $_POST["sg"],
  ':step'    => $_POST["step"],
  ':salary'   => $_POST["salary"],
  ':position'   => $_POST["position"]
 );

 $query = "INSERT INTO data (name, id, sg, step, salary, position) VALUES (:name, :id, :sg, :step, :salary, :position)";
 $statement = $connect->prepare($query);
 $statement->execute($data);
}

if($method == 'PUT')
{
 parse_str(file_get_contents("php://input"), $_PUT);
 
 $data = array(
  ':id'   => $_PUT['id'],
  ':name' => $_PUT['name'],
  ':id' => $_PUT['id'],
  ':sg' => $_PUT['sg'],
  ':step'   => $_PUT['step'],
  ':position'  => $_PUT['position']
 );
 $query = "UPDATE data SET name = :name, id = :id, sg = :sg, step = :step, position = :position WHERE id = :id";
 $statement = $connect->prepare($query);
 $statement->execute($data);
 
 // Retrieve the amount from the salarydata table
    $query = "SELECT salaryAmount FROM salarydata WHERE salaryGrade = :sg AND salaryStep = :step";
    $statement = $connect->prepare($query);
    $statement->execute(array(':sg' => $_PUT['sg'], ':step' => $_PUT['step']));
    $amount = $statement->fetchColumn();

    // Update the data table with the new salary
    $query = "UPDATE data SET salary = :amount WHERE id = :id";
    $statement = $connect->prepare($query);
    $statement->execute(array(':amount' => $amount, ':id' => $_PUT['id']));
}







if($method == "DELETE")
{
 parse_str(file_get_contents("php://input"), $_DELETE);
 $query = "DELETE FROM data WHERE id = '".$_DELETE["id"]."'";

 $statement = $connect->prepare($query);
 $statement->execute();
}

?>