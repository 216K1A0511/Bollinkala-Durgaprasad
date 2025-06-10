<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI Resume Builder - Home</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #1e3c72, #2a5298);
      color: white;
      text-align: center;
    }
    .container {
      width: 80%;
      margin: auto;
    }
    /* Navbar style */
    .navbar {
      background-color: #fff;
      display: flex;
      align-items: center;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .navbar .logo {
      margin-right: auto;
    }
    .navbar .logo img {
      width: 200px;
      height: auto;
      background: linear-gradient(to right, #1e3c72, #2a5298);
      border-radius: 5px;
    }
    .navbar nav {
      display: flex;
    }
    .navbar a {
      color: #007BFF;
      text-decoration: none;
      font-size: 18px;
      font-weight: bold;
      padding: 10px 20px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .navbar a:hover {
      background-color: #007BFF;
      color: white;
      border-radius: 5px;
    }
    /* Hero section */
    .hero {
      padding: 100px 20px;
    }
    .hero h1 {
      font-size: 3em;
      margin-bottom: 10px;
    }
    .hero p {
      font-size: 1.5em;
      margin-bottom: 20px;
    }
    .btn {
      background-color: #ff5733;
      color: white;
      padding: 15px 30px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 1.2em;
    }
    /* Resume templates grid */
    .resume-templates {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      padding: 50px 0;
      justify-items: center;
    }
    .template {
      width: 300px;
      height: 400px;
      background: white;
      color: black;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      padding: 10px;
      cursor: pointer;
      transition: transform 0.3s;
    }
    .template img {
      width: 100%;
      height: 100%;
      border-radius: 10px;
    }
    .template:hover {
      transform: scale(1.05);
    }
    /* Features, how-it-works, FAQs */
    .features, .how-it-works, .testimonials {
      padding: 50px 20px;
      background: white;
      color: black;
      border-radius: 10px;
      margin: 20px 0;
    }
    .features h2, .how-it-works h2, .testimonials h2 {
      color: #1e3c72;
    }
    /* Footer */
    .footer {
      padding: 20px;
      background: transparent;
      color: white;
    }
  </style>
</head>
<body>
  <!-- Navbar with Logout -->
  <div class="navbar">
    <div class="logo">
      <img src="imgs/collegelogo.png" alt="Logo">
    </div>
    <nav>
      <a href="#home">Home</a>
      <a href="get_saved_resumes.php">Saved Resumes</a>
      <!-- Logout: points to logout.php which destroys session and redirects -->
      <a href="logout.php">Logout</a>
    </nav>
  </div>

  <div class="container">
    <!-- Hero Section -->
    <div class="hero" id="home">
      <h1>AI-Based Strong Resume Builder</h1>
      <p>Create a professional resume in minutes with AI-powered suggestions!</p>
      <a href="resume_editor.php" class="btn">Get Started</a>
    </div>

    <!-- Resume Templates -->
    <div class="resume-templates">
      <a href="resume_editor.php" class="template"><img src="imgs/template1.png" alt="Template 1"></a>
      <a href="template2.php" class="template"><img src="imgs/template2.png" alt="Template 2"></a>
      <a href="template3.php" class="template"><img src="imgs/template3.png" alt="Template 3"></a>
      <a href="template4.php" class="template"><img src="imgs/template4.png" alt="Template 4"></a>
      <a href="template5.php" class="template"><img src="imgs/template5.png" alt="Template 5"></a>
      <a href="template6.php" class="template"><img src="imgs/template6.png" alt="Template 6"></a>
      <a href="template7.php" class="template"><img src="imgs/template7.png" alt="Template 7"></a>
      <a href="template8.php" class="template"><img src="imgs/template8.png" alt="Template 8"></a>
      <a href="template9.php" class="template"><img src="imgs/template9.png" alt="Template 9"></a>
    </div>

    <!-- Features Section -->
    <div class="features">
      <h2>Importance of Building a Strong Resume</h2>
      <p>✔ First Impression Matters – A well-structured resume creates an instant impact.</p>
      <p>✔ Showcases Your Skills – Highlights your qualifications and achievements effectively.</p>
      <p>✔ Increases Hiring Chances – Helps you pass ATS and stand out among candidates.</p>
      <p>✔ Demonstrates Professionalism – Reflects attention to detail and confidence.</p>
      <p>✔ Adapts to Job Roles – Allows easy customization for different opportunities.</p>
    </div>

    <!-- How It Works Section -->
    <div class="how-it-works">
      <h2>How It Works</h2>
      <p>1️⃣ Enter your details</p>
      <p>2️⃣ Choose a template</p>
      <p>3️⃣ Generate & download your resume</p>
    </div>

    <!-- FAQs Section -->
    <div class="testimonials">
      <h2>FAQs (Frequently Asked Questions)</h2>
      <p>What’s the ideal length of a resume for a fresher or entry-level position?</p>
      <p>How important is the layout and design of a resume?</p>
      <p>Should I add links to my LinkedIn profile, GitHub, or portfolio?</p>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>&copy; 2025 AI Resume Builder. All Rights Reserved.</p>
    </div>
  </div>
</body>
</html>
