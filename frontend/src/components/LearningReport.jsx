import React from "react";

const LearningReport = () => {
  return (
    <div className="container mx-auto py-5">
      <div className="flex justify-center mb-3">
        <div className="w-full md:w-8/12">
          <div className="text-lg mb-2">學習快報</div>
        </div>
      </div>
      <div className="flex justify-center">
        <div className="w-full md:w-8/12">
          <div className="bg-white shadow-md rounded p-6">
            <div className="mb-2 text-sm">本週學習打卡紀錄</div>
            <div id="calender"></div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LearningReport;
