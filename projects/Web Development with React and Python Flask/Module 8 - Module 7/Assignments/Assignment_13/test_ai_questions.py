import unittest
from app import app
import json
from unittest.mock import patch, MagicMock

class TestAIQuestionGenerator(unittest.TestCase):
    def setUp(self):
        self.app = app.test_client()
        self.app.testing = True
    
    @patch('google.generativeai.GenerativeModel')
    def test_successful_question_generation(self, mock_model):
        # Mock Gemini response
        mock_response = MagicMock()
        mock_response.text = "Describe a piece of technology you find useful."
        mock_model.return_value.generate_content.return_value = mock_response
        
        # Test with all parameters
        response = self.app.post('/api/ai-questions',
            data=json.dumps({
                'type': 'Part 2',
                'difficulty': 'medium',
                'topic': 'technology'
            }),
            content_type='application/json'
        )
        
        self.assertEqual(response.status_code, 200)
        data = json.loads(response.data)
        self.assertEqual(data['status'], 'success')
        self.assertEqual(data['data']['question'], "Describe a piece of technology you find useful.")
        self.assertEqual(data['data']['type'], 'Part 2')
    
    def test_default_parameters(self):
        # Test with no parameters (should use defaults)
        with patch('google.generativeai.GenerativeModel') as mock_model:
            mock_response = MagicMock()
            mock_response.text = "Describe a memorable experience from your childhood."
            mock_model.return_value.generate_content.return_value = mock_response
            
            response = self.app.post('/api/ai-questions',
                data=json.dumps({}),
                content_type='application/json'
            )
            
            self.assertEqual(response.status_code, 200)
            data = json.loads(response.data)
            self.assertEqual(data['data']['type'], 'Part 2')
            self.assertEqual(data['data']['difficulty'], 'medium')
    
    def test_invalid_content_type(self):
        # Test with non-JSON content
        response = self.app.post('/api/ai-questions',
            data="not json",
            content_type='text/plain'
        )
        self.assertEqual(response.status_code, 400)
        data = json.loads(response.data)
        self.assertEqual(data['error'], 'Request body must be JSON')

if __name__ == '__main__':
    unittest.main()