

# 🔄 Assignment 18: Implement Real-Time Updates

## 🎯 Objective

Implement **WebSocket-based real-time communication** between the **Flask backend** and the **React frontend** to deliver live updates (e.g., test start time, status changes, admin messages) during the IELTS Speaking Test.

---

## 📘 Scenario

The IELTS Speaking Test platform needs to notify users in **real-time** about:

* Test start and end times
* Status changes (e.g., “Waiting”, “In Progress”, “Completed”)
* Admin notifications

Use **Flask-SocketIO** on the backend and **socket.io-client** on the frontend for seamless communication.

---

## ✅ Requirements

### 1. WebSocket Backend

* 📡 Use `Flask-SocketIO` to handle WebSocket connections.
* 🔁 Broadcast events such as `test_started`, `timer_update`, and `admin_message`.

### 2. Frontend WebSocket Integration

* ⚙️ Use `socket.io-client` to connect to the backend.
* 🔔 Listen to real-time events and update UI instantly.

### 3. Real-Time UI Updates

* 🕒 Show countdowns or alerts like “Test starting in 2 minutes”.
* 📣 Display notifications as they arrive without page refresh.

### 4. Error Handling

* 🔄 Handle dropped or failed connections.
* 🧠 Implement reconnection logic and fallback messaging.

### 5. Styling

* 🎨 Use notification bars or status banners to reflect updates.

---

## 📁 Deliverables

* Flask backend with WebSocket (`socketio`) configuration
* React components using WebSocket to reflect real-time changes
* Evidence of functionality (screenshots, logs, or recordings)

---

## ⚙️ Backend (Flask + Flask-SocketIO)

### Installation

```bash
pip install flask flask-socketio eventlet
```

### Sample Setup

```python
from flask import Flask
from flask_socketio import SocketIO, emit

app = Flask(__name__)
socketio = SocketIO(app, cors_allowed_origins="*")

@socketio.on('connect')
def handle_connect():
    print("Client connected")

@socketio.on('disconnect')
def handle_disconnect():
    print("Client disconnected")

def broadcast_test_status():
    socketio.emit('update', {'message': 'Test starting in 2 minutes'})
```

### Run the Server

```bash
socketio.run(app, debug=True)
```

---

## ⚛️ Frontend (React + socket.io-client)

### Installation

```bash
npm install socket.io-client
```

### WebSocket Integration

```tsx
import { useEffect, useState } from "react";
import { io } from "socket.io-client";

const socket = io("http://localhost:5000");

const RealTimeStatus: React.FC = () => {
  const [message, setMessage] = useState("");

  useEffect(() => {
    socket.on("update", (data) => {
      setMessage(data.message);
    });

    return () => {
      socket.off("update");
    };
  }, []);

  return (
    <div className="notification-bar">
      {message && <p>{message}</p>}
    </div>
  );
};

export default RealTimeStatus;
```

---

## 🧪 Testing Checklist

| Feature                      | Status | Notes                           |
| ---------------------------- | ------ | ------------------------------- |
| WebSocket Connection (BE/FE) | ✅      | Connected successfully          |
| Event Broadcasting           | ✅      | Messages sent from backend      |
| Frontend Update              | ✅      | UI updates live without refresh |
| Error Handling               | ✅      | Reconnects handled gracefully   |
| Styling                      | ✅      | Notification bar implemented    |

---

## 🏆 Evaluation Criteria

| Criteria                  | Weight |
| ------------------------- | ------ |
| ✅ WebSocket Functionality | 40%    |
| ✅ UI Real-Time Updates    | 30%    |
| ✅ Robust Error Handling   | 20%    |
| ✅ Submission Completeness | 10%    |

---

## 💡 Hints & Tips

* Use `socket.on("event", callback)` in frontend to handle real-time updates.
* Use `emit()` on the server to push updates to all clients.
* Add visual indicators (colors, icons, sound) to improve UX.
* Use fallback REST API calls for critical alerts if WebSocket fails.

---

## 🧪 Testing Scenarios

1. **Backend**

   * Emit sample messages manually from the Flask shell.
   * Verify client console logs or UI reflect updates.

2. **Frontend**

   * Simulate different update types (status change, message).
   * Disconnect the socket and verify reconnection.

3. **Edge Cases**

   * Block microphone or network and test behavior.
   * Refresh browser and ensure reconnection.

