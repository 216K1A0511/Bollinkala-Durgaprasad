# ✅ Assignment 23: Integration Testing

**IELTS Speaking Test Platform – Comprehensive System Validation**

---

## 🎯 Objective

Ensure seamless interaction between the React frontend, Flask backend, database, and APIs. Document each test case, report identified issues, and validate that features work as a unified, reliable system.

---

## 🔍 1. Test Scope

| Area                   | Description                                                                |
| ---------------------- | -------------------------------------------------------------------------- |
| Frontend ↔ Backend     | Validate all API calls and frontend data rendering                         |
| Backend ↔ Database     | Test CRUD operations and model integrity                                   |
| Auth & Role Management | Test login/logout, token validation, and role-based access control         |
| Functional Workflows   | Ensure smooth flow of test start, timer, submission, and response handling |

---

## 📋 2. Integration Test Cases

| TC No. | Test Description                              | Expected Result                           | Actual Result       | Status | Fix Applied                     |
| ------ | --------------------------------------------- | ----------------------------------------- | ------------------- | ------ | ------------------------------- |
| TC001  | Login with valid credentials                  | Token issued and user redirected          | As expected         | ✅ Pass | —                               |
| TC002  | Submit invalid credentials                    | Error message shown                       | Error shown         | ✅ Pass | —                               |
| TC003  | Fetch questions via API                       | Question list displayed in UI             | API 200, data shown | ✅ Pass | —                               |
| TC004  | Submit a response                             | Response stored in DB, confirmation shown | DB entry confirmed  | ✅ Pass | —                               |
| TC005  | Access admin panel as test taker              | Access denied                             | 403 error triggered | ✅ Pass | —                               |
| TC006  | Access test as admin                          | Redirect or warning                       | Redirected properly | ✅ Pass | —                               |
| TC007  | Token expired after timeout                   | Redirect to login                         | Redirected          | ✅ Pass | —                               |
| TC008  | Submit test under load (10+ concurrent users) | All requests succeed with no delay        | Minor lag, handled  | ✅ Pass | Increased thread limit in Flask |
| TC009  | Failed API response due to network error      | Retry or error feedback shown in UI       | UI shows error      | ✅ Pass | Retry mechanism added           |

---

## 🚨 3. Error Scenarios & Fixes

| Error Encountered                        | Fix Applied                                                 |
| ---------------------------------------- | ----------------------------------------------------------- |
| Login allowed with wrong credentials     | Fixed backend validation and updated error messages         |
| API call failed with large payloads      | Increased payload limits in Flask config                    |
| Concurrent submissions caused 500 error  | Updated DB session handling and introduced threading limits |
| UI showed blank screen on expired tokens | Added token expiry check and redirect logic on the frontend |
| Time delay not syncing on different tabs | Switched to server-side countdown timer                     |

---

## 🧪 4. Tools Used for Testing

| Tool                 | Purpose                                     |
| -------------------- | ------------------------------------------- |
| **Postman**          | Manual API testing (GET, POST, PUT, DELETE) |
| **Browser DevTools** | Monitor network activity, errors, and logs  |
| **JMeter/Locust**    | Performance and concurrency testing         |
| **Lighthouse**       | UI accessibility and performance audits     |
| **React DevTools**   | State and prop debugging for UI components  |

---

## 📦 5. Evidence of Testing

* ✅ **Screenshots** of API responses from Postman
* ✅ **Browser logs** showing successful API interaction
* ✅ **Terminal logs** of concurrent submissions tested via Locust
* ✅ **UI Screenshots** of login, test panel, timer, and submission confirmation
* ✅ **JMeter Results** showing acceptable latency under 15+ concurrent users

> 📁 Screenshots and logs are available in the `/evidence/assignment-23` folder of the repo.

---

## 🧩 6. Critical Workflow Validations

| Workflow                       | Test Status | Notes                                 |
| ------------------------------ | ----------- | ------------------------------------- |
| Login → Start Test → Submit    | ✅ Pass      | Fully functional, token-based routing |
| Admin Login → Dashboard Access | ✅ Pass      | Role-guarded access confirmed         |
| Timer Sync and Auto-submit     | ✅ Pass      | Works across sessions and tabs        |
| Response Storage and Retrieval | ✅ Pass      | Data persists and loads correctly     |

---

## 📈 7. Summary

* **Test Coverage:** ✔️ All major workflows and API interactions tested
* **Bugs Resolved:** 🐛 5 major and 2 minor issues fixed
* **System Stability:** ✅ Stable under normal and moderate load
* **Access Control:** 🔒 Role-based routes work as intended
* **Data Flow:** 🔁 Accurate and synchronized across all layers

---

## 📁 Submission Includes

* `/integration-tests/report.md`: ✅ Full test case table and summary
* `/evidence/`: 📸 Screenshots of frontend/backend testing
* `/fixes/summary.txt`: 🛠️ Bug descriptions and resolution notes
* `/logs/`: 🧾 Terminal outputs and API logs

---

