import React from 'react'
import ReactDOM from 'react-dom/client'
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import App from './App';
import Home from './pages/Home';
import About from './pages/About';
import History from './pages/History';
import Navbar from './pages/Navbar';

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <Router>
      <Routes>
        <Route path="/" element={<App />}>
          <Route index element={<Home />} />
          <Route path="about" element={<About />}>
            <Route path="history" element={<History />} />
            <Route path="navbar" element={<Navbar />} />
          </Route>
        </Route>
      </Routes>
    </Router>
  </React.StrictMode>,
)