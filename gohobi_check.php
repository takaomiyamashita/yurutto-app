<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="css/style.css">
<title>入力エラー</title>
</head>
<body>
<?php
require "menu.php";

$gohobi_name = $_POST['gohobi'];
$gohobi_point = $_POST['point'];

if ($gohobi_name == '' || $gohobi_point == '') {
  print '<div class="point-out"><h3>Please input.</h3></div>';
  print '<a href="gohobi_input.php" class="back-from-actiondisp"><p>　BACK</p></a>';
  exit();
}

$dsn = 'mysql:dbname=heroku_ebf52ea237485c7;host=us-cdbr-east-03.cleardb.com;charset=utf8';
$user = 'b91426ab53392b';
$password ='92927f19';

try {
  $db = new PDO($dsn,$user,$password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

  $stmt = $db->prepare("
    INSERT INTO gohobi(necessary_point,gohobi_name)
    VALUES (:point, :name)"
  );

  $stmt->bindParam(':point', $gohobi_point, PDO::PARAM_STR);
  $stmt->bindParam(':name', $gohobi_name, PDO::PARAM_STR);

  $stmt->execute();

  header('Location: index2.php');
  exit();
} catch(PDOException $e){
  die ('エラー：' . $e->getMessage());
}

?>
</body>
</html>