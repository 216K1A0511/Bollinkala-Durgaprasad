import React from 'react';
import TestStartButton from './TestStartButton';

const Dashboard: React.FC = () => {
  return (
    <div style={styles.dashboard}>
      <h2>Welcome to the Dashboard!</h2>
      <p>This is a placeholder for the test overview or instructions.</p>
      <TestStartButton />
    </div>
  );
};

const styles = {
  dashboard: {
    padding: '2rem',
    textAlign: 'center' as const,
  },
};

export default Dashboard;