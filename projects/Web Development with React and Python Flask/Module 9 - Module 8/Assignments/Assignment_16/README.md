
### Module 8: Advanced React Features with TypeScript (Assignment_16)

---

## Section 1: Advanced State Management

### 1.1 Global State with Context API and useReducer

**Context API Setup:**

```tsx
interface AppState {
  user: string | null;
  isAuthenticated: boolean;
}

const defaultState: AppState = {
  user: null,
  isAuthenticated: false,
};

const AppContext = createContext<
  | { state: AppState; dispatch: React.Dispatch<Action> }
  | undefined
>(undefined);

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

export const AppProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [state, dispatch] = useReducer(reducer, defaultState);

  return (
    <AppContext.Provider value={{ state, dispatch }}>
      {children}
    </AppContext.Provider>
  );
};

export const useAppContext = () => {
  const context = useContext(AppContext);
  if (!context) throw new Error("useAppContext must be used within AppProvider");
  return context;
};
```

**Usage in Component:**

```tsx
const LoginButton: React.FC = () => {
  const { dispatch } = useAppContext();
  return (
    <button onClick={() => dispatch({ type: "LOGIN", payload: "John Doe" })}>
      Login
    </button>
  );
};
```

### 1.2 Deep State Updates

**With Spread Operator:**

```tsx
setState(prev => ({
  ...prev,
  user: {
    ...prev.user,
    address: {
      ...prev.user?.address,
      city: "New York",
    },
  },
}));
```

**With Immer:**

```tsx
import produce from "immer";

setState(prev =>
  produce(prev, draft => {
    if (draft.user?.address) draft.user.address.city = "New York";
  })
);
```

### Best Practices

* Minimize global state
* Keep reducers simple
* Normalize state
* Memoize context values

---

## Section 2: Reusable Components

### 2.1 UI Components

**Modal Component:**

```tsx
interface ModalProps {
  isOpen: boolean;
  onClose: () => void;
  title: string;
  children: React.ReactNode;
}

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

**Dropdown Component:**

```tsx
interface DropdownProps {
  options: string[];
  onSelect: (value: string) => void;
}

const Dropdown: React.FC<DropdownProps> = ({ options, onSelect }) => (
  <select onChange={(e) => onSelect(e.target.value)}>
    {options.map((option, index) => (
      <option key={index} value={option}>{option}</option>
    ))}
  </select>
);
```

### 2.2 Configurable Components with Props

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

### Best Practices

* Small components
* Custom hooks for logic
* Descriptive props
* Use React.memo and useCallback

---

## Section 3: Custom Hooks

### 3.1 API Call Hook

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

### 3.2 Input Validation Hook

```tsx
const useInputValidation = (initial: string, validate: (v: string) => boolean) => {
  const [value, setValue] = useState(initial);
  const [isValid, setIsValid] = useState(false);

  const onChange = (val: string) => {
    setValue(val);
    setIsValid(validate(val));
  };

  return { value, isValid, onChange };
};
```

### 3.3 Local Storage Hook

```tsx
const useLocalStorage = <T,>(key: string, initial: T): [T, (v: T) => void] => {
  const [stored, setStored] = useState<T>(() => {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) : initial;
  });

  const setValue = (val: T) => {
    setStored(val);
    localStorage.setItem(key, JSON.stringify(val));
  };

  return [stored, setValue];
};
```

---

## Section 4: Timers and Animations

### 4.1 Using react-timer-hook

```tsx
import { useTimer } from "react-timer-hook";

const Timer: React.FC<{ expiryTimestamp: Date }> = ({ expiryTimestamp }) => {
  const { seconds, minutes, isRunning, restart } = useTimer({
    expiryTimestamp,
    onExpire: () => console.log("Time's up!"),
  });

  return (
    <div>
      <p>{minutes}:{seconds < 10 ? `0${seconds}` : seconds}</p>
      <button onClick={() => restart(expiryTimestamp)}>Restart</button>
    </div>
  );
};
```

### 4.2 Progress Bar with Timer

```tsx
const ProgressBar: React.FC<{ duration: number }> = ({ duration }) => {
  const [progress, setProgress] = useState(100);

  useEffect(() => {
    const interval = setInterval(() => {
      setProgress(prev => (prev > 0 ? prev - 1 : 0));
    }, (duration / 100) * 1000);
    return () => clearInterval(interval);
  }, [duration]);

  return (
    <div style={{ width: '100%', height: '10px', background: '#ccc' }}>
      <div style={{ width: `${progress}%`, height: '10px', background: 'green' }} />
    </div>
  );
};
```

### 4.3 Framer Motion Animations

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

