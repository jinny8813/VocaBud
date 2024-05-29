import React from 'react';
import { Link, Outlet } from 'react-router-dom';

function About() {
  return (
    <div>
      <h2>About Page</h2>
      <nav>
        <ul>
          <li><Link to="history">History</Link></li>
          <li><Link to="navbar">Navbar</Link></li>
        </ul>
      </nav>
      <Outlet />
    </div>
  );
}

export default About;
