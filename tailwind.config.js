// Full configuration File
// https://github.com/tailwindlabs/tailwindcss/blob/master/stubs/defaultConfig.stub.js

// Importo default colors
const { yellow } = require('./node_modules/tailwindcss/colors')
const colors = require('./node_modules/tailwindcss/colors')

module.exports = {


	purge: [
		'./**/*.html',
		'./**/*.php',
		'./**/*.js',
	],



	darkMode: false, // or 'media' or 'class'




	theme: {

		// ******** IMPORTANTE ************
		// A parte gli screens che mettiamo in cima,
		// tutto il resto va in ordine alfabetico
		// Height è in ordine alfabetico  ma raggruppa anche minHeight - maxHeight
		// Width stesso discorso di Height


		screens: {
			'xs': '230px', // => @media (max-width: 360px) { ... } /* Parte da 230 e arriva a 374 => per smartphone supervecchi 320 o nuovi economici 360 */
			'sm': '375px', // => @media (max-width: 640px) { ... } /* Parte da 375 e arriva a 639 => Parte da 375 e arriva a 639 => per smartphone nuovi o fighi phablet etc... */
			'md': '640px', // => @media (max-width: 768px) { ... }
			'lg': '960px', // => @media (max-width: 1024px) { ... }
			'xl': '1280px', // => @media (max-width: 1600px) { ... }
			'xxl': '1600px', // Primo - Progetto grafico Serena era 1760px
		},

		borderRadius: {
			none: '0px',
			sm: '0.25rem',
			DEFAULT: '0.5rem',
			md: '.75rem',
			lg: '1.5rem',
			xl: '3rem',
			'2xl': '6rem',
			'3xl': '9rem',
			full: '9999px',
		},

		borderWidth: {
			DEFAULT: '1px',
			'0': '0',
			'2': '2px',
			'3': '3px',
			'4': '4px',
			'8': '8px',
		},

		colors: {

			transparent: 'transparent',
			current: 'currentColor',

			black: colors.black,
			white: colors.white,
			gray: colors.trueGray,

			cyan: 'var(--color-cyan)',
			magenta: 'var(--color-magenta)',
			yellow: 'var(--color-yellow)',

			success: {
				'50': 'var(--color-success-50)',
				'300': 'var(--color-success-300)',
				DEFAULT: 'var(--color-success)',
			},
			warning: {
				'50': 'var(--color-warning-50)',
				'300': 'var(--color-warning-300)',
				DEFAULT: 'var(--color-warning)',
			},
			alert: {
				'50': 'var(--color-alert-50)',
				'300': 'var(--color-alert-300)',
				DEFAULT: 'var(--color-alert)',
			},

			primary: {
				'50': 'var(--color-primary-50)',
				'100': 'var(--color-primary-100)',
				'300': 'var(--color-primary-300)',
				DEFAULT: 'var(--color-primary)',
				'700': 'var(--color-primary-700)',
			},
			secondary: {
				'300': 'var(--color-secondary-300)',
				DEFAULT: 'var(--color-secondary)',
				'700': 'var(--color-secondary-700)',
			},
			accent: {
				'300': 'var(--color-accent-300)',
				DEFAULT: 'var(--color-accent)',
				'700': 'var(--color-accent-700)',
			},

			body: {
				DEFAULT: 'var(--body-color)',
			},

			headings: {
				DEFAULT: 'var(--headings-color)',
			},

		},

		container: {
			center: true,
		},

		/* Font-size solo extend */
		extend: {
			fontSize: {
				'fs-huge': 'var(--huge-font-size-large)',
			},
		},

		/* Height solo extend */
		extend: {
			height: {
				'50vw': '50vw',
				'66vw': '66vw',
				'100vw': '100vw',
				'50vh': '50vh',
				'75vh': '75vh',
				'100vh': '100vh',
			},
		},

		minHeight: {
			0: '0px',
			full: '100%',
			screen: '100vh',
			auto: 'auto',
			'33vw': '33vw',
			'40vw': '40vw',
			'50vw': '50vw',
			'66vw': '66vw',
			'100vw': '100vw',
			'50vh': '50vh',
			'100vh': '100vh',
		},

		maxHeight: (theme) => ({
			...theme('spacing'),
			full: '100%',
			screen: '100vh',
		}),

		minWidth: {
			0: '0px',
			full: '100%',
			auto: 'auto',
			min: 'min-content',
			max: 'max-content',
		},

		maxWidth: (theme, { breakpoints }) => ({
			none: 'none',
			0: '0rem',
			xs: '20rem',
			sm: '24rem',
			md: '28rem',
			lg: '32rem',
			xl: '36rem',
			'2xl': '42rem',
			'3xl': '48rem',
			'4xl': '56rem',
			'5xl': '64rem',
			'6xl': '72rem',
			'7xl': '80rem',
			full: '100%',
			min: 'min-content',
			max: 'max-content',
			prose: '65ch',

			...breakpoints(theme('screens')),
		}),

		/* Transitions solo extend */
		extend: {
			transitionDuration: {
				'fast': 'var(--duration-fast);',
				'normal': 'var(--duration-normal);',
				'slow': 'var(--duration-slow);',
				'xslow': 'var(--duration-xslow);',
			}
		},

		zIndex: {
			auto: 'auto',
			0: '0',
			1: '1',
			2: '2',
			3: '3',
			4: '4',
			5: '5',
			6: '6',
			7: '7',
			8: '8',
			9: '9',
			10: '10',
			20: '20',
			30: '30',
			40: '40',
			50: '50',
		},

	},



	variants: {
		extend: {
			scale: ['active', 'group-hover'],
			translate: ['active', 'group-hover'],
		},
	},




	plugins: [
		require('@tailwindcss/line-clamp'),
	],
}
