module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.vue',
    './resources/**/*.js',
  ],
  safelist: [
  // layout & positioning
  'fixed','top-0','left-0','right-0','h-14','z-10','z-40','flex','items-center','justify-between',
  'px-4','p-4','w-full','mx-auto','max-w-lg','max-w-3xl','gap-2','gap-3','mb-2','mr-2','mt-8','mt-2',
  'nav-overlap','search-bar','shadow-lg','relative','-translate-y-1/2','overflow-x-auto',

  // colors
  'bg-gray-800','bg-white','bg-blue-500','bg-blue-700',
  'border-b','border-gray-200','dark:border-gray-700','border-l-4','border-double','border-t',
  'text-white','text-gray-500','text-gray-600','text-gray-800','hover:text-blue-400','hover:text-gray-800',
  'text-green-600','text-red-600','text-blue-600','text-xs','text-sm','text-lg','text-2xl','font-bold','font-semibold',

  // buttons / avatar
  'rounded-full','rounded-md','rounded-lg','px-6','px-4','py-2','flex','items-center','justify-center',
  'hover:opacity-80','transition','duration-200','focus:outline-none','focus:ring-2','focus:ring-blue-500',

  // dark mode
  'dark',

  // svg icons
  'w-6','h-6','fill-none','stroke-current','stroke-2','object-cover','cursor-pointer','hover:shadow-lg','border','border-gray-300',

  // misc
  'sr-only'
],

  darkMode: 'class',
  theme: {
    extend: {
      fontSize: {
      'xxs': '10px',
      'xxxs': '9px',
    },
      colors: {
        dark: { DEFAULT: '#1e2125' },
      },
      height: { 'screen-safe': 'calc(100vh - 140px)' },
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
