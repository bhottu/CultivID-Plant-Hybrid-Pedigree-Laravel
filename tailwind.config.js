/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.vue',
    './resources/**/*.js',
  ],
  darkMode: 'class', // Mode gelap berdasarkan class
  theme: {
    extend: {
      colors: {
        dark: {
          DEFAULT: '#333333', // Contoh penambahan warna gelap kustom
        },
      },
    },
  },
  plugins: [],
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.vue',
    './resources/**/*.js',
  ],
};
