/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./src/Form/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        'gunmetal' : 'var(--gunmetal)',
        'midnight-green': 'var(--midnight-green)',
        'caribbean-current': 'var(--caribbean-current)',
        'cream': 'var(--cream)',
        'forest-green': 'var(--forest-green)',
        'aerospace-orange': 'var(--aerospace-orange)',
        'primary-color': 'var(--primary-color)',
        'secondary-color': 'var(--secondary-color)',
        'tertiary-color': 'var(--tertiary-color)',
        'tertiary-hover-color': 'var(--tertiary-hover-color)',
        'primary-accent-color': 'var(--primary-accent-color)',
        'secondary-accent-color': 'var(--secondary-accent-color)',
      },
    },
  },
  plugins: [],
}

