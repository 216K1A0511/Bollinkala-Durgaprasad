<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';
$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("No resume ID specified.");
}
$resume_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT doc_content, created_at FROM saved_resumes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $resume_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    die("Resume not found.");
}

$stmt->bind_result($docContent, $created_at);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Saved Resume</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       body { margin: 20px; }
       .doc-container {
         border: 1px solid #ccc;
         padding: 20px;
         background: #fff;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
       }
       .btn-group { margin-top: 20px; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
       <h3>Saved Resume (<?= htmlspecialchars($created_at) ?>)</h3>
       <div class="doc-container">
           <?= $docContent; ?>
       </div>
       <div class="btn-group">
           <!-- Edit button sends the resume_id to the editor -->
           <a href="resume_editor.php?resume_id=<?= $resume_id ?>" class="btn btn-warning">Edit</a>
           <!-- Delete button -->
           <button id="deleteBtn" class="btn btn-danger">Delete</button>
           <!-- Back to Editor -->
           <a href="resume_editor.php" class="btn btn-primary">Back to Editor</a>
       </div>
    </div>
    <script>
      $("#deleteBtn").click(function(){
          if(confirm("Are you sure you want to delete this resume?")){
              $.ajax({
                  url: 'delete_resume.php',
                  method: 'POST',
                  data: { resume_id: <?= $resume_id ?> },
                  success: function(response){
                      alert("Resume deleted successfully.");
                      // Redirect to the saved resumes list page or editor page
                      window.location.href = "get_saved_resumes.php";
                  },
                  error: function(){
                      alert("Error deleting resume.");
                  }
              });
          }
      });
    </script>
</body>
</html>
