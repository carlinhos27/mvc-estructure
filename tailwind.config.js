/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      './app/views/**/*.php', // Rutas de tus vistas de PHP
      './public/**/*.php',    // Si tienes archivos PHP en public
      './app/**/*.php',       // Si usas Tailwind en cualquier archivo PHP en app
    ],
    theme: {
      extend: {},
    },
    plugins: [
      require('daisyui'), // Agregar DaisyUI si lo estás utilizando
    ],
  }
  