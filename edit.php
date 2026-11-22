<?php
include 'db.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM youser_tb WHERE id=$id");
$row = $result->fetch_assoc();

if(isset($_POST['update'])){
    $f = $_POST['firstname'];
    $m = $_POST['middlename'];
    $l = $_POST['lastname'];
    $c = $_POST['course'];
    $y = $_POST['year'];
    $b = $_POST['block'];
    $a = $_POST['address'];

    $sql = "UPDATE youser_tb SET 
        firstname='$f',
        middlename='$m',
        lastname='$l',
        course='$c',
        year='$y',
        block='$b',
        address='$a'
        WHERE id=$id";

    $conn->query($sql);

    header("Location: view.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="form-box">
<h2>Edit Student</h2>

<form method="POST">

<div class="row">
<input type="text" name="firstname" value="<?php echo $row['firstname']; ?>">
<input type="text" name="middlename" value="<?php echo $row['middlename']; ?>">
<input type="text" name="lastname" value="<?php echo $row['lastname']; ?>">
</div>

<div class="row">
<input type="text" name="course" value="<?php echo $row['course']; ?>">
<input type="text" name="year" value="<?php echo $row['year']; ?>">
<input type="text" name="block" value="<?php echo $row['block']; ?>">
</div>

<textarea name="address"><?php echo $row['address']; ?></textarea>

<button type="submit" name="update">Update</button>

</form>
</div>

</body>
</html>