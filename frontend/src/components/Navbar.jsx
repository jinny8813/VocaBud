import React, { useState } from 'react';
import { Link, Outlet } from 'react-router-dom';

const Navbar = () => {
  const [navbarOpen, setNavbarOpen] = useState(false);

  return (
    <header className="sticky top-0 bg-gray-800 w-full">
      <nav className="flex items-center justify-between p-0">
        <div className="flex items-center">  
          <Link to="/" className="flex items-center p-3 text-white">
            <img src="/assets/images/icon.png" className="h-8 w-auto mr-2" alt="Logo" />
            Vocabud
          </Link>
        </div>
        <Outlet />

        <button
          className="p-3 text-white focus:outline-none md:hidden"
          onClick={() => setNavbarOpen(!navbarOpen)}
        >
          <i className="fas fa-bars"></i>
        </button>

        <div className={`${navbarOpen ? 'block' : 'hidden'} w-full md:flex md:items-center md:justify-end md:w-auto`}>
          <ul className="flex flex-col md:flex-row">
            <li className="nav-item">
              <Link className="block p-3 text-white" to="/cards">我的字卡</Link>
            </li>
            <li className="nav-item">
              <Link className="block p-3 text-white" to="/playground">遊戲廣場</Link>
            </li>
            <li className="nav-item">
              <Link className="block p-3 text-white" to="/quizlets">測驗大廳</Link>
            </li>
            <li className="nav-item">
              <Link className="block p-3 text-white" to="/statistics">統計收集</Link>
            </li>
            <li className="nav-item">
              <Link className="block p-3 text-white" to="/personal">個人設定</Link>
            </li>
            <li className="nav-item">
              <Link className="block p-3 text-white" to="#">登出</Link>
            </li>
          </ul>
        </div>
      </nav>
    </header>
  );
};

export default Navbar;
