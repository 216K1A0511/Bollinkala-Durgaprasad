
# 🎙 Assignment 17: Add Audio Recording

## 🎯 Objective

Create a React component that enables users to **record, review, and store audio responses** using the **Media API**. This feature will allow users of the **IELTS Speaking Test Platform** to record their spoken responses and prepare them for backend submission.

---

## 📘 Scenario

The IELTS Speaking Test platform requires users to **record audio responses** during the test. The system should:

* Allow users to record audio.
* Review/playback the recordings.
* Prepare audio blobs for backend transmission.

---

## ✅ Requirements

### 1. Audio Recording

* 🎤 Access microphone using `navigator.mediaDevices.getUserMedia({ audio: true })`.
* ⏺ Enable manual or timed recording using the MediaRecorder API.

### 2. React Component

* 🔧 Component includes:

  * Start/Stop buttons
  * Audio playback feature

### 3. Storing Recordings

* 💾 Store audio as a `Blob`.
* 📤 Prepare for API upload using `FormData`.

### 4. Error Handling

* ❌ Handle permission denial and recording failures.
* 💬 Show user-friendly error messages and recording indicators.

### 5. Styling

* 🎨 Clean, intuitive UI with visual feedback (e.g., recording state).

---

## 📁 Deliverables

* `AudioRecorder.tsx` (or `.jsx`) React component file
* Local audio playback functionality
* Ready-to-send audio blob via API
* Test evidence (console logs, screenshots, or test results)

---

## 💻 Implementation Overview

### 🔧 Media API + MediaRecorder

```ts
const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
const recorder = new MediaRecorder(stream);
```

### 🔊 Audio Playback

```tsx
<audio controls src={URL.createObjectURL(audioBlob)} />
```

### 📤 API Submission (Example)

```ts
const formData = new FormData();
formData.append("audio", audioBlob, "response.wav");

await fetch("/upload", {
  method: "POST",
  body: formData
});
```

---

## 🧪 Testing Checklist

| Feature             | Status | Notes                                  |
| ------------------- | ------ | -------------------------------------- |
| Microphone Access   | ✅      | Handles permission prompt and fallback |
| Start/Stop Controls | ✅      | Button toggles recording               |
| Recording Storage   | ✅      | Audio saved as blob in React state     |
| Playback            | ✅      | Audio preview available                |
| Error Handling      | ✅      | Alerts on access denial or failures    |
| API Readiness       | ✅      | Blob ready for submission              |

---

## 🏆 Evaluation Criteria

| Criteria                    | Weight |
| --------------------------- | ------ |
| ✅ Audio Recording           | 40%    |
| ✅ Integration & Usability   | 30%    |
| ✅ Error Handling & Feedback | 20%    |
| ✅ Submission Completeness   | 10%    |

---

## 💡 Hints & Tips

* Use `useState` for managing audio blob.
* Wrap MediaRecorder in `useRef` for persistent access.
* Add CSS feedback like blinking red dot while recording.
* Validate `MediaRecorder` support for cross-browser compatibility.

---

## 🖼 Sample UI (Suggested)

* 🎤 Start Recording
* ⏹ Stop Recording
* ▶️ Play Recording
* 📤 Upload Button (Optional)
* 🔴 Recording Indicator

---

