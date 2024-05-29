import React from 'react';
import { Link, Outlet } from 'react-router-dom';
import './App.css'

function App() {
  return (
  <div>
    <header>
      <nav>
        <ul>
          <li><Link to="/">Home</Link></li>
          <li><Link to="/about">About</Link></li>
        </ul>
      </nav>
    </header>
    <main>
      <Outlet />
    </main>
  </div>
  );
}

export default App
