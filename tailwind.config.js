/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.vue',
    './resources/**/*.js',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        dark: {
          DEFAULT: '#1e2125',
        },
      },
      height: {
        'screen-safe': 'calc(100vh - 140px)',
      },
      spacing: {
        'header': '56px',
        'nav': '72px',
        'safe-top': 'max(0.5rem, env(safe-area-inset-top))',
        'safe-bottom': 'max(0.5rem, env(safe-area-inset-bottom))',
      },
    },
  },
  plugins: [],
};
