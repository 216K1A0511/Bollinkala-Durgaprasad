import React, { useState } from 'react';
import axios from 'axios';
import PropTypes from 'prop-types';
import './TestSubmissionForm.css';

const TestSubmissionForm = ({ initialData, onSubmit, onSuccess, onError }) => {
  const [formData, setFormData] = useState(initialData || {
    questionId: '',
    userId: '',
    response: '',
    comments: ''
  });
  const [submissionStatus, setSubmissionStatus] = useState({
    submitted: false,
    success: false,
    message: ''
  });
  const [errors, setErrors] = useState({});
  const [isLoading, setIsLoading] = useState(false);
  const [charCount, setCharCount] = useState(0);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    
    if (name === 'response') {
      setCharCount(value.length);
    }
  };

  const validateForm = () => {
    const newErrors = {};
    if (!formData.questionId.trim()) {
      newErrors.questionId = 'Question ID is required';
    }
    if (!formData.response.trim()) {
      newErrors.response = 'Response is required';
    } else if (formData.response.trim().length < 20) {
      newErrors.response = 'Response must be at least 20 characters';
    } else if (formData.response.trim().length > 1000) {
      newErrors.response = 'Response must be less than 1000 characters';
    }
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleReset = () => {
    setFormData(initialData || {
      questionId: '',
      userId: '',
      response: '',
      comments: ''
    });
    setErrors({});
    setSubmissionStatus({
      submitted: false,
      success: false,
      message: ''
    });
    setCharCount(0);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (!validateForm()) return;
    
    setIsLoading(true);
    try {
      // Use custom onSubmit if provided, otherwise use default
      if (onSubmit) {
        await onSubmit(formData);
      } else {
        const response = await axios.post('http://localhost:5000/submit', formData, {
          headers: {
            'Content-Type': 'application/json'
          },
          validateStatus: (status) => status < 500 // Reject only if status is >= 500
        });
        
        console.log('API Response:', response); // Debugging log
        
        if (response.status >= 400) {
          throw new Error(response.data?.message || 'Invalid request');
        }
      }
      
      setSubmissionStatus({
        submitted: true,
        success: true,
        message: 'Test submitted successfully!'
      });
      
      handleReset();
      
      if (onSuccess) onSuccess(formData);
      
    } catch (error) {
      console.error('Submission error:', error); // Debugging log
      let errorMessage = 'Submission failed. Please try again.';
      
      if (error.response) {
        console.log('Error response data:', error.response.data);
        errorMessage = error.response.data?.message || errorMessage;
      } else if (error.request) {
        console.log('No response received');
        errorMessage = 'Network error. Please check your connection.';
      } else {
        console.log('Error message:', error.message);
      }
      
      setSubmissionStatus({
        submitted: true,
        success: false,
        message: errorMessage
      });
      
      if (onError) onError(error, formData);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="test-submission-form">
      <h2>Submit Your Test Response</h2>
      
      {submissionStatus.submitted && (
        <div className={`alert ${submissionStatus.success ? 'success' : 'error'}`}>
          {submissionStatus.message}
        </div>
      )}
      
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="questionId">Question ID *</label>
          <input
            type="text"
            id="questionId"
            name="questionId"
            value={formData.questionId}
            onChange={handleChange}
            className={errors.questionId ? 'error' : ''}
          />
          {errors.questionId && <span className="error-message">{errors.questionId}</span>}
        </div>
        
        <div className="form-group">
          <label htmlFor="userId">User ID</label>
          <input
            type="text"
            id="userId"
            name="userId"
            value={formData.userId}
            onChange={handleChange}
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="response">Your Response *</label>
          <textarea
            id="response"
            name="response"
            value={formData.response}
            onChange={handleChange}
            rows="6"
            className={errors.response ? 'error' : ''}
          />
          <div className="char-count">
            {charCount}/1000 characters
            {charCount > 1000 && <span className="error-message"> (Maximum exceeded)</span>}
          </div>
          {errors.response && <span className="error-message">{errors.response}</span>}
        </div>
        
        <div className="form-group">
          <label htmlFor="comments">Additional Comments</label>
          <textarea
            id="comments"
            name="comments"
            value={formData.comments}
            onChange={handleChange}
            rows="3"
          />
        </div>
        
        <div className="form-actions">
          <button 
            type="submit" 
            className="submit-button" 
            disabled={isLoading}
          >
            {isLoading ? 'Submitting...' : 'Submit Response'}
          </button>
          <button 
            type="button" 
            className="reset-button"
            onClick={handleReset}
            disabled={isLoading}
          >
            Reset Form
          </button>
        </div>
      </form>
    </div>
  );
};

TestSubmissionForm.propTypes = {
  initialData: PropTypes.shape({
    questionId: PropTypes.string,
    userId: PropTypes.string,
    response: PropTypes.string,
    comments: PropTypes.string
  }),
  onSubmit: PropTypes.func,
  onSuccess: PropTypes.func,
  onError: PropTypes.func
};

export default TestSubmissionForm;