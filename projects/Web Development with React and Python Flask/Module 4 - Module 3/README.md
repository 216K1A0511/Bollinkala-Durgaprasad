
# Module 3: React Basics with TypeScript  

## **React Fundamentals**  

### **1. Setting up a React Project with TypeScript using Vite**  

#### **What is Vite?**  
Vite is a modern build tool and development server that provides a faster and more efficient development experience compared to traditional tools like Create React App. It is especially suited for projects using modern JavaScript frameworks such as React.  

#### **Steps to Set Up a React Project with TypeScript using Vite**  
1. **Install Vite**  
   Install Vite globally using npm or yarn to initialize new projects:  
   ```bash
   npm create vite@latest
   ```

2. **Initialize a React Project with TypeScript**  
   Run the following command to create a Vite project with React and TypeScript templates:  
   ```bash
   npm create vite@latest my-react-app --template react-ts
   ```
   Replace `my-react-app` with your desired project name.  

3. **Install Dependencies**  
   Navigate into the project folder and install the dependencies:  
   ```bash
   cd my-react-app
   npm install
   ```

4. **Run the Development Server**  
   Start the Vite development server to test the application:  
   ```bash
   npm run dev
   ```

#### **Basic Project Folder Structure**  
After initialization, the project structure typically looks like this:  
```
my-react-app/
├── node_modules/
├── public/
│   └── index.html
├── src/
│   ├── App.tsx
│   ├── main.tsx
│   └── styles.css
├── package.json
├── tsconfig.json
└── vite.config.ts
```
- **`public/`**: Contains static files like images and the main HTML file.  
- **`src/`**: Contains application source code, including components, styles, and entry files (`App.tsx` and `main.tsx`).  
- **`tsconfig.json`**: Configuration file for TypeScript settings.  
- **`vite.config.ts`**: Configuration file for Vite settings.  

---

### **2. Introduction to React Components**  

#### **What are Components?**  
Components are the building blocks of React applications. They are reusable pieces of code that represent parts of the user interface, such as a button, a header, or a form.  

#### **Types of React Components**  
1. **Functional Components**  
   - These are JavaScript functions that return JSX.  
   - They are simpler and easier to use compared to class components.  

2. **Class Components (Legacy)**  
   - These are ES6 classes that extend `React.Component`.  
   - They were commonly used before React introduced hooks but are now less prevalent.  

#### **Component Lifecycles Using Hooks**  
React functional components use hooks like `useEffect` to handle lifecycle events.  
- **Mounting**: Code runs when the component is added to the DOM.  
- **Updating**: Code runs when the component updates due to changes in state or props.  
- **Unmounting**: Code runs when the component is removed from the DOM.  

**`useEffect` Hook:**  
- Used to perform side effects like fetching data or updating the document title.  
- Can emulate `componentDidMount`, `componentDidUpdate`, and `componentWillUnmount`.  

---

### **3. Understanding JSX**  

#### **What is JSX?**  
JSX (JavaScript XML) is a syntax extension for JavaScript that allows writing HTML-like code inside JavaScript. It provides a cleaner and more readable way to define the UI.  

#### **Features of JSX**  
1. **Combining JavaScript and HTML**  
   - JSX lets you embed JavaScript expressions inside HTML-like syntax using curly braces `{}`.  
   - Example: `{variable}` can be used to display the value of `variable` inside the JSX.  

2. **Attributes and Events**  
   - JSX supports standard HTML attributes and React-specific ones, like `className` instead of `class`.  

3. **Nested Components**  
   - JSX allows including one component inside another, enabling composition.  

#### **Differences Between JSX and Traditional HTML**  
1. **Attributes:**  
   - HTML: Uses `class`.  
   - JSX: Uses `className`.  

2. **Closing Tags:**  
   - HTML: `<input>`.  
   - JSX: `<input />`.  

3. **JavaScript Integration:**  
   - HTML: Cannot include JavaScript directly.  
   - JSX: Allows embedding JavaScript expressions using `{}`.  

---

### **4. State Management Using `useState`**  

