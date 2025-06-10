<?php include 'includes/header.php'; ?>

<h1>Create New Resume</h1>
<form action="save_resume.php" method="post">
    <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name" id="full_name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control">
    </div>
    <div class="form-group">
        <label for="education">Education</label>
        <textarea name="education" id="education" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="experience">Experience</label>
        <textarea name="experience" id="experience" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="skills">Skills</label>
        <textarea name="skills" id="skills" class="form-control" rows="2"></textarea>
    </div>
    <div class="form-group">
        <label for="projects">Projects</label>
        <textarea name="projects" id="projects" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="template_used">Select Template</label>
        <select name="template_used" id="template_used" class="form-control">
            <option value="template1">Template 1</option>
            <option value="template2">Template 2</option>
            <!-- Add additional templates as needed -->
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save Resume</button>
</form>

<?php include 'includes/footer.php'; ?>
