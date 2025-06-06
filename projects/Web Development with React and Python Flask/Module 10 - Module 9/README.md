

# 📡 Module 9: Real-Time Features and Audio Handling

This module focuses on implementing **real-time communication** and **audio processing** capabilities using **WebSockets** and the **Media API**, tailored for interactive platforms like the **IELTS Speaking Test**.

---

## 🔌 WebSocket Basics

WebSockets enable **bi-directional, real-time** communication between client and server—perfect for scenarios like live test questions or real-time collaboration.

### 1. Setting Up WebSocket Connections in Flask

#### 1.1 Introduction to WebSockets

* Full-duplex communication over a single TCP connection.
* Unlike HTTP, they allow real-time two-way communication.
* Useful for live updates like scores, messages, or test prompts.

#### 1.2 Configuring Flask for WebSockets

##### Install Flask-SocketIO:

```bash
pip install flask-socketio
```

##### Sample Flask WebSocket Server:

```python
from flask import Flask
from flask_socketio import SocketIO, emit

app = Flask(__name__)
app.config['SECRET_KEY'] = 'secret!'
socketio = SocketIO(app)

@app.route("/")
def index():
    return "WebSocket Server Running"

@socketio.on("connect")
def handle_connect():
    print("Client connected")
    emit("server_message", {"message": "Welcome to the WebSocket server!"})

@socketio.on("client_message")
def handle_client_message(data):
    print(f"Received message: {data}")
    emit("server_message", {"message": "Message received"}, broadcast=True)

if __name__ == "__main__":
    socketio.run(app, debug=True)
```

---

## ⚛️ Managing WebSocket Events in React

### 2.1 Connecting React to WebSocket

```tsx
import React, { useEffect, useState } from "react";

const WebSocketComponent: React.FC = () => {
  const [messages, setMessages] = useState<string[]>([]);
  const socket = React.useRef<WebSocket | null>(null);

  useEffect(() => {
    socket.current = new WebSocket("ws://localhost:5000/socket.io");

    socket.current.onmessage = (event) => {
      const data = JSON.parse(event.data);
      setMessages((prev) => [...prev, data.message]);
    };

    return () => socket.current?.close();
  }, []);

  return (
    <div>
      <h2>Messages</h2>
      <ul>{messages.map((msg, index) => <li key={index}>{msg}</li>)}</ul>
    </div>
  );
};

export default WebSocketComponent;
```

### 2.2 Sending and Receiving Data

```tsx
const sendMessage = (message: string) => {
  socket.current?.send(JSON.stringify({ type: "client_message", message }));
};
```

---

## ✅ Best Practices for WebSockets

* **Error Handling**: Retry connections or fallback to polling.
* **Performance**: Debounce updates to reduce load.
* **Security**: Use `wss://` and authenticate sessions.
* **Scalability**: Load balance with Nginx or Kubernetes.

---

## 🎙 Audio APIs

### 1. Recording Audio Using the Media API

#### 1.1 Access Microphone

```ts
const startRecording = async () => {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    console.log("Microphone access granted", stream);
  } catch (err) {
    console.error("Error accessing microphone", err);
  }
};
```

#### 1.2 Record Audio Stream

```ts
let mediaRecorder: MediaRecorder;
let audioChunks: Blob[] = [];

const startRecording = async () => {
  const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
  mediaRecorder = new MediaRecorder(stream);
  mediaRecorder.ondataavailable = (event) => audioChunks.push(event.data);
  mediaRecorder.start();
};

const stopRecording = () => {
  mediaRecorder.stop();
  const audioBlob = new Blob(audioChunks, { type: "audio/wav" });
  audioChunks = [];
  return audioBlob;
};
```

---

## 📤 Sending Audio Data to Flask

### 2.1 Uploading Audio to Backend

```ts
const sendAudioData = async (audioBlob: Blob) => {
  const formData = new FormData();
  formData.append("audio", audioBlob, "recording.wav");

  try {
    const response = await fetch("/upload-audio", {
      method: "POST",
      body: formData,
    });
    console.log("Audio uploaded", await response.json());
  } catch (err) {
    console.error("Upload error", err);
  }
};
```

### 2.2 Flask Backend to Handle Audio

```python
from flask import Flask, request, jsonify
app = Flask(__name__)

@app.route("/upload-audio", methods=["POST"])
def upload_audio():
    if "audio" not in request.files:
        return jsonify({"error": "No audio file uploaded"}), 400

    audio_file = request.files["audio"]
    audio_file.save(f"uploads/{audio_file.filename}")
    return jsonify({
        "status": "success",
        "message": "Audio uploaded and processed",
        "filename": audio_file.filename
    })
```


