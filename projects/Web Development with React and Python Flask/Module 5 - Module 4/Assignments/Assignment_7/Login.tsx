import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

const Login: React.FC = () => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();

  const handleLogin = () => {
    // Simulate login logic
    if (username === "admin" && password === "password") {
      localStorage.setItem("isAuthenticated", "true");
      navigate("/admin-dashboard");
    } else if (username === "testtaker" && password === "password") {
      localStorage.setItem("isAuthenticated", "true");
      navigate("/test-taker-dashboard");
    } else {
      alert("Invalid credentials");
    }
  };

  return (
    <div>
      <h1>Login</h1>
      <input
        type="text"
        placeholder="Username"
        value={username}
        onChange={(e) => setUsername(e.target.value)}
      />
      <input
        type="password"
        placeholder="Password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
      />
      <button onClick={handleLogin}>Login</button>
    </div>
  );
};

export default Login;