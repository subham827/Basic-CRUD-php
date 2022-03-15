<?php
// INSERT INTO `notes` (`Title`, `Description`, `timestamp`) VALUES ('sampletitle1', 'sampledesc1', '18:51:54');
$insert = false;
$delete = false;
$server = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  # code...
}
if(isset($_GET['delete'])){
  
  $id = $_GET['delete'];
  
  $sql = "DELETE FROM notes WHERE title = '$id'";
  if(mysqli_query($conn, $sql)){
    $delete = true;
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }
  
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $title = $_POST['title'];
  $description = $_POST['description'];
  $timestamp = date("H:i:s");
  $sql = "INSERT INTO `notes`.`notes` (`Title`, `Description`, `timestamp`) VALUES ('$title', '$description', '$timestamp')";
  if(mysqli_query($conn, $sql)){
    $insert = true;
  }else{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action='/CRUD/index.php' method='post'>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Title</label>
            <input type="text" class="form-control" id="titleedit" aria-describedby="emailHelp" name="titleedit" placeholder="Add title">
            
          </div>
          <label for="exampleInputEmail1" class="form-label">Description</label>
          <div class="form-floating">

           <textarea class="form-control" placeholder="Leave a comment here" id="descriptionedit" style="height: 100px" name="descriptionedit"></textarea>
           
         </div>
         <br>
         
          <button type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Student database</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
             
          </div>
        </div>
      </nav>
      <?php
      if($insert){

        echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been added.
        
        </div>";
      }
      ?>
     <?php
      if($delete){

        echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted.
        
        </div>";
      }
     ?>
   <div class="container my-3">

         <form action='/CRUD/index.php' method='post'>
           <div class="mb-3">
             <label for="exampleInputEmail1" class="form-label">Title</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" placeholder="Add title">
             
           </div>
           <label for="exampleInputEmail1" class="form-label">Description</label>
           <div class="form-floating">

            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description"></textarea>
            
          </div>
          <br>
          
           <button type="submit" class="btn btn-primary">Add</button>
         </form>
   </div>

   <div class="container">
     <?php
    $sql = "SELECT * FROM notes";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card mb-3' >
            <div class='card-body'>
              <h5 class='card-title'>".$row['Title']."</h5>
              <p class='card-text'>".$row['Description']."</p>
              <p class='card-text'><small class='text-muted'>".$row['timestamp']."</small></p>
            </div>
            <div class='d-flex justify-content-end'>
            
            <button class='delete btn btn-danger' id='$row[Title]'>Delete
            </button>
            </div>
          </div>";
        }
    } else {
        echo "0 results";
    }
   
     
     ?>
   </div>
  


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
  
  edit = document.querySelectorAll('.btn-info');
  deletee = document.querySelectorAll('.btn-danger');
 
  edit.forEach(function(e){
    e.addEventListener('click',   function(){
      
      title = e.parentElement.parentElement.querySelector('.card-title').innerText;
      description = e.parentElement.parentElement.querySelector('.card-text').innerText;
      console.log(title);
      console.log(description);
      document.querySelector('#titleedit').value = title;
      document.querySelector('#descriptionedit').value = description;
      document.querySelector('#exampleModal').style.display = 'block';
  ;
    })
  })
  deletee.forEach(function(e){
    e.addEventListener('click', function(){
      console.log('delete');
     
      if(confirm('Are you sure you want to delete this note?')){
        title = e.parentElement.parentElement.querySelector('.card-title').innerText;
        console.log(title);
        window.location.href = '/CRUD/index.php?delete='+title;
      }
      
    })
  })
</script>
</body>
</html>