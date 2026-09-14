module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#4CAF50",
        "primary-dark": "#3d9140",
        "primary-light": "#81c784",
        "primary-container": "#4CAF50",
        "on-primary": "#ffffff",
        "on-primary-container": "#1b4d20",
        "surface": "#f5f9f6",
        "surface-bright": "#fbfdfb",
        "surface-container-lowest": "#ffffff",
        "surface-container-low": "#f0f6f2",
        "surface-container": "#e6efe8",
        "surface-container-high": "#dbe8dd",
        "surface-container-highest": "#cfe0d4",
        "on-surface": "#233327",
        "on-surface-variant": "#536657",
        "secondary": "#2e7d32",
        "secondary-container": "#e2f2e5",
        "on-secondary-container": "#1e4624",
        "tertiary": "#5c8d67",
        "tertiary-container": "#ebf6ee",
        "outline": "#8b9e90",
        "outline-variant": "#d3e0d6",
        "error": "#d32f2f",
        "error-container": "#ffebee",
        "on-error": "#ffffff",
        "on-error-container": "#c62828"
      },
      borderRadius: {
        "DEFAULT": "0.125rem",
        "lg": "0.25rem",
        "xl": "0.5rem",
        "full": "0.75rem"
      },
      spacing: {
        "gutter-sm": "0.5rem",
        "gutter-lg": "1.5rem",
        "sidebar-width": "260px",
        "card-padding": "1.5rem",
        "container-padding-mobile": "1rem",
        "gutter-md": "1rem",
        "container-padding-desktop": "2rem",
        "gutter-xl": "2rem",
        "gutter-xs": "0.25rem"
      },
      fontFamily: {
        "label-lg": ["Inter", "sans-serif"],
        "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
        "headline-lg-mobile": ["Plus Jakarta Sans", "sans-serif"],
        "body-lg": ["Inter", "sans-serif"],
        "body-sm": ["Inter", "sans-serif"],
        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
        "display-lg": ["Plus Jakarta Sans", "sans-serif"],
        "label-sm": ["Inter", "sans-serif"],
        "financial-tabular": ["Inter", "sans-serif"],
        "body-md": ["Inter", "sans-serif"],
        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
        "label-md": ["Inter", "sans-serif"]
      },
      fontSize: {
        "label-lg": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
        "headline-sm": ["18px", {"lineHeight": "26px", "letterSpacing": "0em", "fontWeight": "600"}],
        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
        "body-sm": ["12px", {"lineHeight": "18px", "fontWeight": "400"}],
        "headline-md": ["22px", {"lineHeight": "30px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
        "display-lg": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
        "label-sm": ["11px", {"lineHeight": "14px", "letterSpacing": "0.03em", "fontWeight": "500"}],
        "financial-tabular": ["15px", {"lineHeight": "22px", "letterSpacing": "0.02em", "fontWeight": "600"}],
        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
        "headline-lg": ["30px", {"lineHeight": "38px", "letterSpacing": "-0.015em", "fontWeight": "700"}],
        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "600"}]
      }
    }
  },
  plugins: [],
}
