import React, { useState } from 'react';
import axios from 'axios';
import './App.css';
import QuestionGenerator from './components/QuestionGenerator';

function App() {
  return (
    <div className="app-container">
      <h1>IELTS Speaking Test Practice</h1>
      <QuestionGenerator />
    </div>
  );
}

export default App;