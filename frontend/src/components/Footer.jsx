import React from 'react';

const Footer = () => {
  return (
    <footer className="bg-gray-800 w-full">
      <div className="p-6 text-center text-white">
        {`Copyright © 2023-${new Date().getFullYear()} VocaBud`}
      </div>
    </footer>
  );
};

export default Footer;
