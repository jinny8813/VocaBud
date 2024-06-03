import React from "react";
import { Link } from "react-router-dom";

const HomeNavigation = () => {
  return (
    <div className="container-fluid">
      <div className="grid grid-cols-12 gap-0">
        <div className="col-span-6 md:col-span-6 bg-brand-mediumgreen">
          <div className="text-center text-lg py-5">
            <Link className="text-white" to="/cards">
              我的字卡
            </Link>
          </div>
        </div>
        <div className="col-span-6 md:col-span-3 bg-brand-bluegray">
          <div className="text-center text-lg py-5">
            <Link className="text-white" to="/playground">
              分享廣場
            </Link>
          </div>
        </div>
        <div className="col-span-12 md:col-span-3 bg-brand-darkgreen">
          <div className="text-center text-lg py-5">
            <Link className="text-white" to="/quizlets">
              測驗大廳
            </Link>
          </div>
        </div>
        <div className="col-span-6 md:col-span-4 bg-brand-bluegray">
          <div className="text-center text-lg py-5">
            <Link className="text-white" to="/statistics">
              統計收集
            </Link>
          </div>
        </div>
        <div className="col-span-6 md:col-span-8 bg-brand-mediumgreen">
          <div className="text-center text-lg py-5">
            <Link className="text-white" to="#">
              個人設定
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default HomeNavigation;
