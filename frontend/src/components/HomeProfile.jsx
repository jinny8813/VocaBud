import React from "react";
import bannerImage from "../../public/assets/images/banner.jpg";

const HomeProfile = () => {
  return (
    <section className="min-h-screen bg-light flex flex-col relative">
      <div className="w-full">
        <img className="w-full h-auto" src={bannerImage} alt="Banner" />
      </div>
      <div className="relative flex-grow">
        <div className="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
          <div className="bg-white shadow-md rounded p-6">
            <div className="text-center text-2xl">的個人主頁</div>
          </div>
        </div>
      </div>
      <div className="flex-grow bg-light p-8"></div>
    </section>
  );
};

export default HomeProfile;
