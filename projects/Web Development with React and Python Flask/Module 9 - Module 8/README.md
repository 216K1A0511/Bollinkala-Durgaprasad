
### Module 8: Advanced React Features with TypeScript

---

#### Advanced State Management

##### 1. Using the Context API and useReducer for Global State

###### 1.1 Context API to Share State Across Components

```tsx
import React, { createContext, useContext, useState } from "react";

interface AppState {
  user: string | null;
  isAuthenticated: boolean;
}

const defaultState: AppState = {
  user: null,
  isAuthenticated: false,
};

const AppContext = createContext<any>(undefined);

export const AppProvider: React.FC = ({ children }) => {
  const [state, setState] = useState(defaultState);
  return (
    <AppContext.Provider value={{ state, setState }}>
      {children}
    </AppContext.Provider>
  );
};

export const useAppContext = () => {
  const context = useContext(AppContext);
  if (!context) throw new Error("useAppContext must be used within an AppProvider");
  return context;
};
```

###### 1.2 useReducer for Managing Complex State Logic

```tsx
type Action = { type: "LOGIN"; payload: string } | { type: "LOGOUT" };

const reducer = (state: AppState, action: Action): AppState => {
  switch (action.type) {
    case "LOGIN":
      return { ...state, user: action.payload, isAuthenticated: true };
    case "LOGOUT":
      return { ...state, user: null, isAuthenticated: false };
    default:
      return state;
  }
};

const AppProvider: React.FC = ({ children }) => {
  const [state, dispatch] = useReducer(reducer, defaultState);
  return (
    <AppContext.Provider value={{ state, dispatch }}>
      {children}
    </AppContext.Provider>
  );
};
```

##### 2. Handling Deep State Updates with Immutable Patterns

###### 2.1 Spread Operator and Array Methods

```tsx
const updateAddress = () => {
  setState(prevState => ({
    ...prevState,
    user: {
      ...prevState.user,
      address: {
        ...prevState.user.address,
        city: "New York",
      },
    },
  }));
};

const updateItemInArray = () => {
  setState(prevState => ({
    ...prevState,
    items: prevState.items.map(item =>
      item.id === targetId ? { ...item, value: "Updated" } : item
    ),
  }));
};
```

###### 2.2 Using Immer

```tsx
import produce from "immer";

const updateAddress = () => {
  setState(prevState =>
    produce(prevState, draft => {
      draft.user.address.city = "New York";
    })
  );
};
```

##### Best Practices

* Minimize global state
* Keep reducers simple
* Normalize state
* Use memoization to optimize re-renders

---

#### Reusable Components

##### 1. Building Reusable UI Elements

###### 1.1 Modal Component

```tsx
const Modal: React.FC<ModalProps> = ({ isOpen, onClose, title, children }) => {
  if (!isOpen) return null;
  return (
    <div className="modal-overlay">
      <div className="modal-content">
        <h2>{title}</h2>
        <button onClick={onClose}>Close</button>
        <div>{children}</div>
      </div>
    </div>
  );
};
```

###### 1.2 Dropdown Component

```tsx
const Dropdown: React.FC<DropdownProps> = ({ options, onSelect }) => {
  return (
    <select onChange={(e) => onSelect(e.target.value)}>
      {options.map((option, index) => (
        <option key={index} value={option}>{option}</option>
      ))}
    </select>
  );
};
```

##### 2. Making Components Configurable with Props

```tsx
interface ButtonProps {
  label: string;
  onClick: () => void;
  variant?: "primary" | "secondary";
}

const Button: React.FC<ButtonProps> = ({ label, onClick, variant = "primary" }) => (
  <button className={`btn ${variant}`} onClick={onClick}>{label}</button>
);
```

---

#### Custom Hooks

##### 1. API Call Hook

```tsx
const useFetch = <T,>(url: string) => {
  const [data, setData] = useState<T | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    axios.get(url)
      .then(res => setData(res.data))
      .catch(err => setError(err.message))
      .finally(() => setLoading(false));
  }, [url]);

  return { data, loading, error };
};
```

##### 2. Input Validation Hook

```tsx
const useInputValidation = (initialValue: string, validate: (value: string) => boolean) => {
  const [value, setValue] = useState(initialValue);
  const [isValid, setIsValid] = useState(false);

  const handleChange = (newValue: string) => {
    setValue(newValue);
    setIsValid(validate(newValue));
  };

  return { value, isValid, onChange: handleChange };
};
```

##### 3. Local Storage Hook

```tsx
const useLocalStorage = <T,>(key: string, initialValue: T): [T, (value: T) => void] => {
  const [storedValue, setStoredValue] = useState<T>(() => {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) : initialValue;
  });

  const setValue = (value: T) => {
    setStoredValue(value);
    localStorage.setItem(key, JSON.stringify(value));
  };

  return [storedValue, setValue];
};
```

---

#### Timers and Animations

##### 1. Timers for Test Sections

###### 1.1 Using `react-timer-hook`

```tsx
import { useTimer } from "react-timer-hook";

const Timer = ({ expiryTimestamp }: { expiryTimestamp: Date }) => {
  const { seconds, minutes, isRunning, restart } = useTimer({
    expiryTimestamp,
    onExpire: () => console.log("Time's up!"),
  });

  return (
    <div>
      <h2>Time Remaining</h2>
      <p>{minutes}:{seconds < 10 ? `0${seconds}` : seconds}</p>
      {!isRunning && <p>Time's up!</p>}
      <button onClick={() => restart(expiryTimestamp)}>Restart</button>
    </div>
  );
};
```

###### 1.2 Progress Bar for Timers

```tsx
const ProgressBar = ({ duration }: { duration: number }) => {
  const [progress, setProgress] = useState(100);

  useEffect(() => {
    const interval = setInterval(() => {
      setProgress(prev => (prev > 0 ? prev - 1 : 0));
    }, (duration / 100) * 1000);
    return () => clearInterval(interval);
  }, [duration]);

  return (
    <div style={{ width: "100%", background: "#ccc", height: "10px" }}>
      <div style={{ width: `${progress}%`, background: "green", height: "10px" }} />
    </div>
  );
};
```

##### 2. UI Animations

###### 2.1 CSS Animation

```css
.fade-in {
  animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
```

###### 2.2 Framer Motion

```tsx
import { motion } from "framer-motion";

const AnimatedBox: React.FC = () => (
  <motion.div
    initial={{ opacity: 0, y: -50 }}
    animate={{ opacity: 1, y: 0 }}
    exit={{ opacity: 0, y: 50 }}
    transition={{ duration: 0.5 }}
  >
    <h1>Animated Entry</h1>
  </motion.div>
);
```

---


