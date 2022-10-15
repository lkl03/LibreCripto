/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./styles/**/*.{js,ts,jsx,tsx}", "./pages/**/*.{js,ts,jsx,tsx}", "./components/**/*.{js,ts,jsx,tsx}"],
  mode: "jit",
  theme: {
    extend: {
      colors: {
        orange: "#fe9416",
        black: "#121212",
      },
      fontFamily: {
        openSans: ["Open Sans", "sans-serif"],
        montserrat: ["Montserrat", "sans-serif"],
      },
    },
    screens: {
      xs: "480px",
      ss: "620px",
      sm: "768px",
      md: "1060px",
      lg: "1200px",
      xl: "1700px",
    },
  },
  plugins: [],
};
