import React from 'react';
import QuestionCard from './QuestionCard';

const TestTakerDashboard: React.FC = () => {
  // Example question data (can be replaced with an API call)
  const sampleQuestion = {
    id: 1,
    questionNumber: 1,
    questionText: 'Describe a memorable event in your life.',
    category: 'Personal Experience',
  };

  return (
    <div className="dashboard">
      <h1>IELTS Speaking Test</h1>
      <QuestionCard questionData={sampleQuestion} />
      {/* Alternatively, fetch from an API */}
      <QuestionCard apiUrl="/api/questions/1" />
    </div>
  );
};

export default TestTakerDashboard;