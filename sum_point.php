<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="css/style.css">
<title>ご褒美選択</title>
</head>
<body>
<?php
require "menu.php";

$dsn = 'mysql:dbname=heroku_ebf52ea237485c7;host=us-cdbr-east-03.cleardb.com;charset=utf8';
$user='b91426ab53392b';
$password='92927f19';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT SUM(point) as sum_point FROM users;';

$stmt = $dbh->prepare($sql);
$stmt->execute();

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$sum_point=$rec['sum_point'];

$dbh = null;

$con = mysqli_connect('us-cdbr-east-03.cleardb.com', 'b91426ab53392b', '92927f19');
if (!$con) {
  exit('データベースに接続できませんでした。');
}
$result = mysqli_select_db($con, 'heroku_ebf52ea237485c7');
if (!$result) {
  exit('データベースを選択できませんでした。');
}
$result = mysqli_query($con, 'SET NAMES utf8');
if (!$result) {
  exit('文字コードを指定できませんでした。');
}
$result = mysqli_query($con, 'SELECT * FROM gohobi ORDER BY necessary_point DESC');
?>

<div class="sum_point">
  <div class="top">
    <div class="part1"><span>TOTAL　POINT</span></div>
    <div class="part"><span><?php echo $sum_point ?>P</span></div>
  </div>
  <div class="bottom">
    <div class="part1"><span>Reward you can get</span></div>
    <form action="remained_point.php" method="POST">
    <select class="your-reward" name="nPoint" >
    <?php  
    while ($data = $result->fetch_assoc()) {
      if($data['necessary_point'] <= $sum_point){
    ?>
    <option value="<?php print $data['necessary_point']; ?>">
    <?php print $data['gohobi_name'].":　".$data['necessary_point']."P"; ?>
    </option>
    <?php
    }}
    ?>
  </div>
</div>

<input type="submit" value="Done" class="target"/>

<script type="text/javascript">
  var $target = document.querySelector('.target')
    window.onload = 
  <?php if($sum_point < 1){?>   
      function(){
        $target.classList.toggle('is-hidden')
      }
  <?php }?>
</script>

</select>
</form>

<?php
return false;

$con = mysqli_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}
?>
</body>
</html>