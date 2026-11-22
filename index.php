<?php include 'db.php'; ?>

<?php
if(isset($_POST['submit'])){
    
    $f = $_POST['firstname'];
    $m = $_POST['middlename'];
    $l = $_POST['lastname'];
    $c = $_POST['course'];
    $y = $_POST['year'];
    $b = $_POST['block'];
    $a = $_POST['address'];

    $sql = "INSERT INTO youser_tb 
    (firstname, middlename, lastname, course, year, block, address)
    VALUES ('$f','$m','$l','$c','$y','$b','$a')";

    $conn->query($sql);

    header("Location: view.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Registration</title>
<link  rel="stylesheet" href="style.css">
<style>
body{
    font-family: Arial, sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    background-color: #f2f2f2;
}

.form-box{
    width:500px;
    padding:20px;
    background-color:#fff;
    border-radius:8px;
    box-shadow: 0 0 10px rgba(215, 206, 206, 0.1);
}

input, textarea{
    width:97%;
    padding:8px;
    margin:5px 0;
    border:1px solid #ccc;
    border-radius:4px;
}

.row{
    display:flex;
    gap:10px;
    margin-bottom:10px;
}

button, .view-btn{
    padding:10px 20px;
    margin-top:10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
    text-decoration:none;
    color:#fff;
}


button[type="submit"]{
    background-color:blue;
}

button[type="submit"]:hover{
    background-color:red;
}


.view-btn{
    background-color:red;
}

.view-btn:hover{
    background-color:green;
}
</style>
</head>

<body>

<div class="form-box">
    <h2>Registration</h2>

    <form method="POST">
        <div class="row">
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="middlename" placeholder="Middle Name">
            <input type="text" name="lastname" placeholder="Last Name" required>
        </div>

        <div class="row">
            <input type="text" name="course" placeholder="Course">
            <input type="text" name="year" placeholder="Year">
            <input type="text" name="block" placeholder="Block">
        </div>

        <textarea name="address" placeholder="Address"></textarea>

        <div style="display:flex; gap:340px;">
            <button type="submit" name="submit">Submit</button>
            <a href="view.php" class="view-btn">View</a>
        </div>
    </form>
</div>

</body>
</html>