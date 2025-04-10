import axios from 'axios';

const API_BASE_URL = 'http://localhost:5000/api';

export const fetchAllSpeakingTests = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/speaking-tests`);
    return response.data;
  } catch (error) {
    console.error('Error fetching speaking tests:', error);
    throw error;
  }
};

export const fetchTestsByPart = async (partNumber: number) => {
  try {
    const response = await axios.get(`${API_BASE_URL}/speaking-tests/${partNumber}`);
    return response.data;
  } catch (error) {
    console.error(`Error fetching Part ${partNumber} tests:`, error);
    throw error;
  }
};