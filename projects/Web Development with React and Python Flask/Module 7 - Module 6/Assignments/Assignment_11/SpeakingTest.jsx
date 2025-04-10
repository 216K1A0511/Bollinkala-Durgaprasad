import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './SpeakingTest.css';

const SpeakingTest = () => {
    const [questions, setQuestions] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);

    useEffect(() => {
        const fetchQuestions = async () => {
            try {
                const response = await axios.get('http://localhost:5000/api/speaking-tests');
                setQuestions(response.data);
                setLoading(false);
            } catch (err) {
                setError(err.message);
                setLoading(false);
            }
        };

        fetchQuestions();
    }, []);

    const handleNextQuestion = () => {
        if (currentQuestionIndex < questions.length - 1) {
            setCurrentQuestionIndex(currentQuestionIndex + 1);
        }
    };

    const handlePreviousQuestion = () => {
        if (currentQuestionIndex > 0) {
            setCurrentQuestionIndex(currentQuestionIndex - 1);
        }
    };

    if (loading) {
        return (
            <div className="loading-container">
                <div className="spinner"></div>
                <p>Loading questions...</p>
            </div>
        );
    }

    if (error) {
        return (
            <div className="error-container">
                <p>Error fetching questions: {error}</p>
                <button 
                    className="retry-button"
                    onClick={() => window.location.reload()}
                >
                    Retry
                </button>
            </div>
        );
    }

    if (questions.length === 0) {
        return (
            <div className="no-questions">
                <p>No questions available at the moment.</p>
            </div>
        );
    }

    const currentQuestion = questions[currentQuestionIndex];

    return (
        <div className="speaking-test-container">
            <header className="test-header">
                <h1>IELTS Speaking Test</h1>
                <div className="question-counter">
                    Question {currentQuestionIndex + 1} of {questions.length}
                </div>
            </header>

            <div className="question-card">
                <div className="question-category">{currentQuestion.category}</div>
                <h2 className="question-text">{currentQuestion.question}</h2>
                
                {currentQuestion.prompts && currentQuestion.prompts.length > 0 && (
                    <div className="prompts-section">
                        <h3>Prompts:</h3>
                        <ul className="prompts-list">
                            {currentQuestion.prompts.map((prompt, index) => (
                                <li key={index}>{prompt}</li>
                            ))}
                        </ul>
                    </div>
                )}

                <div className="time-limit">
                    Time limit: {currentQuestion.time_limit} seconds
                </div>
            </div>

            <div className="navigation-buttons">
                <button
                    onClick={handlePreviousQuestion}
                    disabled={currentQuestionIndex === 0}
                    className="nav-button"
                >
                    Previous
                </button>
                <button
                    onClick={handleNextQuestion}
                    disabled={currentQuestionIndex === questions.length - 1}
                    className="nav-button"
                >
                    Next
                </button>
            </div>
        </div>
    );
};

export default SpeakingTest;