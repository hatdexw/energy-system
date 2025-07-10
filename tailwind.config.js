/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#4F46E5', // Indigo 600
          light: '#6366F1',  // Indigo 500
          dark: '#4338CA',   // Indigo 700
        },
        secondary: {
          DEFAULT: '#10B981', // Emerald 500
          light: '#34D399',  // Emerald 400
          dark: '#059669',   // Emerald 600
        },
        accent: {
          DEFAULT: '#F59E0B', // Amber 500
          light: '#FBBF24',  // Amber 400
          dark: '#D97706',   // Amber 600
        },
        neutral: {
          50: '#F9FAFB',
          100: '#F3F4F6',
          200: '#E5E7EB',
          300: '#D1D5DB',
          400: '#9CA3AF',
          500: '#6B7280',
          600: '#4B5563',
          700: '#374151',
          800: '#1F2937',
          900: '#111827',
        },
        danger: '#EF4444', // Red 500
        success: '#22C55E', // Green 500
        warning: '#F59E0B', // Amber 500
        info: '#3B82F6',    // Blue 500
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Usando Inter como fonte principal
      },
    },
  },
  plugins: [],
}