#### **What is State?**  
State is a special object in React that holds data about a component and determines its behavior. When state changes, React re-renders the component to reflect the updated state.  

#### **`useState` Hook**  
The `useState` hook allows functional components to manage local state.  

1. **Initialization**  
   - The `useState` hook is initialized with an initial value.  
   - It returns an array containing the state variable and a function to update it.  

2. **Updating State**  
   - The updater function is used to change the state.  
   - React automatically re-renders the component when state changes.  

#### **Key Points about `useState`**  
- State updates are asynchronous and may not reflect immediately after the function call.  
- Updating state with the same value does not trigger a re-render.  
- Complex states can be managed using objects or arrays, but immutable updates are required to maintain performance and avoid unexpected behavior.  

---

### **TypeScript Basics for React**  

TypeScript is a strongly-typed superset of JavaScript that brings static typing and additional features to JavaScript, making it particularly powerful for building large-scale applications. When used with React, TypeScript enhances code reliability, readability, and maintainability by ensuring that components handle data and events in a predictable way.  

#### **Getting Started with TypeScript in React**  

1. **Setup**  
   - Initialize a React project with TypeScript using Vite or Create React App:  
     ```bash
     npm create vite@latest my-react-app --template react-ts
     ```
     Or:  
     ```bash
     npx create-react-app my-react-app --template typescript
     ```

   - Install TypeScript-related dependencies:  
     ```bash
     npm install typescript @types/react @types/react-dom
     ```

2. **TypeScript Configuration**  
   The `tsconfig.json` file is automatically generated in most setups. It defines TypeScript settings for your project. A typical `tsconfig.json` might look like this:  
   ```json
   {
     "compilerOptions": {
       "target": "es6",
       "module": "esnext",
       "strict": true,
       "jsx": "react-jsx"
     }
   }
   ```

#### **Declaring Types for Props and State**  

1. **Defining Props Types**  
   Props are inputs to a React component, passed as attributes. TypeScript ensures that the correct types of data are passed to components.  

   **Using Type Aliases:**  
   ```typescript
   type GreetingProps = {
     name: string;
     age?: number; // Optional prop
   };
   ```

   **Using Props in Components:**  
   ```typescript
   const Greeting: React.FC<GreetingProps> = ({ name, age }) => {
     return (
       <div>
         <p>Hello, {name}!</p>
         {age && <p>You are {age} years old.</p>}
       </div>
     );
   };
   ```

2. **Defining State Types**  
   State represents data managed within a component. TypeScript ensures state is correctly typed.  

   **Declaring State with `useState`:**  
   ```typescript
   const [count, setCount] = useState<number>(0); // State is a number
   ```

   **Complex State Types:**  
   ```typescript
   type User = {
     id: number;
     name: string;
   };
   const [user, setUser] = useState<User | null>(null);
   ```

#### **Using Interfaces and Type Aliases**  

1. **Interface**  
   An interface defines the shape of an object and is extensible through inheritance.  

   **Defining an Interface:**  
   ```typescript
   interface User {
     id: number;
     name: string;
     email: string;
   }
   ```

   **Using Interfaces in Props:**  
   ```typescript
   const UserCard: React.FC<{ user: User }> = ({ user }) => (
     <div>
       <h3>{user.name}</h3>
       <p>{user.email}</p>
     </div>
   );
   ```

2. **Type Alias**  
   A type alias is used for more complex or union types.  

   **Defining a Type Alias:**  
   ```typescript
   type Status = "active" | "inactive" | "pending";
   ```

   **Using Type Alias in State:**  
   ```typescript
   const [status, setStatus] = useState<Status>("active");
   ```

#### **Handling Events in TypeScript**  

1. **Mouse Events**  
   Use `React.MouseEvent` for mouse-related events:  
   ```typescript
   const handleClick = (event: React.MouseEvent<HTMLButtonElement>) => {
     console.log("Button clicked");
   };
   ```

2. **Change Events**  
   Use `React.ChangeEvent` for input change events:  
   ```typescript
   const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
     console.log(event.target.value);
   };
   ```

3. **Form Events**  
   Use `React.FormEvent` for form submissions:  
   ```typescript
   const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
     event.preventDefault();
     console.log("Form submitted");
   };
   ```

