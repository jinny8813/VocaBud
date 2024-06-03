/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        brand: {
          darkgreen: "#2C4C01",
          mediumgreen: "#628100",
          bluegray: "#505C58",
          darkyellow: "#DFC403",
          purple: "#B686DB",
          indigo: "#7781DE",
          blue: "#63AFD9",
          bluegreen: "#5EC7B4",
          green: "#95CD7B",
          yellow: "#E6E164",
        },
      },
    },
  },
  plugins: [],
};
