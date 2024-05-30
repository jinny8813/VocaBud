import React from 'react';

const ScrollToTopBtn = () => {
  return (
    <section>
      <div className="h-8 m-4 fixed bottom-0 right-0 z-50">
        <a href="#" className="text-white">
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </section>
  );
};

export default ScrollToTopBtn;
