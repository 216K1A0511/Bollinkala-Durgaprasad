// src/services/speakingTestService.ts
import axios from 'axios';

const API_BASE_URL = process.env.REACT_APP_API_BASE_URL || 'http://localhost:5000/api';

export interface SpeakingQuestion {
  id: number;
  question: string;
  category: string;
  difficulty: 'easy' | 'medium' | 'hard';
  time_limit: number;
  sample_answer?: string;
}

export const fetchSpeakingQuestions = async (): Promise<SpeakingQuestion[]> => {
  try {
    const response = await axios.get<{ questions: SpeakingQuestion[] }>(
      `${API_BASE_URL}/speaking-tests/questions`
    );
    return response.data.questions;
  } catch (error) {
    if (axios.isAxiosError(error)) {
      throw new Error(error.response?.data?.message || 'Failed to fetch questions');
    }
    throw new Error('Network error occurred');
  }
};

export const submitTestResponse = async (
  questionId: number,
  response: string
): Promise<{ success: boolean; feedback?: string }> => {
  try {
    const result = await axios.post(`${API_BASE_URL}/speaking-tests/responses`, {
      question_id: questionId,
      response
    });
    return result.data;
  } catch (error) {
    if (axios.isAxiosError(error)) {
      throw new Error(error.response?.data?.message || 'Submission failed');
    }
    throw new Error('Network error occurred');
  }
};