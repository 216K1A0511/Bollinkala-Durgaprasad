import React, { useEffect, useState } from 'react';

interface Question {
  id: number;
  questionNumber: number;
  questionText: string;
  category: string;
}

interface QuestionCardProps {
  questionData?: Question; // Optional prop for direct data injection
  apiUrl?: string; // Optional prop for fetching data from an API
}

const QuestionCard: React.FC<QuestionCardProps> = ({ questionData, apiUrl }) => {
  const [question, setQuestion] = useState<Question | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    if (questionData) {
      // Use the provided question data directly
      setQuestion(questionData);
      setLoading(false);
    } else if (apiUrl) {
      // Fetch question data from the API
      const fetchQuestion = async () => {
        try {
          const response = await fetch(apiUrl);
          if (!response.ok) {
            throw new Error('Failed to fetch question');
          }
          const data = await response.json();
          setQuestion(data);
        } catch (err) {
          setError(err instanceof Error ? err.message : 'An error occurred');
        } finally {
          setLoading(false);
        }
      };
      fetchQuestion();
    } else {
      setError('No question data or API URL provided');
      setLoading(false);
    }
  }, [questionData, apiUrl]);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (error) {
    return <div>Error: {error}</div>;
  }

  if (!question) {
    return <div>No question available</div>;
  }

  return (
    <div className="question-card">
      <h3>Question {question.questionNumber}</h3>
      <p>{question.questionText}</p>
      <small>Category: {question.category}</small>
    </div>
  );
};

export default QuestionCard;