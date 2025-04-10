# Module 5 - Module 4
# React Intermediate Concepts with TypeScript

This repository covers intermediate React concepts with TypeScript, focusing on routing, controlled components, advanced TypeScript patterns, and reusable component development.

## Table of Contents

1. [Routing in React](#routing-in-react)
   - [Basics](#basics)
   - [Advanced](#advanced-routing)
2. [Controlled Components](#controlled-components)
3. [Advanced TypeScript in React](#advanced-typescript-in-react)
4. [Reusable Components](#reusable-components)

## Routing in React

### Basics

React Router enables navigation between different views in a React application without full page reloads.

#### Key Features:
- Client-side routing
- Dynamic navigation
- Declarative syntax
- Nested routing

#### Basic Setup:
```tsx
import { BrowserRouter, Routes, Route } from "react-router-dom";
import HomePage from "./pages/HomePage";
import TestPage from "./pages/TestPage";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/test" element={<TestPage />} />
      </Routes>
    </BrowserRouter>
  );
}
```

### Advanced Routing

#### Protected Routes:
```tsx
interface PrivateRouteProps {
  isAuthenticated: boolean;
}

const PrivateRoute: React.FC<PrivateRouteProps> = ({ isAuthenticated }) => {
  return isAuthenticated ? <Outlet /> : <Navigate to="/login" />;
};

// Usage:
<Route element={<PrivateRoute isAuthenticated={true} />}>
  <Route path="/dashboard" element={<Dashboard />} />
</Route>
```

#### Dynamic Routing:
```tsx
// Route definition
<Route path="/test/:testId" element={<TestPage />} />

// Accessing params
const { testId } = useParams<{ testId: string }>();
```

## Controlled Components

Controlled components manage form data via React state.

### Example:
```tsx
const Form: React.FC = () => {
  const [name, setName] = useState("");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    alert(`Submitted Name: ${name}`);
  };

  return (
    <form onSubmit={handleSubmit}>
      <input
        type="text"
        value={name}
        onChange={(e) => setName(e.target.value)}
      />
      <button type="submit">Submit</button>
    </form>
  );
};
```

### Validation:
```tsx
const [email, setEmail] = useState("");
const [error, setError] = useState("");

const handleSubmit = (e: React.FormEvent) => {
  e.preventDefault();
  if (!email.includes("@")) {
    setError("Invalid email address");
    return;
  }
  // Submit logic
};
```

## Advanced TypeScript in React

### Extending Interfaces:
```tsx
interface BaseProps {
  id: string;
  createdAt: Date;
}

interface QuestionProps extends BaseProps {
  questionText: string;
  isAnswered: boolean;
}
```

### Utility Types:
```tsx
type BriefQuestion = Pick<QuestionProps, "id" | "questionText">;
type WithoutAnswerStatus = Omit<QuestionProps, "isAnswered">;
type PartialQuestion = Partial<QuestionProps>;
```

### Typed useReducer:
```tsx
interface TestState {
  currentQuestion: number;
  score: number;
}

type TestAction =
  | { type: "NEXT_QUESTION" }
  | { type: "INCREASE_SCORE"; payload: number };

const testReducer = (state: TestState, action: TestAction): TestState => {
  // reducer logic
};
```

## Reusable Components

### Button Component:
```tsx
interface ButtonProps {
  label: string;
  onClick: () => void;
  variant?: "primary" | "secondary";
  disabled?: boolean;
}

const Button: React.FC<ButtonProps> = ({ label, onClick, variant = "primary", disabled = false }) => {
  return (
    <button onClick={onClick} disabled={disabled}>
      {label}
    </button>
  );
};
```

### Card Component:
```tsx
interface CardProps {
  title: string;
  description: string;
  footer?: React.ReactNode;
  children?: React.ReactNode;
}

const Card: React.FC<CardProps> = ({ title, description, footer, children }) => {
  return (
    <div>
      <h3>{title}</h3>
      <p>{description}</p>
      {children}
      {footer}
    </div>
  );
};
```

## Installation

1. Clone the repository
2. Install dependencies:
```bash
npm install
npm install react-router-dom
```

## Development

```bash
npm start
```

## Best Practices

1. Use TypeScript for type safety
2. Prefer composition over prop drilling
3. Keep components small and focused
4. Use utility types for flexible component props
5. Implement proper validation for forms

