
# IELTS Speaking Test Platform

This is a React-based web application designed to simulate an IELTS Speaking Test platform. It includes features like user authentication, protected routes, and dashboards for admins and test takers.

## Features

- **Public Routes**:
  - Home Page: General information about the platform.
  - Login Page: Allows users to authenticate.

- **Protected Routes**:
  - Admin Dashboard: For managing test settings and user accounts.
  - Test Taker Dashboard: For taking practice tests.

- **Authentication**:
  - Simulated login functionality using `localStorage`.
  - Protected routes redirect unauthenticated users to the login page.

- **Tech Stack**:
  - React (with TypeScript)
  - React Router DOM for routing
  - Inline CSS for styling

---

## Getting Started

Follow these steps to set up and run the project locally.

### Prerequisites

- Node.js (v16 or higher)
- npm (v8 or higher)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/ielts-speaking-test.git
   cd ielts-speaking-test
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Start the development server:
   ```bash
   npm start
   ```

4. Open your browser and navigate to:
   ```
   http://localhost:3000
   ```

---

## Folder Structure

```
src/
├── components/
│   ├── Home.tsx
│   ├── Login.tsx
│   ├── AdminDashboard.tsx
│   ├── TestTakerDashboard.tsx
│   └── PrivateRoute.tsx
├── App.tsx
├── index.tsx
```

---

## Usage

### Public Routes

- **Home Page** (`/`):
  - Displays general information about the platform.

- **Login Page** (`/login`):
  - Allows users to log in by entering an email and password.
  - On successful login, the user is redirected to the Admin Dashboard.

### Protected Routes

- **Admin Dashboard** (`/admin-dashboard`):
  - Accessible only to authenticated users.
  - Displays options for managing test settings and user accounts.

- **Test Taker Dashboard** (`/test-taker-dashboard`):
  - Accessible only to authenticated users.
  - Displays options for starting practice tests.

---

## Testing

1. **Public Routes**:
   - Visit `/` to see the home page.
   - Visit `/login` to see the login form.

2. **Protected Routes**:
   - Try accessing `/admin-dashboard` or `/test-taker-dashboard` without logging in. You will be redirected to `/login`.

3. **After Login**:
   - Enter any email and password in the login form and submit.
   - You will be redirected to `/admin-dashboard` and can now access both protected routes.

---



## Contributing

Contributions are welcome! If you'd like to contribute, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Commit your changes.
4. Push your branch and submit a pull request.

---



## Acknowledgments

- [React](https://reactjs.org/)
- [React Router DOM](https://reactrouter.com/)
- [TypeScript](https://www.typescriptlang.org/)

---

## Contact

For questions or feedback, please reach out to:

- **Your Name**  
- **Email**: durgaprasad201803@gmail.com  
- **GitHub**: [216K1A0511](https://github.com/216K1A0511)

