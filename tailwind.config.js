import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
                arabic: ['"Amiri Quran"', 'Amiri', 'serif'],
            },
            colors: {
                canvas: 'rgb(var(--lq-canvas) / <alpha-value>)',
                surface: {
                    DEFAULT: 'rgb(var(--lq-surface) / <alpha-value>)',
                    low: 'rgb(var(--lq-surface-low) / <alpha-value>)',
                    container: 'rgb(var(--lq-surface-container) / <alpha-value>)',
                    card: 'rgb(var(--lq-card) / <alpha-value>)',
                },
                brand: {
                    navy: '#0F2D4F',
                    'navy-deep': '#001833',
                    teal: 'rgb(var(--lq-teal) / <alpha-value>)',
                    gold: '#D9A94A',
                    'gold-hover': '#C4963A',
                    'gold-pale': '#FCE9A8',
                },
                ink: {
                    DEFAULT: 'rgb(var(--lq-text-primary) / <alpha-value>)',
                    muted: 'rgb(var(--lq-text-muted) / <alpha-value>)',
                },
                line: 'rgb(var(--lq-border) / <alpha-value>)',
                footer: {
                    bg: 'rgb(var(--lq-footer-bg) / <alpha-value>)',
                    text: 'rgb(var(--lq-footer-text) / <alpha-value>)',
                    muted: 'rgb(var(--lq-footer-muted) / <alpha-value>)',
                },
                danger: {
                    DEFAULT: '#BA1A1A',
                    container: '#FFDAD6',
                    ink: '#93000A',
                },
            },
            fontSize: {
                'display-lg': ['48px', { lineHeight: '56px', letterSpacing: '-0.02em', fontWeight: '700' }],
                'display-mobile': ['32px', { lineHeight: '40px', letterSpacing: '-0.01em', fontWeight: '700' }],
                'headline-lg': ['32px', { lineHeight: '40px', letterSpacing: '-0.01em', fontWeight: '600' }],
                'headline-md': ['24px', { lineHeight: '32px', fontWeight: '600' }],
                'headline-sm': ['20px', { lineHeight: '28px', fontWeight: '600' }],
                'title-md': ['16px', { lineHeight: '24px', fontWeight: '600' }],
                'body-lg': ['18px', { lineHeight: '30px', fontWeight: '400' }],
                'body-md': ['15px', { lineHeight: '24px', fontWeight: '400' }],
                'body-sm': ['13px', { lineHeight: '20px', fontWeight: '400' }],
                'label-md': ['12px', { lineHeight: '16px', letterSpacing: '0.06em', fontWeight: '600' }],
                'label-sm': ['11px', { lineHeight: '14px', letterSpacing: '0.04em', fontWeight: '500' }],
            },
            borderRadius: {
                sm: '0.25rem',
                DEFAULT: '0.5rem',
                md: '0.75rem',
                lg: '1rem',
                card: 'var(--lq-radius-card)',
                xl: '1.5rem',
                full: '9999px',
            },
            spacing: {
                gutter: 'var(--lq-gutter)',
                'gutter-mobile': 'var(--lq-gutter-mobile)',
                section: 'var(--lq-margin)',
                'section-mobile': 'var(--lq-margin-mobile)',
                'space-xs': '0.25rem',
                'space-sm': '0.5rem',
                'space-md': '1rem',
                'space-lg': '1.5rem',
                'space-xl': '2.5rem',
            },
            maxWidth: {
                browse: '1200px',
                mushaf: '840px',
            },
            boxShadow: {
                card: 'var(--lq-shadow-card)',
                'ayah-active': 'var(--lq-shadow-ayah-active)',
                overlay: 'var(--lq-shadow-overlay)',
                'teal-ring': '0 0 0 3px rgba(42, 123, 132, 0.18)',
            },
        },
    },

    plugins: [forms],
};
