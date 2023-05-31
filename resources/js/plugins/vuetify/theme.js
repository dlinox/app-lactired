const theme = {
    defaultTheme: "light",
    themes: {
        light: {
            dark: false,
            colors: {
                'anchor-base' : "#9fce33", 
                primary: "#9fce33",
                secondary: "#8A8D93",
                "on-secondary": "#fff",
                success: "#56CA00",
                info: "#16B1FF",
                warning: "#FFB400",
                error: "#ff5253",
                "on-primary": "#FFFFFF",
                "on-success": "#FFFFFF",
                "on-warning": "#FFFFFF",
                background: "#f2f3f8",
                "on-background": "#3A3541",
                surface: "#FAFAFA",
                "on-surface": "#3A3541",
                "on-surface-variant": "#DADADA",
                "grey-50": "#FAFAFA",
                "grey-100": "#F5F5F5",
                "grey-200": "#EEEEEE",
                "grey-300": "#E0E0E0",
                "grey-400": "#BDBDBD",
                "grey-500": "#9E9E9E",
                "grey-600": "#757575",
                "grey-700": "#616161",
                "grey-800": "#424242",
                "grey-900": "#212121",
            },
            variables: {
                "border-color": "#3A3541",
                "medium-emphasis-opacity": 0.68,
                // Shadows
                "shadow-key-umbra-opacity":
                    "rgba(var(--v-theme-on-surface), 0.08)",
                "shadow-key-penumbra-opacity":
                    "rgba(var(--v-theme-on-surface), 0.12)",
                "shadow-key-ambient-opacity":
                    "rgba(var(--v-theme-on-surface), 0.04)",
            },
     
        },
        dark: {
            dark: true,
            colors: {
                primary: "#9fce33",
                secondary: "#8A8D93",
                "on-secondary": "#fff",
                success: "#56CA00",
                info: "#16B1FF",
                warning: "#FFB400",
                error: "#FF4C51",
                "on-primary": "#FFFFFF",
                "on-success": "#FFFFFF",
                "on-warning": "#FFFFFF",
                background: "#1A2232",
                "on-background": "#E7E3FC", //FF0000
                surface: "#111827",
                "on-surface": "#E7E3FC",
                "on-surface-variant": "#2B3441",
                "grey-50": "#2A2E42",
                "grey-100": "#2F3349",
                "grey-200": "#4A5072",
                "grey-300": "#5E6692",
                "grey-400": "#7983BB",
                "grey-500": "#8692D0",
                "grey-600": "#AAB3DE",
                "grey-700": "#B6BEE3",
                "grey-800": "#CFD3EC",
                "grey-900": "#E7E9F6",
            },
            variables: {
                "border-color": "#E7E3FC",
                "medium-emphasis-opacity": 0.68,
                // Shadows
                "shadow-key-umbra-opacity": "rgba(40, 40, 40, 0.18)",
                "shadow-key-penumbra-opacity": "rgba(40, 40, 40, 0.25)",
                "shadow-key-ambient-opacity": "rgba(40, 40, 40, 0.09)",
            },
        },
    },
};
export default theme;
