import React, { useState } from 'react';
import { Link, Outlet } from 'react-router-dom';

const Navbar = () => {
  const [navbarOpen, setNavbarOpen] = useState(false);

  return (
    <header className="sticky top-0 bg-gray-800">
      <nav className="flex items-center justify-between p-0">
        <div className="img_h">  
          <Link to="/" className="flex items-center p-3 text-white">
            <img src="/assets/images/icon.png" className="h-full px-2" alt="Logo" />
            Vocabud
          </Link>
        </div>
        <Outlet />

        <button
          className="p-3 text-white focus:outline-none"
          onClick={() => setNavbarOpen(!navbarOpen)}
        >
          <i className="fas fa-bars"></i>
        </button>

        <div className={`${navbarOpen ? 'block' : 'hidden'} w-full md:flex md:items-center md:justify-end md:w-auto`}>
          <ul className="flex flex-col md:flex-row">
            <li className="nav-item">
              <a className="block p-3 text-white" href="/cards">我的字卡</a>
            </li>
            <li className="nav-item">
              <a className="block p-3 text-white" href="#">分享廣場</a>
            </li>
            <li className="nav-item">
              <a className="block p-3 text-white" href="/quizlets">測驗大廳</a>
            </li>
            <li className="nav-item">
              <a className="block p-3 text-white" href="/statistics">統計收集</a>
            </li>
            <li className="nav-item">
              <a className="block p-3 text-white" href="/personal">個人設定</a>
            </li>
            <li className="nav-item">
              <a className="block p-3 text-white" href="/logout">登出</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
  );
};

export default Navbar;
