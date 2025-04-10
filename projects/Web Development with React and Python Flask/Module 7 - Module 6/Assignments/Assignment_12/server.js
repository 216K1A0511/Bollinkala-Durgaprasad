const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');

const app = express();

// Middleware
app.use(cors());
app.use(bodyParser.json());

// In-memory storage (replace with database in production)
let submissions = [];

// POST endpoint for form submissions
app.post('/submit', (req, res) => {
    try {
        // Validate required fields
        if (!req.body.questionId || !req.body.response) {
            return res.status(400).json({
                success: false,
                message: 'Question ID and Response are required fields'
            });
        }

        // Create submission object
        const submission = {
            id: Date.now().toString(),
            timestamp: new Date().toISOString(),
            questionId: req.body.questionId,
            userId: req.body.userId || 'anonymous',
            response: req.body.response,
            comments: req.body.comments || ''
        };

        // Add to submissions array
        submissions.push(submission);

        // Save to file (for persistence between server restarts)
        saveSubmissionsToFile();

        // Success response
        res.status(201).json({
            success: true,
            message: 'Submission received successfully',
            data: submission
        });

    } catch (error) {
        console.error('Error processing submission:', error);
        res.status(500).json({
            success: false,
            message: 'Internal server error'
        });
    }
});

// GET endpoint to view submissions (for testing)
app.get('/submissions', (req, res) => {
    res.json({
        success: true,
        count: submissions.length,
        data: submissions
    });
});

// Helper function to save submissions to file
function saveSubmissionsToFile() {
    const data = JSON.stringify(submissions, null, 2);
    fs.writeFileSync('submissions.json', data);
}

// Helper function to load submissions from file
function loadSubmissionsFromFile() {
    try {
        const data = fs.readFileSync('submissions.json', 'utf8');
        submissions = JSON.parse(data);
    } catch (err) {
        if (err.code === 'ENOENT') {
            console.log('No existing submissions file found. Starting fresh.');
        } else {
            console.error('Error loading submissions:', err);
        }
    }
}

// Load existing submissions when server starts
loadSubmissionsFromFile();

// Start the server
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
    console.log(`POST endpoint: http://localhost:${PORT}/submit`);
    console.log(`GET submissions: http://localhost:${PORT}/submissions`);
});