# Frontend-Backend Integration - Module 6

This module covers the integration between React frontend and Flask backend, focusing on API communication, dynamic data handling, and TypeScript enhancements.

## Table of Contents

1. [API Integration with Axios](#api-integration-with-axios)
2. [Dynamic Data Handling](#dynamic-data-handling)
3. [TypeScript Enhancements](#typescript-enhancements)

## API Integration with Axios

### Setting Up Axios

```typescript
// axiosInstance.ts
import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://localhost:5000/api",
  headers: {
    "Content-Type": "application/json",
  },
});

export default axiosInstance;
```

### Making API Requests

```typescript
// api.ts
import axiosInstance from "./axiosInstance";

// GET request
export const fetchUsers = () => axiosInstance.get("/users");

// POST request
export const createUser = (userData: { name: string; email: string }) =>
  axiosInstance.post("/users", userData);

// PUT request
export const updateUser = (id: number, userData: { name: string }) =>
  axiosInstance.put(`/users/${id}`, userData);

// DELETE request
export const deleteUser = (id: number) => axiosInstance.delete(`/users/${id}`);
```

### Handling Responses and Errors

```typescript
// Example component
import React, { useState, useEffect } from "react";
import { fetchUsers } from "./api";

const UserList: React.FC = () => {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
    const getUsers = async () => {
      setLoading(true);
      try {
        const response = await fetchUsers();
        setUsers(response.data);
      } catch (err) {
        setError("Failed to fetch users");
      } finally {
        setLoading(false);
      }
    };

    getUsers();
  }, []);

  if (loading) return <div>Loading...</div>;
  if (error) return <div>{error}</div>;

  return (
    <ul>
      {users.map((user) => (
        <li key={user.id}>{user.name}</li>
      ))}
    </ul>
  );
};
```

## Dynamic Data Handling

### Fetching and Displaying Data

```typescript
interface User {
  id: number;
  name: string;
  email: string;
}

const UserProfile: React.FC<{ userId: number }> = ({ userId }) => {
  const [user, setUser] = useState<User | null>(null);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    const fetchUser = async () => {
      setLoading(true);
      try {
        const response = await axiosInstance.get<User>(`/users/${userId}`);
        setUser(response.data);
      } catch (error) {
        console.error("Error fetching user:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchUser();
  }, [userId]);

  if (loading) return <div>Loading user data...</div>;
  if (!user) return <div>User not found</div>;

  return (
    <div>
      <h2>{user.name}</h2>
      <p>Email: {user.email}</p>
    </div>
  );
};
```

### Complex State Management with useReducer

```typescript
type State = {
  users: User[];
  loading: boolean;
  error: string | null;
};

type Action =
  | { type: "FETCH_START" }
  | { type: "FETCH_SUCCESS"; payload: User[] }
  | { type: "FETCH_FAILURE"; payload: string };

const userReducer = (state: State, action: Action): State => {
  switch (action.type) {
    case "FETCH_START":
      return { ...state, loading: true, error: null };
    case "FETCH_SUCCESS":
      return { ...state, loading: false, users: action.payload };
    case "FETCH_FAILURE":
      return { ...state, loading: false, error: action.payload };
    default:
      return state;
  }
};

const UserList: React.FC = () => {
  const [state, dispatch] = useReducer(userReducer, {
    users: [],
    loading: false,
    error: null,
  });

  useEffect(() => {
    const fetchUsers = async () => {
      dispatch({ type: "FETCH_START" });
      try {
        const response = await axiosInstance.get<User[]>("/users");
        dispatch({ type: "FETCH_SUCCESS", payload: response.data });
      } catch (error) {
        dispatch({ type: "FETCH_FAILURE", payload: error.message });
      }
    };

    fetchUsers();
  }, []);

  // Render logic...
};
```

## TypeScript Enhancements

### Typing API Responses

```typescript
interface ApiResponse<T> {
  data: T;
  status: number;
  statusText: string;
  headers: any;
  config: any;
  request?: any;
}

interface User {
  id: number;
  name: string;
  email: string;
  createdAt: string;
}

interface SpeakingTest {
  id: number;
  userId: number;
  question: string;
  score: number;
  takenAt: string;
}

// Typed API call
const fetchUserTests = async (userId: number): Promise<SpeakingTest[]> => {
  const response = await axiosInstance.get<SpeakingTest[]>(`/users/${userId}/tests`);
  return response.data;
};
```

### Utility Types for API Requests

```typescript
// For creating new user (omitting auto-generated fields)
type CreateUserDto = Omit<User, "id" | "createdAt">;

// For updating user (all fields optional)
type UpdateUserDto = Partial<CreateUserDto>;

// API functions with proper typing
const createUser = async (userData: CreateUserDto): Promise<User> => {
  const response = await axiosInstance.post<User>("/users", userData);
  return response.data;
};

const updateUser = async (id: number, userData: UpdateUserDto): Promise<User> => {
  const response = await axiosInstance.put<User>(`/users/${id}`, userData);
  return response.data;
};
```

### Generic API Service

```typescript
class ApiService<T extends { id: number }> {
  constructor(private endpoint: string) {}

  async getAll(): Promise<T[]> {
    const response = await axiosInstance.get<T[]>(this.endpoint);
    return response.data;
  }

  async getOne(id: number): Promise<T> {
    const response = await axiosInstance.get<T>(`${this.endpoint}/${id}`);
    return response.data;
  }

  async create(data: Omit<T, "id">): Promise<T> {
    const response = await axiosInstance.post<T>(this.endpoint, data);
    return response.data;
  }

  async update(id: number, data: Partial<T>): Promise<T> {
    const response = await axiosInstance.put<T>(`${this.endpoint}/${id}`, data);
    return response.data;
  }

  async delete(id: number): Promise<void> {
    await axiosInstance.delete(`${this.endpoint}/${id}`);
  }
}

// Usage
const userService = new ApiService<User>("/users");
const testService = new ApiService<SpeakingTest>("/tests");
```

## Best Practices

1. **Centralize API Logic**: Keep all API calls in dedicated service files
2. **Type Everything**: Define interfaces for all API requests and responses
3. **Error Handling**: Implement comprehensive error handling for API calls
4. **Loading States**: Always show loading indicators during API operations
5. **Modular Architecture**: Organize code by feature rather than by type
6. **Environment Variables**: Store API base URLs in environment variables
7. **Interceptors**: Use Axios interceptors for auth headers and error handling
8. **Cancellation**: Implement request cancellation for unmounted components

## Example Integration Flow

```typescript
// Full example of a user profile component
interface UserProfileProps {
  userId: number;
}

const UserProfile: React.FC<UserProfileProps> = ({ userId }) => {
  const [user, setUser] = useState<User | null>(null);
  const [tests, setTests] = useState<SpeakingTest[]>([]);
  const [loading, setLoading] = useState({
    user: false,
    tests: false,
  });
  const [error, setError] = useState({
    user: "",
    tests: "",
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading((prev) => ({ ...prev, user: true }));
        const userResponse = await axiosInstance.get<User>(`/users/${userId}`);
        setUser(userResponse.data);
      } catch (err) {
        setError((prev) => ({ ...prev, user: "Failed to load user" }));
      } finally {
        setLoading((prev) => ({ ...prev, user: false }));
      }

      try {
        setLoading((prev) => ({ ...prev, tests: true }));
        const testsResponse = await axiosInstance.get<SpeakingTest[]>(
          `/users/${userId}/tests`
        );
        setTests(testsResponse.data);
      } catch (err) {
        setError((prev) => ({ ...prev, tests: "Failed to load tests" }));
      } finally {
        setLoading((prev) => ({ ...prev, tests: false }));
      }
    };

    fetchData();
  }, [userId]);

  if (loading.user || loading.tests) return <div>Loading...</div>;

  return (
    <div>
      {user && (
        <div>
          <h2>{user.name}</h2>
          <p>Email: {user.email}</p>
          <p>Member since: {new Date(user.createdAt).toLocaleDateString()}</p>
        </div>
      )}
      {error.user && <div className="error">{error.user}</div>}

      <h3>Test Results</h3>
      {tests.length > 0 ? (
        <ul>
          {tests.map((test) => (
            <li key={test.id}>
              {test.question} - Score: {test.score}
            </li>
          ))}
        </ul>
      ) : (
        <p>No tests taken yet</p>
      )}
      {error.tests && <div className="error">{error.tests}</div>}
    </div>
  );
};
```
