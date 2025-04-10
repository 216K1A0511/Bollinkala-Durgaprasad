

# IELTS Speaking Test Platform

This project is a React-based application designed to display test questions for the IELTS Speaking Test. It includes a reusable `QuestionCard` component that dynamically fetches and displays questions from a backend API.

---

## Features

- **QuestionCard Component**:
  - Dynamically fetches and displays test questions.
  - Accepts props for question data or an API URL for flexibility.
  - Handles loading and error states.

- **TestTakerDashboard Component**:
  - Integrates the `QuestionCard` component.
  - Demonstrates usage with both static data and API-fetched data.

- **Backend Integration**:
  - Supports fetching questions from a backend API (e.g., `/api/questions`).

- **Styling**:
  - Basic CSS for visual clarity and responsiveness.

---

## Prerequisites

Before running the project, ensure you have the following installed:

- [Node.js](https://nodejs.org/) (v16 or higher)
- [npm](https://www.npmjs.com/) (v8 or higher)

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/ielts-speaking-test-platform.git
   ```

2. Navigate to the project directory:
   ```bash
   cd ielts-speaking-test-platform
   ```

3. Install dependencies:
   ```bash
   npm install
   ```

---

## Running the Application

1. Start the development server:
   ```bash
   npm start
   ```

2. Open your browser and navigate to:
   ```
   http://localhost:3000
   ```

---

## Backend Setup (Optional)

To simulate a backend API, you can use [JSON Server](https://github.com/typicode/json-server):

1. Create a `db.json` file in the root directory:
   ```json
   {
     "questions": [
       {
         "id": 1,
         "questionNumber": 1,
         "questionText": "Describe a memorable event in your life.",
         "category": "Personal Experience"
       }
     ]
   }
   ```

2. Start JSON Server:
   ```bash
   npx json-server --watch db.json --port 3001
   ```

3. Update the `apiUrl` prop in `TestTakerDashboard.tsx` to point to your local server:
   ```tsx
   <QuestionCard apiUrl="http://localhost:3001/questions/1" />
   ```

---

## Project Structure

```
src/
├── components/
│   ├── QuestionCard.tsx       # Reusable component to display questions
│   ├── QuestionCard.css       # Styles for the QuestionCard component
│   └── TestTakerDashboard.tsx # Main dashboard integrating QuestionCard
├── App.tsx                    # Root component of the application
├── App.css                    # Global styles
└── index.tsx                  # Entry point of the application
```

---

## Screenshots

1. **QuestionCard with Static Data**:
   ![QuestionCard with Static Data](./screenshots/static-question.png)

2. **QuestionCard with API Data**:
   ![QuestionCard with API Data](./screenshots/api-question.png)

3. **Loading State**:
   ![Loading State](./screenshots/loading-state.png)

4. **Error State**:
   ![Error State](./screenshots/error-state.png)

---

## Testing

To test the application:

1. Run the development server:
   ```bash
   npm start
   ```

2. Verify the following:
   - The `QuestionCard` component displays static data correctly.
   - The `QuestionCard` component fetches and displays data from the API.
   - Loading and error states are handled gracefully.

---


