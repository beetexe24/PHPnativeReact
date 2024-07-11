/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
    "./node_modules/flowbite/**/*.{js, ts, jsx, tsx}",
    'node_modules/flowbite-react/lib/esm/**/*.{js, ts, jsx, tsx}',
    "./node_modules/react-tailwindcss-datepicker/dist/index.esm.js",
  ],
  theme: {
    screens: {
      sm: '680px',
      md: '968px',
      lg: '1076px',
      xl: '1440px',
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
