import React from 'react';
import './Header.css';

const Header: React.FC = () => {
  return (
    <header className="header">
      <h1>IELTS Speaking Test Platform</h1>
      <nav>
        <a href="/" className="nav-link">Home</a>
        <a href="/dashboard" className="nav-link">Dashboard</a>
      </nav>
    </header>
  );
};

export default Header;