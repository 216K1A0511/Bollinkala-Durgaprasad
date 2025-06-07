
# ♿ Assignment 21: Improve Accessibility

**IELTS Speaking Test Platform**

---

## 🎯 Objective

Enhance platform accessibility by integrating ARIA (Accessible Rich Internet Applications) attributes and ensuring complete keyboard navigability. These updates aim to make the platform inclusive and compliant with accessibility standards.

---

## 📘 Scenario

To support users with disabilities, the interface must be screen-reader friendly and operable entirely via the keyboard. This assignment focuses on improving semantic meaning, form accessibility, and navigation experience using ARIA attributes and keyboard support.

---

## ✅ Requirements

### 1. Add ARIA Attributes

* Use semantic ARIA roles:

  * `role="button"`, `role="dialog"`, `role="navigation"`, etc.
* Define states and properties:

  * `aria-selected`, `aria-expanded`, `aria-label`, `aria-labelledby`
* Provide real-time updates:

  * `aria-live="polite"` or `aria-live="assertive"` for test instructions or timers

### 2. Keyboard Navigability

* Ensure all elements such as buttons, links, modals, tabs, and inputs are reachable via `Tab`
* Add `tabIndex="0"` where needed
* Visual focus indicators using Tailwind or custom CSS:

  ```css
  button:focus {
    outline: 2px solid #1E3A8A;
    outline-offset: 2px;
  }
  ```

### 3. Accessible Forms

* Associate form inputs and labels:

  ```html
  <label htmlFor="name">Full Name</label>
  <input id="name" aria-describedby="nameHelp" />
  <small id="nameHelp">Enter your legal name</small>
  ```
* Display error messages with `aria-describedby`

### 4. Accessibility Testing

* Audit using [Lighthouse](https://developer.chrome.com/docs/lighthouse/accessibility/) or [axe DevTools](https://www.deque.com/axe/)
* Fix issues such as missing labels, insufficient contrast, and improper heading levels

---

## 🔧 Examples and Snippets

### 🧠 ARIA in Modals

```jsx
<div role="dialog" aria-labelledby="modal-title" aria-modal="true">
  <h2 id="modal-title">Test Instructions</h2>
  <p>Read carefully before you begin.</p>
</div>
```

### 🧩 ARIA in Live Regions

```jsx
<div aria-live="polite">
  {testStatus}
</div>
```

### ⌨️ Keyboard Event Example

```tsx
const handleKeyDown = (event: React.KeyboardEvent<HTMLButtonElement>) => {
  if (event.key === 'Enter') {
    submitForm();
  }
};
```

### 🏷 Custom Dropdown

```jsx
<button aria-expanded="false" aria-controls="dropdownMenu" tabIndex={0}>Options</button>
<ul id="dropdownMenu" role="menu">
  <li role="menuitem">Start Test</li>
</ul>
```

---

## 🧪 Testing Checklist

### 🔹 Keyboard Navigation

* [x] Can navigate through all interactive elements using `Tab`
* [x] Logical focus order is maintained
* [x] Custom components are focusable with `tabIndex`

### 🔹 ARIA Audit (Lighthouse / axe)

* [x] All inputs are labeled
* [x] Landmarks and roles are appropriately used
* [x] No critical ARIA violations reported

### 🔹 Live Updates & Modals

* [x] Screen reader announces test status changes and timer
* [x] Focus shifts to modal content when opened

---

## 📁 Deliverables

| File/Folder                     | Description                                             |
| ------------------------------- | ------------------------------------------------------- |
| `components/Modal.tsx`          | Includes ARIA roles and focus trap logic                |
| `components/Form.tsx`           | Uses `aria-describedby`, proper labeling, and tab order |
| `components/Timer.tsx`          | Uses `aria-live` for screen reader announcements        |
| `report/lighthouse-report.png`  | Screenshot of Lighthouse audit report                   |
| `report/accessibility_notes.md` | Description of resolved accessibility issues            |

---

## 📈 Evaluation Criteria

| Criteria                      | Weight |
| ----------------------------- | ------ |
| ✅ Use of ARIA Attributes      | 40%    |
| ⌨️ Keyboard Navigability      | 30%    |
| 🧪 Testing & Issue Resolution | 20%    |
| 📦 Submission Completeness    | 10%    |

---



