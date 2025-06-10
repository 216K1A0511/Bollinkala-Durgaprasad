<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    http_response_code(403);
    exit("Unauthorized");
}
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

// Combine custom fields arrays into one 'custom_fields' array if they exist.
if (isset($_POST['custom_fields_name'], $_POST['custom_fields_content'])) {
    $combinedCustomFields = [];
    foreach ($_POST['custom_fields_name'] as $uid => $name) {
        $content = $_POST['custom_fields_content'][$uid] ?? '';
        $combinedCustomFields[$uid] = ['name' => $name, 'content' => $content];
    }
    // Remove the separate arrays and add the combined data.
    unset($_POST['custom_fields_name'], $_POST['custom_fields_content']);
    $_POST['custom_fields'] = $combinedCustomFields;
}

// Encode all POST data into JSON for saving.
// (This will now include 'custom_fields' in the expected structure.)
$resumeData = json_encode($_POST);

// Retrieve the template file and DOC content.
$template_file = $_POST['template'] ?? 'templates/template1.html';
$docContent = $_POST['docContent'] ?? '';

// Insert the resume into the saved_resumes table.
$stmt = $conn->prepare("INSERT INTO saved_resumes (user_id, resume_data, template_file, doc_content, created_at) VALUES (?, ?, ?, ?, NOW())");
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    http_response_code(500);
    exit("Database error");
}
$stmt->bind_param("isss", $user_id, $resumeData, $template_file, $docContent);

if ($stmt->execute()) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Error saving resume.";
}
$stmt->close();
?>
