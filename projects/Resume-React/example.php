<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login1.php");
    exit();
}

// Connect to the database
include 'includes/db.php';

// Retrieve saved resume data for the logged-in user (if available)
// For demonstration, we simulate data; in production, query your 'resumes' table.
$resumeData = array();

// Sample resume data (you can replace with a database query)
if (empty($resumeData)) {
    $resumeData = [
        "contact" => [
            "name" => "John Doe",
            "location" => "City, State, Zip",
            "phone" => "123-456-7890",
            "email" => "john@example.com",
            "linkedin" => "https://www.linkedin.com/in/johndoe"
        ],
        "summary" => "Experienced professional with strong skills in web development.",
        "education" => [
            [
                "college" => "ABC College",
                "duration" => "2018-2022",
                "degree" => "B.Tech in Computer Science, CGPA: 8.5",
                "extra" => "Dean's List, Extra-curricular activities"
            ]
        ],
        "skills" => "PHP, JavaScript, HTML, CSS",
        "projects" => [
            [
                "title" => "Portfolio Website",
                "link" => "https://github.com/johndoe/portfolio",
                "desc" => "Developed a personal portfolio website using HTML, CSS, and JavaScript.",
                "tech" => "HTML, CSS, JavaScript"
            ]
        ],
        "internships" => [
            [
                "role" => "Software Intern",
                "company" => "XYZ Corp",
                "duration" => "June 2021 - August 2021",
                "desc" => "Worked on improving backend APIs."
            ]
        ],
        "certifications" => [
            [
                "title" => "AWS Certified Solutions Architect",
                "org" => "Amazon",
                "year" => "2023"
            ]
        ],
        "achievements" => [
            "Won Hackathon XYZ",
            "Published research on AI"
        ],
        "otherfields" => [
            [
                "heading" => "Volunteer Work",
                "desc" => "Volunteered at local community center."
            ]
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Resume - AI Resume Builder</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Basic styling for A4 resume layout and controls */
    @page { size: A4; margin: 20mm; }
    body { margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f8f9fa; color: #333; }
    .clearfix::after { content: ''; display: table; clear: both; }
    .resume-page { width: 210mm; min-height: 297mm; margin: auto; background: #fff; position: relative; padding: 20px; box-sizing: border-box; }
    .resume-section { page-break-inside: avoid; margin-bottom: 20px; }
    /* LEFT CONTROL PANEL */
    .left-panel { float: left; width: 30%; background: #343a40; color: #fff; padding: 20px; box-sizing: border-box; height: 100vh; overflow-y: auto; }
    .left-panel h3 { margin-bottom: 15px; }
    .section-container { margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #555; }
    .section-container label { display: block; margin-bottom: 5px; font-weight: bold; }
    .section-container input, .section-container textarea { width: 100%; padding: 8px; margin-bottom: 8px; border: 1px solid #ccc; border-radius: 5px; color: #333; }
    .hidden { display: none; }
    .btn { padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; margin-bottom: 8px; font-size: 14px; width: 100%; }
    .btn-add { background: #007bff; color: white; }
    .btn-remove { background: #dc3545; color: white; }
    .dynamic-entry { border: 1px solid #ccc; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative; background: #fdfdfd; }
    .dynamic-entry .remove-entry { position: absolute; top: 5px; right: 5px; background: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer; padding: 2px 6px; font-size: 12px; }
    /* RIGHT PANEL: Resume Preview */
    .right-panel { float: left; width: 70%; height: 100vh; overflow-y: auto; }
    .resume-page h3.section-heading { font-size: 14px; font-weight: bold; text-transform: uppercase; border-bottom: 2px solid #007bff; margin-bottom: 8px; padding-bottom: 3px; letter-spacing: 1px; }
    #contact-info { text-align: center; margin-bottom: 20px; }
    #contact-info h1 { font-size: 26px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
    #contact-details-line { font-size: 14px; margin-bottom: 5px; }
    #contact-details-line span { margin: 0 5px; }
    #preview-linkedin { display: block; font-size: 14px; color: #0000ee; text-decoration: underline; word-break: break-all; }
    .toolbar { display: flex; align-items: center; background: #f2f2f2; border: 1px solid #ccc; border-radius: 4px; padding: 5px; margin-bottom: 8px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1); }
    .toolbar button { background: none; border: none; cursor: pointer; margin: 0 5px; font-size: 14px; color: #333; }
    .toolbar button:hover { color: #007bff; }
    .toolbar button .icon { font-family: sans-serif; font-weight: bold; margin-right: 2px; }
    .buttons-group { display: flex; gap: 10px; margin-top: 8px; }
    .btn-ok { background: #28a745; color: #fff; }
    .btn-cancel { background: #dc3545; color: #fff; }
    .left-panel [contenteditable="true"] { background-color: #fff; color: #333; }
  </style>
</head>
<body class="clearfix">
  <!-- Left Panel: Resume Editing Controls -->
  <div class="left-panel">
    <h3>Resume Sections</h3>
    <!-- CONTACT INFO -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-contact" onclick="toggleSection('contact')">Add Contact Info</button>
      <div id="contact-section" class="hidden">
        <label>Name</label>
        <input type="text" id="name" placeholder="Enter your name" value="<?php echo isset($resumeData['contact']['name']) ? htmlspecialchars($resumeData['contact']['name']) : ''; ?>" />
        <label>Location | Phone | Email</label>
        <input type="text" id="location" placeholder="City, State, Zip" value="<?php echo isset($resumeData['contact']['location']) ? htmlspecialchars($resumeData['contact']['location']) : ''; ?>" />
        <input type="text" id="phone" placeholder="Your Phone" value="<?php echo isset($resumeData['contact']['phone']) ? htmlspecialchars($resumeData['contact']['phone']) : ''; ?>" />
        <input type="text" id="email" placeholder="Your Email" value="<?php echo isset($resumeData['contact']['email']) ? htmlspecialchars($resumeData['contact']['email']) : ''; ?>" />
        <label>LinkedIn</label>
        <input type="text" id="linkedin" placeholder="LinkedIn Profile URL" value="<?php echo isset($resumeData['contact']['linkedin']) ? htmlspecialchars($resumeData['contact']['linkedin']) : ''; ?>" />
      </div>
    </div>
    <!-- SUMMARY with Toolbar -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-summary" onclick="toggleSection('summary')">Add Summary</button>
      <div id="summary-section" class="hidden">
        <div class="toolbar" id="summary-toolbar">
          <button data-cmd="bold"><span class="icon">B</span></button>
          <button data-cmd="italic"><span class="icon">I</span></button>
          <button data-cmd="underline"><span class="icon">U</span></button>
          <button data-cmd="strikeThrough"><span class="icon">S</span></button>
          <button data-cmd="insertUnorderedList">&bull; List</button>
          <button data-cmd="insertOrderedList">1. List</button>
          <button data-cmd="ai-summary">Generate with AI</button>
        </div>
        <label>Summary</label>
        <div id="summary-editor" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"><?php echo isset($resumeData['summary']) ? htmlspecialchars($resumeData['summary']) : ''; ?></div>
      </div>
    </div>
    <!-- EDUCATION (Dynamic) -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-education" onclick="toggleSection('education')">Add Education</button>
      <div id="education-section" class="hidden">
        <div id="education-entries">
          <?php 
          if(isset($resumeData['education']) && is_array($resumeData['education'])) {
            foreach($resumeData['education'] as $edu) {
              ?>
              <div class="dynamic-entry">
                <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('education');">X</button>
                <label>College Name</label>
                <input type="text" class="edu-college" placeholder="e.g., ABC College" value="<?php echo isset($edu['college']) ? htmlspecialchars($edu['college']) : ''; ?>" />
                <label>Duration (e.g. 2018-2022)</label>
                <input type="text" class="edu-duration" placeholder="Year(s)" value="<?php echo isset($edu['duration']) ? htmlspecialchars($edu['duration']) : ''; ?>" />
                <label>Degree & CGPA</label>
                <input type="text" class="edu-degree" placeholder="e.g., B.Tech in CSE, CGPA: 7.6" value="<?php echo isset($edu['degree']) ? htmlspecialchars($edu['degree']) : ''; ?>" />
                <label>Extra Info (optional)</label>
                <div class="toolbar edu-extra-toolbar">
                  <button data-cmd="bold"><span class="icon">B</span></button>
                  <button data-cmd="italic"><span class="icon">I</span></button>
                  <button data-cmd="underline"><span class="icon">U</span></button>
                  <button data-cmd="strikeThrough"><span class="icon">S</span></button>
                  <button data-cmd="insertUnorderedList">&bull; List</button>
                  <button data-cmd="insertOrderedList">1. List</button>
                  <button data-cmd="ai-edu-extra">Generate with AI</button>
                </div>
                <div class="edu-extra" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"><?php echo isset($edu['extra']) ? htmlspecialchars($edu['extra']) : ''; ?></div>
              </div>
              <?php
            }
          }
          ?>
        </div>
        <button class="btn btn-add" onclick="addEntry('education')">Add More Education</button>
      </div>
    </div>
    <!-- SKILLS with Toolbar -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-skills" onclick="toggleSection('skills')">Add Skills</button>
      <div id="skills-section" class="hidden">
        <div class="toolbar" id="skills-toolbar">
          <button data-cmd="bold"><span class="icon">B</span></button>
          <button data-cmd="italic"><span class="icon">I</span></button>
          <button data-cmd="underline"><span class="icon">U</span></button>
          <button data-cmd="strikeThrough"><span class="icon">S</span></button>
          <button data-cmd="insertUnorderedList">&bull; List</button>
          <button data-cmd="insertOrderedList">1. List</button>
          <button data-cmd="ai-skills">Generate with AI</button>
        </div>
        <div id="skills-editor" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"><?php echo isset($resumeData['skills']) ? htmlspecialchars($resumeData['skills']) : ''; ?></div>
        <div id="skills-entries"></div>
        <button class="btn btn-add" onclick="addEntry('skills')">Add More Skills</button>
      </div>
    </div>
    <!-- PROJECTS (Dynamic) -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-projects" onclick="toggleSection('projects')">Add Projects</button>
      <div id="projects-section" class="hidden">
        <div id="projects-entries">
          <?php 
          if(isset($resumeData['projects']) && is_array($resumeData['projects'])) {
            foreach($resumeData['projects'] as $proj) {
              ?>
              <div class="dynamic-entry project-entry">
                <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('projects');">X</button>
                <label>Project Name</label>
                <input type="text" class="proj-name" placeholder="e.g., My Web App" value="<?php echo isset($proj['title']) ? htmlspecialchars($proj['title']) : ''; ?>" />
                <label>GitHub URL</label>
                <input type="text" class="proj-link" placeholder="https://github.com/..." value="<?php echo isset($proj['link']) ? htmlspecialchars($proj['link']) : ''; ?>" />
                <label>Description</label>
                <div class="toolbar proj-desc-toolbar">
                  <button data-cmd="bold"><span class="icon">B</span></button>
                  <button data-cmd="italic"><span class="icon">I</span></button>
                  <button data-cmd="underline"><span class="icon">U</span></button>
                  <button data-cmd="strikeThrough"><span class="icon">S</span></button>
                  <button data-cmd="insertUnorderedList">&bull; List</button>
                  <button data-cmd="insertOrderedList">1. List</button>
                  <button data-cmd="ai-proj-desc">Generate with AI</button>
                </div>
                <div class="proj-desc" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"><?php echo isset($proj['desc']) ? htmlspecialchars($proj['desc']) : ''; ?></div>
                <label>Technologies Used</label>
                <input type="text" class="proj-tech" placeholder="e.g., HTML, CSS, JS" value="<?php echo isset($proj['tech']) ? htmlspecialchars($proj['tech']) : ''; ?>" />
              </div>
              <?php
            }
          }
          ?>
        </div>
        <button class="btn btn-add" onclick="addEntry('projects')">Add More Projects</button>
      </div>
    </div>
    <!-- INTERNSHIPS (Dynamic) -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-internships" onclick="toggleSection('internships')">Add Internships</button>
      <div id="internships-section" class="hidden">
        <div id="internships-entries">
          <?php 
          if(isset($resumeData['internships']) && is_array($resumeData['internships'])) {
            foreach($resumeData['internships'] as $intern) {
              ?>
              <div class="dynamic-entry internship-entry">
                <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('internships');">X</button>
                <label>Role</label>
                <input type="text" class="intern-role" placeholder="e.g., Software Intern" value="<?php echo isset($intern['role']) ? htmlspecialchars($intern['role']) : ''; ?>" />
                <label>Company</label>
                <input type="text" class="intern-company" placeholder="e.g., ABC Corp" value="<?php echo isset($intern['company']) ? htmlspecialchars($intern['company']) : ''; ?>" />
                <label>Duration</label>
                <input type="text" class="intern-duration" placeholder="e.g., 3 months" value="<?php echo isset($intern['duration']) ? htmlspecialchars($intern['duration']) : ''; ?>" />
                <label>Description</label>
                <div class="toolbar intern-desc-toolbar">
                  <button data-cmd="bold"><span class="icon">B</span></button>
                  <button data-cmd="italic"><span class="icon">I</span></button>
                  <button data-cmd="underline"><span class="icon">U</span></button>
                  <button data-cmd="strikeThrough"><span class="icon">S</span></button>
                  <button data-cmd="insertUnorderedList">&bull; List</button>
                  <button data-cmd="insertOrderedList">1. List</button>
                  <button data-cmd="ai-intern-desc">Generate with AI</button>
                </div>
                <div class="intern-desc" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"><?php echo isset($intern['desc']) ? htmlspecialchars($intern['desc']) : ''; ?></div>
              </div>
              <?php
            }
          }
          ?>
        </div>
        <button class="btn btn-add" onclick="addEntry('internships')">Add More Internships</button>
      </div>
    </div>
    <!-- CERTIFICATIONS (Dynamic) -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-certifications" onclick="toggleSection('certifications')">Add Certifications</button>
      <div id="certifications-section" class="hidden">
        <div id="certifications-entries">
          <?php 
          if(isset($resumeData['certifications']) && is_array($resumeData['certifications'])) {
            foreach($resumeData['certifications'] as $cert) {
              ?>
              <div class="dynamic-entry">
                <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('certifications');">X</button>
                <label>Certification Title</label>
                <input type="text" class="cert-title" placeholder="e.g., AWS Certified..." value="<?php echo isset($cert['title']) ? htmlspecialchars($cert['title']) : ''; ?>" />
                <label>Issuing Organization</label>
                <input type="text" class="cert-org" placeholder="e.g., Amazon" value="<?php echo isset($cert['org']) ? htmlspecialchars($cert['org']) : ''; ?>" />
                <label>Year</label>
                <input type="text" class="cert-year" placeholder="e.g., 2023" value="<?php echo isset($cert['year']) ? htmlspecialchars($cert['year']) : ''; ?>" />
              </div>
              <?php
            }
          }
          ?>
        </div>
        <button class="btn btn-add" onclick="addEntry('certifications')">Add More Certs</button>
      </div>
    </div>
    <!-- ACHIEVEMENTS (Dynamic) -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-achievements" onclick="toggleSection('achievements')">Add Achievements</button>
      <div id="achievements-section" class="hidden">
        <div id="achievements-entries">
          <?php 
          if(isset($resumeData['achievements']) && is_array($resumeData['achievements'])) {
            foreach($resumeData['achievements'] as $ach) {
              ?>
              <div class="dynamic-entry">
                <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('achievements');">X</button>
                <label>Achievement</label>
                <div class="toolbar ach-item-toolbar">
                  <button data-cmd="bold"><span class="icon">B</span></button>
                  <button data-cmd="italic"><span class="icon">I</span></button>
                  <button data-cmd="underline"><span class="icon">U</span></button>
                  <button data-cmd="strikeThrough"><span class="icon">S</span></button>
                  <button data-cmd="insertUnorderedList">&bull; List</button>
                  <button data-cmd="insertOrderedList">1. List</button>
                  <button data-cmd="ai-ach-item">Generate with AI</button>
                </div>
                <div class="ach-item" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:40px; padding:8px; margin-bottom:8px;"><?php echo isset($ach) ? htmlspecialchars($ach) : ''; ?></div>
              </div>
              <?php
            }
          }
          ?>
        </div>
        <button class="btn btn-add" onclick="addEntry('achievements')">Add More Achievements</button>
      </div>
    </div>
    <!-- OTHER FIELDS (Dynamic) -->
    <div class="section-container">
      <button class="btn btn-add" id="btn-otherfields" onclick="toggleSection('otherfields')">Add Other Fields</button>
      <div id="otherfields-section" class="hidden">
        <div id="otherfields-entries">
          <?php 
          if(isset($resumeData['otherfields']) && is_array($resumeData['otherfields'])) {
            foreach($resumeData['otherfields'] as $other) {
              ?>
              <div class="dynamic-entry">
                <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('otherfields');">X</button>
                <label>Field Heading</label>
                <input type="text" class="otherfield-heading" placeholder="e.g., Other Activities" value="<?php echo isset($other['heading']) ? htmlspecialchars($other['heading']) : ''; ?>" />
                <label>Description</label>
                <div class="toolbar otherfields-desc-toolbar">
                  <button data-cmd="bold"><span class="icon">B</span></button>
                  <button data-cmd="italic"><span class="icon">I</span></button>
                  <button data-cmd="underline"><span class="icon">U</span></button>
                  <button data-cmd="strikeThrough"><span class="icon">S</span></button>
                  <button data-cmd="insertUnorderedList">&bull; List</button>
                  <button data-cmd="insertOrderedList">1. List</button>
                  <button data-cmd="ai-other-desc">Generate with AI</button>
                </div>
                <div class="otherfield-desc" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"><?php echo isset($other['desc']) ? htmlspecialchars($other['desc']) : ''; ?></div>
              </div>
              <?php
            }
          }
          ?>
        </div>
        <button class="btn btn-add" onclick="addOtherFieldEntry()">Add More Other Fields</button>
      </div>
    </div>
  </div>

  <!-- RIGHT PANEL: A4 Resume Preview -->
  <div class="right-panel">
    <div class="resume-page" id="resume-content">
      <!-- CONTACT INFO -->
      <div id="contact-info" class="resume-section hidden">
        <h1 id="preview-name"><?php echo isset($resumeData['contact']['name']) ? htmlspecialchars($resumeData['contact']['name']) : 'Your Name'; ?></h1>
        <div id="contact-details-line">
          <span id="preview-location"><?php echo isset($resumeData['contact']['location']) ? htmlspecialchars($resumeData['contact']['location']) : ''; ?></span> |
          <span id="preview-phone"><?php echo isset($resumeData['contact']['phone']) ? htmlspecialchars($resumeData['contact']['phone']) : ''; ?></span> |
          <span id="preview-email"><?php echo isset($resumeData['contact']['email']) ? htmlspecialchars($resumeData['contact']['email']) : ''; ?></span>
        </div>
        <a href="#" target="_blank" id="preview-linkedin"><?php echo isset($resumeData['contact']['linkedin']) ? htmlspecialchars($resumeData['contact']['linkedin']) : ''; ?></a>
      </div>

      <!-- SUMMARY -->
      <div id="preview-summary-section" class="resume-section hidden">
        <h3 class="section-heading">SUMMARY</h3>
        <div id="preview-summary" style="margin-left:10px;"><?php echo isset($resumeData['summary']) ? htmlspecialchars($resumeData['summary']) : ''; ?></div>
      </div>

      <!-- EDUCATION -->
      <div id="preview-education-section" class="resume-section hidden">
        <h3 class="section-heading">EDUCATION</h3>
        <div id="preview-education">
          <?php 
          if(isset($resumeData['education']) && is_array($resumeData['education'])) {
            foreach($resumeData['education'] as $edu) {
              echo '<div style="margin-bottom:10px;">';
              echo '<div style="display:flex; justify-content:space-between; font-weight:bold;">';
              echo '<div>' . htmlspecialchars($edu['college']) . '</div>';
              echo '<div>' . htmlspecialchars($edu['duration']) . '</div>';
              echo '</div>';
              echo '<div style="margin-left:15px;">' . htmlspecialchars($edu['degree']) . '</div>';
              if (!empty($edu['extra'])) {
                echo '<div style="margin-left:15px;">' . htmlspecialchars($edu['extra']) . '</div>';
              }
              echo '</div>';
            }
          }
          ?>
        </div>
      </div>

      <!-- SKILLS -->
      <div id="preview-skills-section" class="resume-section hidden">
        <h3 class="section-heading">SKILLS</h3>
        <div id="preview-skills" style="margin-left:10px;"><?php echo isset($resumeData['skills']) ? htmlspecialchars($resumeData['skills']) : ''; ?></div>
      </div>

      <!-- PROJECTS -->
      <div id="preview-projects-section" class="resume-section hidden">
        <h3 class="section-heading">PROJECTS</h3>
        <div id="preview-projects">
          <?php 
          if(isset($resumeData['projects']) && is_array($resumeData['projects'])) {
            foreach($resumeData['projects'] as $proj) {
              echo '<div class="project-entry" style="margin-bottom:10px;">';
              echo '<span class="project-title">' . htmlspecialchars($proj['title']) . '</span>';
              if (!empty($proj['link'])) {
                echo ' <a class="project-link" href="' . htmlspecialchars($proj['link']) . '" target="_blank">' . htmlspecialchars($proj['link']) . '</a>';
              }
              echo '<div class="project-desc" style="margin-left:20px; margin-top:2px;">' . htmlspecialchars($proj['desc']) . '</div>';
              if (!empty($proj['tech'])) {
                echo '<div class="project-tech" style="margin-left:20px; margin-top:2px; font-style:italic;">Technologies Used: ' . htmlspecialchars($proj['tech']) . '</div>';
              }
              echo '</div>';
            }
          }
          ?>
        </div>
      </div>

      <!-- INTERNSHIPS -->
      <div id="preview-internships-section" class="resume-section hidden">
        <h3 class="section-heading">INTERNSHIPS</h3>
        <div id="preview-internships">
          <?php 
          if(isset($resumeData['internships']) && is_array($resumeData['internships'])) {
            foreach($resumeData['internships'] as $intern) {
              echo '<div class="internship-entry" style="margin-bottom:10px;">';
              echo '<div style="display:flex; justify-content:space-between; font-weight:bold;">';
              echo '<div>' . htmlspecialchars($intern['role']) . '</div>';
              echo '<div>' . htmlspecialchars($intern['company']) . '</div>';
              echo '</div>';
              echo '<div style="margin-left:20px; margin-top:2px;">(' . htmlspecialchars($intern['duration']) . ')<br>' . htmlspecialchars($intern['desc']) . '</div>';
              echo '</div>';
            }
          }
          ?>
        </div>
      </div>

      <!-- CERTIFICATIONS -->
      <div id="preview-certifications-section" class="resume-section hidden">
        <h3 class="section-heading">CERTIFICATIONS</h3>
        <ul id="preview-certifications" class="cert-list">
          <?php 
          if(isset($resumeData['certifications']) && is_array($resumeData['certifications'])) {
            foreach($resumeData['certifications'] as $cert) {
              echo '<li>' . htmlspecialchars($cert['title']) . ' - ' . htmlspecialchars($cert['org']) . ' (' . htmlspecialchars($cert['year']) . ')</li>';
            }
          }
          ?>
        </ul>
      </div>

      <!-- ACHIEVEMENTS -->
      <div id="preview-achievements-section" class="resume-section hidden">
        <h3 class="section-heading">ACHIEVEMENTS</h3>
        <ul id="preview-achievements" class="achieve-list">
          <?php 
          if(isset($resumeData['achievements']) && is_array($resumeData['achievements'])) {
            foreach($resumeData['achievements'] as $ach) {
              echo '<li>' . htmlspecialchars($ach) . '</li>';
            }
          }
          ?>
        </ul>
      </div>

      <!-- OTHER FIELDS PREVIEW -->
      <div id="preview-otherfields-section" class="resume-section hidden">
        <div id="preview-otherfields">
          <?php 
          if(isset($resumeData['otherfields']) && is_array($resumeData['otherfields'])) {
            foreach($resumeData['otherfields'] as $other) {
              echo '<div style="margin-bottom:10px;">';
              echo '<h3 class="section-heading">' . htmlspecialchars($other['heading']) . '</h3>';
              echo '<div style="margin-left:15px;">' . htmlspecialchars($other['desc']) . '</div>';
              echo '</div>';
            }
          }
          ?>
        </div>
      </div>
    </div>
    <!-- DOWNLOAD & SAVE Buttons -->
    <div class="download-buttons" style="display: flex; gap: 10px; margin-top:20px;">
      <button id="download-pdf" class="btn btn-ok">Download as PDF</button>
      <button id="download-doc" class="btn btn-ok">Download as DOC</button>
      <button id="save-btn" class="btn btn-ok">Save</button>
    </div>
  </div>
  
  <!-- Include jQuery and html2pdf libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script src="https://unpkg.com/mammoth@1.4.8/mammoth.browser.min.js"></script>
  <script>
    /**************************************************************
     * TOGGLE SECTIONS: Show/Hide input + preview, change btn text,
     * and for dynamic sections, add a default entry if none exists.
     **************************************************************/
    function toggleSection(section) {
      const inputDiv = document.getElementById(`${section}-section`);
      const btn = document.getElementById(`btn-${section}`);
      let previewDiv = document.getElementById(`preview-${section}-section`);
      if (section === 'contact') {
        previewDiv = document.getElementById('contact-info');
      }
      inputDiv.classList.toggle('hidden');
      previewDiv.classList.toggle('hidden');
      if (!inputDiv.classList.contains('hidden')) {
        // For dynamic sections, if no entry exists, add one default entry.
        let container;
        if (section === 'education') container = document.getElementById('education-entries');
        else if (section === 'projects') container = document.getElementById('projects-entries');
        else if (section === 'internships') container = document.getElementById('internships-entries');
        else if (section === 'certifications') container = document.getElementById('certifications-entries');
        else if (section === 'achievements') container = document.getElementById('achievements-entries');
        else if (section === 'otherfields') container = document.getElementById('otherfields-entries');
        if (container && container.children.length === 0) {
          if(section === 'otherfields'){
            addOtherFieldEntry();
          } else {
            addEntry(section);
          }
        }
        btn.textContent = `Remove ${capitalize(section)}`;
        btn.classList.remove('btn-add');
        btn.classList.add('btn-remove');
      } else {
        btn.textContent = `Add ${capitalize(section)}`;
        btn.classList.remove('btn-remove');
        btn.classList.add('btn-add');
      }
    }
    function capitalize(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    }
    /**************************************************************
     * BASIC WYSIWYG for static toolbars
     **************************************************************/
    function setupToolbar(toolbarId, editorId) {
      const toolbar = document.getElementById(toolbarId);
      const editor = document.getElementById(editorId);
      toolbar.querySelectorAll('button[data-cmd]').forEach(btn => {
        btn.addEventListener('click', () => {
          const cmd = btn.getAttribute('data-cmd');
          if (cmd.includes('ai-')) {
            alert('Generate with AI clicked! (placeholder)');
            return;
          }
          document.execCommand(cmd, false, null);
          editor.focus();
        });
      });
    }
    /**************************************************************
     * DELEGATED TOOLBAR HANDLER for dynamic entries
     **************************************************************/
    $(document).on('click', '.toolbar button[data-cmd]', function() {
      const cmd = $(this).attr('data-cmd');
      if(cmd.startsWith('ai-')) {
        alert('Generate with AI clicked! (placeholder)');
        return;
      }
      const $toolbar = $(this).closest('.toolbar');
      const $editor = $toolbar.next('[contenteditable]');
      document.execCommand(cmd, false, null);
      $editor.focus();
    });
    /**************************************************************
     * ADD ENTRIES FOR DYNAMIC SECTIONS
     **************************************************************/
    function addEntry(section) {
      let html = '';
      if (section === 'education') {
        html = `
          <div class="dynamic-entry">
            <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('education');">X</button>
            <label>College Name</label>
            <input type="text" class="edu-college" placeholder="e.g., ABC College" />
            <label>Duration (e.g. 2018-2022)</label>
            <input type="text" class="edu-duration" placeholder="Year(s)" />
            <label>Degree & CGPA</label>
            <input type="text" class="edu-degree" placeholder="e.g., B.Tech in CSE, CGPA: 7.6" />
            <label>Extra Info (optional)</label>
            <div class="toolbar edu-extra-toolbar">
              <button data-cmd="bold"><span class="icon">B</span></button>
              <button data-cmd="italic"><span class="icon">I</span></button>
              <button data-cmd="underline"><span class="icon">U</span></button>
              <button data-cmd="strikeThrough"><span class="icon">S</span></button>
              <button data-cmd="insertUnorderedList">&bull; List</button>
              <button data-cmd="insertOrderedList">1. List</button>
              <button data-cmd="ai-edu-extra">Generate with AI</button>
            </div>
            <div class="edu-extra" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;" placeholder="Place, Achievements..."></div>
          </div>
        `;
        document.getElementById('education-entries').insertAdjacentHTML('beforeend', html);
      } else if (section === 'skills') {
        html = `
          <div class="dynamic-entry">
            <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('skills');">X</button>
            <label>Skill</label>
            <input type="text" class="skill-item" placeholder="e.g., JavaScript" />
          </div>
        `;
        document.getElementById('skills-entries').insertAdjacentHTML('beforeend', html);
      } else if (section === 'projects') {
        html = `
          <div class="dynamic-entry project-entry">
            <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('projects');">X</button>
            <label>Project Name</label>
            <input type="text" class="proj-name" placeholder="e.g., My Web App" />
            <label>GitHub URL</label>
            <input type="text" class="proj-link" placeholder="https://github.com/..." />
            <label>Description</label>
            <div class="toolbar proj-desc-toolbar">
              <button data-cmd="bold"><span class="icon">B</span></button>
              <button data-cmd="italic"><span class="icon">I</span></button>
              <button data-cmd="underline"><span class="icon">U</span></button>
              <button data-cmd="strikeThrough"><span class="icon">S</span></button>
              <button data-cmd="insertUnorderedList">&bull; List</button>
              <button data-cmd="insertOrderedList">1. List</button>
              <button data-cmd="ai-proj-desc">Generate with AI</button>
            </div>
            <div class="proj-desc" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;" placeholder="Brief project description"></div>
            <label>Technologies Used</label>
            <input type="text" class="proj-tech" placeholder="e.g., HTML, CSS, JS" />
          </div>
        `;
        document.getElementById('projects-entries').insertAdjacentHTML('beforeend', html);
      } else if (section === 'internships') {
        html = `
          <div class="dynamic-entry internship-entry">
            <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('internships');">X</button>
            <label>Role</label>
            <input type="text" class="intern-role" placeholder="e.g., Software Intern" />
            <label>Company</label>
            <input type="text" class="intern-company" placeholder="e.g., ABC Corp" />
            <label>Duration</label>
            <input type="text" class="intern-duration" placeholder="e.g., 3 months" />
            <label>Description</label>
            <div class="toolbar intern-desc-toolbar">
              <button data-cmd="bold"><span class="icon">B</span></button>
              <button data-cmd="italic"><span class="icon">I</span></button>
              <button data-cmd="underline"><span class="icon">U</span></button>
              <button data-cmd="strikeThrough"><span class="icon">S</span></button>
              <button data-cmd="insertUnorderedList">&bull; List</button>
              <button data-cmd="insertOrderedList">1. List</button>
              <button data-cmd="ai-intern-desc">Generate with AI</button>
            </div>
            <div class="intern-desc" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;" placeholder="Brief internship details"></div>
          </div>
        `;
        document.getElementById('internships-entries').insertAdjacentHTML('beforeend', html);
      } else if (section === 'certifications') {
        html = `
          <div class="dynamic-entry">
            <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('certifications');">X</button>
            <label>Certification Title</label>
            <input type="text" class="cert-title" placeholder="e.g., AWS Certified..." />
            <label>Issuing Organization</label>
            <input type="text" class="cert-org" placeholder="e.g., Amazon" />
            <label>Year</label>
            <input type="text" class="cert-year" placeholder="e.g., 2023" />
          </div>
        `;
        document.getElementById('certifications-entries').insertAdjacentHTML('beforeend', html);
      } else if (section === 'achievements') {
        html = `
          <div class="dynamic-entry">
            <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('achievements');">X</button>
            <label>Achievement</label>
            <div class="toolbar ach-item-toolbar">
              <button data-cmd="bold"><span class="icon">B</span></button>
              <button data-cmd="italic"><span class="icon">I</span></button>
              <button data-cmd="underline"><span class="icon">U</span></button>
              <button data-cmd="strikeThrough"><span class="icon">S</span></button>
              <button data-cmd="insertUnorderedList">&bull; List</button>
              <button data-cmd="insertOrderedList">1. List</button>
              <button data-cmd="ai-ach-item">Generate with AI</button>
            </div>
            <div class="ach-item" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:40px; padding:8px; margin-bottom:8px;"></div>
          </div>
        `;
        document.getElementById('achievements-entries').insertAdjacentHTML('beforeend', html);
      } else if (section === 'otherfields') {
        html = `
          <div class="dynamic-entry">
            <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('otherfields');">X</button>
            <label>Field Heading</label>
            <input type="text" class="otherfield-heading" placeholder="e.g., Other Activities" />
            <label>Description</label>
            <div class="toolbar otherfields-desc-toolbar">
              <button data-cmd="bold"><span class="icon">B</span></button>
              <button data-cmd="italic"><span class="icon">I</span></button>
              <button data-cmd="underline"><span class="icon">U</span></button>
              <button data-cmd="strikeThrough"><span class="icon">S</span></button>
              <button data-cmd="insertUnorderedList">&bull; List</button>
              <button data-cmd="insertOrderedList">1. List</button>
              <button data-cmd="ai-other-desc">Generate with AI</button>
            </div>
            <div class="otherfield-desc" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"></div>
          </div>
        `;
        document.getElementById('otherfields-entries').insertAdjacentHTML('beforeend', html);
      }
    }

    function addOtherFieldEntry() {
      let html = `
        <div class="dynamic-entry">
          <button class="remove-entry" onclick="$(this).parent().remove(); updatePreview('otherfields');">X</button>
          <label>Field Heading</label>
          <input type="text" class="otherfield-heading" placeholder="e.g., Other Activities" />
          <label>Description</label>
          <div class="toolbar otherfields-desc-toolbar">
            <button data-cmd="bold"><span class="icon">B</span></button>
            <button data-cmd="italic"><span class="icon">I</span></button>
            <button data-cmd="underline"><span class="icon">U</span></button>
            <button data-cmd="strikeThrough"><span class="icon">S</span></button>
            <button data-cmd="insertUnorderedList">&bull; List</button>
            <button data-cmd="insertOrderedList">1. List</button>
            <button data-cmd="ai-other-desc">Generate with AI</button>
          </div>
          <div class="otherfield-desc" contenteditable="true" style="border:1px solid #ccc; border-radius:5px; min-height:80px; padding:8px; margin-bottom:8px;"></div>
        </div>
      `;
      document.getElementById('otherfields-entries').insertAdjacentHTML('beforeend', html);
    }

    /**************************************************************
     * UPDATE PREVIEW: As the user types, reflect changes
     **************************************************************/
    function updatePreview(section) {
      if (section === 'education') {
        const container = document.getElementById('preview-education');
        container.innerHTML = '';
        const entries = document.querySelectorAll('#education-entries .dynamic-entry');
        entries.forEach(entry => {
          const college = entry.querySelector('.edu-college').value;
          const duration = entry.querySelector('.edu-duration').value;
          const degree = entry.querySelector('.edu-degree').value;
          const extraElem = entry.querySelector('.edu-extra');
          const extra = extraElem ? (extraElem.value || extraElem.innerHTML) : '';
          if (college || duration || degree || extra) {
            const eduHTML = `
              <div style="margin-bottom:10px;">
                <div style="display:flex; justify-content:space-between; font-weight:bold;">
                  <div>${college}</div>
                  <div>${duration}</div>
                </div>
                <div style="margin-left:15px;">${degree}</div>
                ${extra ? `<div style="margin-left:15px;">${extra}</div>` : ''}
              </div>
            `;
            container.insertAdjacentHTML('beforeend', eduHTML);
          }
        });
      } else if (section === 'skills') {
        const container = document.getElementById('preview-skills');
        container.innerHTML = '';
        container.insertAdjacentHTML('beforeend', document.getElementById('skills-editor').innerHTML);
        const entries = document.querySelectorAll('#skills-entries .dynamic-entry');
        entries.forEach(entry => {
          const skill = entry.querySelector('.skill-item').value;
          if (skill) {
            container.insertAdjacentHTML('beforeend', `<p>&bull; ${skill}</p>`);
          }
        });
      } else if (section === 'projects') {
        const container = document.getElementById('preview-projects');
        container.innerHTML = '';
        const entries = document.querySelectorAll('#projects-entries .dynamic-entry');
        entries.forEach(entry => {
          const title = entry.querySelector('.proj-name').value;
          const link = entry.querySelector('.proj-link').value;
          const descElem = entry.querySelector('.proj-desc');
          const desc = descElem ? (descElem.value || descElem.innerHTML) : '';
          const tech = entry.querySelector('.proj-tech').value;
          if (title || link || desc || tech) {
            const projectHTML = `
              <div class="project-entry" style="margin-bottom:10px;">
                <span class="project-title">${title}</span>
                ${link ? ` <a class="project-link" href="${link}" target="_blank">${link}</a>` : ''}
                <div class="project-desc" style="margin-left:20px; margin-top:2px;">${desc}</div>
                ${tech ? `<div class="project-tech" style="margin-left:20px; margin-top:2px; font-style:italic;">Technologies Used: ${tech}</div>` : ''}
              </div>
            `;
            container.insertAdjacentHTML('beforeend', projectHTML);
          }
        });
      } else if (section === 'internships') {
        const container = document.getElementById('preview-internships');
        container.innerHTML = '';
        const entries = document.querySelectorAll('#internships-entries .dynamic-entry');
        entries.forEach(entry => {
          const role = entry.querySelector('.intern-role').value;
          const company = entry.querySelector('.intern-company').value;
          const duration = entry.querySelector('.intern-duration').value;
          const descElem = entry.querySelector('.intern-desc');
          const desc = descElem ? (descElem.value || descElem.innerHTML) : '';
          if (role || company || duration || desc) {
            const internHTML = `
              <div class="internship-entry" style="margin-bottom:10px;">
                <div style="display:flex; justify-content:space-between; font-weight:bold;">
                  <div>${role}</div>
                  <div>${company}</div>
                </div>
                <div style="margin-left:20px; margin-top:2px;">(${duration})<br>${desc}</div>
              </div>
            `;
            container.insertAdjacentHTML('beforeend', internHTML);
          }
        });
      } else if (section === 'certifications') {
        const list = document.getElementById('preview-certifications');
        list.innerHTML = '';
        const entries = document.querySelectorAll('#certifications-entries .dynamic-entry');
        entries.forEach(entry => {
          const title = entry.querySelector('.cert-title').value;
          const org = entry.querySelector('.cert-org').value;
          const year = entry.querySelector('.cert-year').value;
          if (title || org || year) {
            const li = document.createElement('li');
            li.textContent = `${title} - ${org} (${year})`;
            list.appendChild(li);
          }
        });
      } else if (section === 'achievements') {
        const list = document.getElementById('preview-achievements');
        list.innerHTML = '';
        const entries = document.querySelectorAll('#achievements-entries .dynamic-entry');
        entries.forEach(entry => {
          const achElem = entry.querySelector('.ach-item');
          const item = achElem ? (achElem.value || achElem.innerHTML) : '';
          if (item) {
            const li = document.createElement('li');
            li.textContent = item;
            list.appendChild(li);
          }
        });
      } else if (section === 'otherfields') {
        const container = document.getElementById('preview-otherfields');
        container.innerHTML = '';
        const entries = document.querySelectorAll('#otherfields-entries .dynamic-entry');
        entries.forEach(entry => {
          const heading = entry.querySelector('.otherfield-heading').value;
          const descElem = entry.querySelector('.otherfield-desc');
          const desc = descElem ? (descElem.value || descElem.innerHTML) : '';
          if (heading || desc) {
            const fieldHTML = `
              <div style="margin-bottom:10px;">
                <h3 class="section-heading">${heading}</h3>
                <div style="margin-left:15px;">${desc}</div>
              </div>
            `;
            container.insertAdjacentHTML('beforeend', fieldHTML);
          }
        });
      }
    }

    /**************************************************************
     * DYNAMIC UPDATES ON INPUT
     **************************************************************/
    $(document).ready(function() {
      // CONTACT
      $('#name, #location, #phone, #email, #linkedin').on('input', function() {
        $('#preview-name').text($('#name').val().toUpperCase());
        $('#preview-location').text($('#location').val());
        $('#preview-phone').text($('#phone').val());
        $('#preview-email').text($('#email').val());
        const linkVal = $('#linkedin').val();
        $('#preview-linkedin').text(linkVal).attr('href', linkVal);
      });

      // Setup static toolbars for Summary and Skills
      setupToolbar('summary-toolbar', 'summary-editor');
      $('#summary-editor').on('input', function() {
        $('#preview-summary').html($(this).html());
      });
      setupToolbar('skills-toolbar', 'skills-editor');
      $('#skills-editor').on('input', function() {
        updatePreview('skills');
      });

      // Education dynamic inputs
      $(document).on('input', '.edu-college, .edu-duration, .edu-degree, .edu-extra', function() {
        updatePreview('education');
      });
      // Skills dynamic entries
      $(document).on('input', '.skill-item', function() {
        updatePreview('skills');
      });
      // Projects dynamic inputs
      $(document).on('input', '.proj-name, .proj-link, .proj-desc, .proj-tech', function() {
        updatePreview('projects');
      });
      // Internships dynamic inputs
      $(document).on('input', '.intern-role, .intern-company, .intern-duration, .intern-desc', function() {
        updatePreview('internships');
      });
      // Certifications dynamic inputs
      $(document).on('input', '.cert-title, .cert-org, .cert-year', function() {
        updatePreview('certifications');
      });
      // Achievements dynamic inputs
      $(document).on('input', '.ach-item', function() {
        updatePreview('achievements');
      });
      // Other Fields dynamic inputs
      $(document).on('input', '.otherfield-heading, .otherfield-desc', function() {
        updatePreview('otherfields');
      });
    });

    /**************************************************************
     * DOWNLOAD FUNCTIONS
     **************************************************************/
    // Download as PDF using html2pdf
    document.getElementById('download-pdf').addEventListener('click', function() {
      var element = document.getElementById('resume-content');
      html2pdf().from(element).save('resume.pdf');
    });

    // Download as DOCX using Mammoth.js
    document.getElementById('download-doc').addEventListener('click', function() {
      var content = document.getElementById('resume-content').innerHTML;
      mammoth.convertToDocx({value: content})
        .then(function(result) {
            var blob = result.value; // The DOCX file as a Blob
            var url = URL.createObjectURL(blob);
            var link = document.createElement('a');
            link.href = url;
            link.download = 'resume.docx';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch(function(error) {
            console.error('Error converting HTML to DOCX:', error);
            alert('Error converting HTML to DOCX. Please try again.');
        });
    });

    /**************************************************************
     * SAVE FUNCTION: Sends the DOCX file to the server
     **************************************************************/
    document.getElementById('save-btn').addEventListener('click', function() {
      var content = document.getElementById('resume-content').innerHTML;
      mammoth.convertToDocx({value: content})
        .then(function(result) {
            var blob = result.value; // The DOCX file as a Blob
            
            // Create a FormData object to send the file to the server
            var formData = new FormData();
            formData.append('resume_docx', blob, 'resume.docx');
            
            // Send the DOCX file to the server via AJAX
            $.ajax({
                url: 'save_resume.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert('Resume saved successfully!');
                        } else {
                            alert('Error: ' + res.message);
                        }
                    } catch(e) {
                        alert('Unexpected error: ' + e);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error saving resume.');
                }
            });
        })
        .catch(function(error) {
            console.error('Error converting HTML to DOCX:', error);
            alert('Error converting HTML to DOCX. Please try again.');
        });
    });
  </script>
</body>
</html>