import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import './App.css'
import Navbar from './components/Navbar';
import Home from './pages/Home';
import Cards from './pages/Cards';
import Playground from './pages/Playground';
import Quizlets from './pages/Quizlets';
import Statistics from './pages/Statistics';
import Personal from './pages/Personal';

function App() {
  return (
  <Router>
    <Navbar/>
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/cards" element={<Cards />} />
      <Route path="/playground" element={<Playground />} />
      <Route path="/quizlets" element={<Quizlets />} />
      <Route path="/statistics" element={<Statistics />} />
      <Route path="/personal" element={<Personal />} />
    </Routes>
  </Router>
  );
}

export default App