---

### **Styling in React**  

#### **1. Integrating Tailwind CSS**  

**What is Tailwind CSS?**  
Tailwind CSS is a utility-first CSS framework that allows you to build custom designs directly in your markup by applying predefined utility classes. It eliminates the need for writing traditional CSS and provides flexibility with a focus on reusability.  

**Steps to Set Up Tailwind CSS**  
1. Install Tailwind CSS and its required dependencies:  
   ```bash
   npm install -D tailwindcss postcss autoprefixer
   ```

2. Initialize Tailwind CSS to create a `tailwind.config.js` file:  
   ```bash
   npx tailwindcss init
   ```

3. Configure the Tailwind CSS content:  
   ```javascript
   module.exports = {
     content: ["./src/**/*.{html,js,jsx,ts,tsx}"],
     theme: {
       extend: {},
     },
     plugins: [],
   };
   ```

4. Add Tailwind directives to a CSS file (e.g., `src/styles.css`):  
   ```css
   @tailwind base;
   @tailwind components;
   @tailwind utilities;
   ```

5. Import the CSS file into your React application entry point (e.g., `src/main.tsx`):  
   ```typescript
   import './styles.css';
   ```

6. Start the development server:  
   ```bash
   npm run dev
   ```

**Using Tailwind CSS Classes**  
Tailwind CSS provides utility classes for styling elements. These classes are applied directly to HTML or JSX elements in your React components.  

**Example:**  
```jsx
<div className="bg-blue-500 text-white p-4 rounded-md">
  Hello, Tailwind CSS!
</div>
```

#### **2. Managing Global Styles**  

1. **Extending the Tailwind Configuration**  
   Customize the `tailwind.config.js` file to add your global styles:  
   ```javascript
   module.exports = {
     theme: {
       extend: {
         colors: {
           primary: "#1E40AF", // Custom blue color
           secondary: "#F43F5E", // Custom red color
         },
         spacing: {
           72: "18rem", // Custom spacing
           84: "21rem",
         },
       },
     },
   };
   ```

2. **Using Custom Styles**  
   Use the custom classes in your components:  
   ```jsx
   <div className="bg-primary text-secondary p-4">
     Custom Colors in Tailwind
   </div>
   ```

---

### **React Props Validation and Folder Structure for a React Project**  

#### **1. React Props Validation**  

**What are Props?**  
Props (short for properties) are inputs passed to components in React. They enable customization and allow components to behave differently based on the data provided.  

**Validating Props with TypeScript**  
Using TypeScript, you can define the shape and types of props, ensuring that components receive the correct data structure.  

**Example:**  
```typescript
interface QuestionProps {
  questionId: string;
  questionText: string;
  timeLimit: number; // in seconds
}

const QuestionCard: React.FC<QuestionProps> = ({ questionId, questionText, timeLimit }) => {
  return (
    <div>
      <h3>{questionText}</h3>
      <p>Time Limit: {timeLimit}s</p>
    </div>
  );
};
```

#### **2. Basic Folder Structure for a React Project**  

**Recommended Folder Structure for the IELTS Speaking Test Platform**  
```
src/
├── components/       # Reusable components
│   ├── QuestionCard/
│   │   ├── QuestionCard.tsx
│   │   ├── QuestionCard.module.css
│   ├── Timer/
│   │   ├── Timer.tsx
│   │   ├── Timer.module.css
├── pages/            # Pages or views for the app
│   ├── TestPage.tsx
│   ├── ResultsPage.tsx
├── context/          # Context providers for global state
│   ├── TestContext.tsx
├── services/         # API service logic
│   ├── api.ts
│   ├── questionService.ts
├── assets/           # Static assets like images and fonts
│   ├── images/
│   ├── fonts/
├── styles/           # Global and shared styles
│   ├── tailwind.css
│   ├── variables.css
├── utils/            # Utility functions and helpers
│   ├── formatDate.ts
│   ├── validateInput.ts
├── App.tsx           # Main application component
├── index.tsx         # Application entry point
```

---
