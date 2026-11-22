<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title>View Users</title>
<link rel="stylesheet" href="style.css">
<style>
body{
    font-family: Arial, sans-serif;
}

table{
    width:90%;
    margin:auto;
    border-collapse:collapse;
}

th, td{
    border:3px solid #0c0c0c;
    padding:10px;
    text-align:center;
}


.add-new-btn{
    display:inline-block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #bed115;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    border:none;
}

.add-new-btn:hover{
    background-color: #ec16da;
}


.edit-link{
    display:inline-block;
    padding:5px 10px;
    background-color: #b513eb;
    color:#fff;
    font-weight:bold;
    text-decoration:none;
    border:1px solid #e8bc0d;
    border-radius:4px;
    margin-right:5px;
}

.edit-link:hover{
    background-color:#0056b3;
    border-color:#0056b3;
}


.delete-link{
    display:inline-block;
    padding:5px 10px;
    background-color: #d7a81a;
    color:#fff;
    font-weight:bold;
    text-decoration:none;
    border:1px solid #e8bc0d;
    border-radius:4px;
}

.delete-link:hover{
    background-color:#a71d2a;
    border-color:#a71d2a;
}
</style>
</head>

<body>

<div style="text-align:center;">
    <h2>Registered Users</h2>
    <a href="index.php" class="add-new-btn">Add New</a>
</div>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Firstname</th>
        <th>Middlename</th>
        <th>Lastname</th>
        <th>Course</th>
        <th>Year</th>   
        <th>Block</th>
        <th>Address</th>
        <th>ACTION</th>
    </tr>

<?php
$result = $conn->query("SELECT * FROM youser_tb");

while($row = $result->fetch_assoc()){
?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['middlename']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
        <td><?php echo $row['course']; ?></td>
        <td><?php echo $row['year']; ?></td>
        <td><?php echo $row['block']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
            <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-link"
            onclick="return confirm('Delete this record?');">Delete</a>
        </td>
    </tr>
<?php } ?>

</table>

</body>
</html>