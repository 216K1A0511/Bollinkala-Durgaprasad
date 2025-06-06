import React, { useState } from 'react';
import axios from 'axios';

const QuestionGenerator = () => {
  const [formData, setFormData] = useState({
    type: 'part1',
    difficulty: 'medium',
    topic: 'technology'
  });
  const [questions, setQuestions] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const generateQuestions = async () => {
    setLoading(true);
    setError(null);
    try {
      const response = await axios.post(
        'http://localhost:5000/api/ai-questions',
        formData,
        {
          headers: {
            'Content-Type': 'application/json'
          }
        }
      );

      if (response.data.error) {
        setError(response.data.error);
      } else {
        setQuestions(response.data.questions);
      }
    } catch (err) {
      setError(err.response?.data?.error || 
               err.message || 
               'Failed to generate questions. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="question-generator">
      <div className="controls">
        <div className="form-group">
          <label>Question Type:</label>
          <select name="type" value={formData.type} onChange={handleChange}>
            <option value="part1">Part 1 (General)</option>
            <option value="part2">Part 2 (Cue Card)</option>
            <option value="part3">Part 3 (Discussion)</option>
          </select>
        </div>
        
        <div className="form-group">
          <label>Difficulty:</label>
          <select name="difficulty" value={formData.difficulty} onChange={handleChange}>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
          </select>
        </div>
        
        <div className="form-group">
          <label>Topic:</label>
          <input 
            type="text" 
            name="topic" 
            value={formData.topic}
            onChange={handleChange}
            placeholder="Enter a topic"
          />
        </div>
        
        <button 
          onClick={generateQuestions} 
          disabled={loading}
          className="generate-btn"
        >
          {loading ? 'Generating...' : 'Generate Questions'}
        </button>
      </div>
      
      {error && <div className="error-message">{error}</div>}
      
      <div className="questions-list">
        <h2>Generated Questions:</h2>
        {questions.length > 0 ? (
          <ul>
            {questions.map((question, index) => (
              <li key={index}>{question}</li>
            ))}
          </ul>
        ) : (
          <p>No questions generated yet. Click the button above to get started.</p>
        )}
      </div>
    </div>
  );
};

export default QuestionGenerator;