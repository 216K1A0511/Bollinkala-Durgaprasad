import React from 'react' ;

const Header: React.FC = () => {
    return (
        <header>
            <h1>IELTS Speaking Test Platform</h1>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#dashboard">Dashboard</a></li>
                </ul>
            </nav>
        </header>
     );
};

export default Header;