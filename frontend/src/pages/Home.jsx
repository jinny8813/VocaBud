import React from "react";
import HomeProfile from "../components/HomeProfile";
import LearningReport from "../components/LearningReport";
import HomeNavigation from "../components/HomeNavigation";

function Home() {
  return (
    <div>
      <HomeProfile />
      <LearningReport />
      <HomeNavigation />
    </div>
  );
}

export default Home;
