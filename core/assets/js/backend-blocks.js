wp.domReady(() => {
	wp.blocks.unregisterBlockStyle('core/image', 'circle-mask');
});

wp.domReady(function () {

	const setExtraPropsToBlockType = (props, blockType, attributes) => {

		const notDefined = (typeof props.className === 'undefined' || !props.className) ? true : false

		// if (blockType.name === 'core-embed/vimeo') {
		// 	return Object.assign(props, {
		// 		className: notDefined ? 'flex-video widescreen' : `flex-video widescreen ${props.className}`,
		// 	});
		// }

		// if (blockType.name === 'core-embed/youtube') {
		// 	return Object.assign(props, {
		// 		className: notDefined ? 'flex-video widescreen' : `flex-video widescreen ${props.className}`,
		// 	});
		// }

		// if (blockType.name === 'core/heading') {
		// 	return Object.assign(props, {
		// 		id: notDefined ? `${props.id}` : `${props.anchor}`,
		// 	});
		// }

		// if (blockType.name === 'core/columns') {
		// 	return Object.assign(props, {
		// 		className: notDefined ? 'grid gap-4' : `${props.className} grid gap-4`,
		// 	});
		// }

		if (blockType.name === 'core/list') {
			return Object.assign(props, {
				className: notDefined ? 'wp-block-list' : `${props.className} wp-block-list`,
			});
		}


		return props;

	};

	wp.hooks.addFilter(
		'blocks.getSaveContent.extraProps',
		'canva/block-filters',
		setExtraPropsToBlockType
	);


	/**
	 *
	 * Icone
	 *
	 */

	const el = wp.element.createElement;
	const colIcon100 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M42,36c0,1.1-0.9,2-2,2H8 c-1.1,0-2-0.9-2-2V12c0-1.1,0.9-2,2-2h32c1.1,0,2,0.9,2,2V36z"
		})
	);
	const colIcon5050 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M8,38c-1.1,0-2-0.9-2-2V12 c0-1.1,0.9-2,2-2h15.5v28H8z M42,36c0,1.1-0.9,2-2,2H24.5V10H40c1.1,0,2,0.9,2,2V36z"
		})
	);
	const colIcon3070 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M6,36V12c0-1.1,0.9-2,2-2h9.5v28H8 C6.9,38,6,37.1,6,36z M42,36c0,1.1-0.9,2-2,2H18.5V10H40c1.1,0,2,0.9,2,2V36z"
		})
	);
	const colIcon7030 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M6,36V12c0-1.1,0.9-2,2-2h21.5v28 H8C6.9,38,6,37.1,6,36z M42,36c0,1.1-0.9,2-2,2h-9.5V10H40c1.1,0,2,0.9,2,2V36z"
		})
	);
	const colIcon333333 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M29.5,10v28h-11V10H29.5z M6,36V12 c0-1.1,0.9-2,2-2h9.5v28H8C6.9,38,6,37.1,6,36z M42,36c0,1.1-0.9,2-2,2h-9.5V10H40c1.1,0,2,0.9,2,2V36z"
		})
	);

	const colIcon25252525 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M24.5,10h8v28h-8V10z M23.5,38h-8 V10h8V38z M6,36V12c0-1.1,0.9-2,2-2h6.5v28H8C6.9,38,6,37.1,6,36z M42,36c0,1.1-0.9,2-2,2h-6.5V10H40c1.1,0,2,0.9,2,2V36z"
		})
	);

	const colIcon7525 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M6,36V12c0-1.1,0.9-2,2-2h24.5v28 H8C6.9,38,6,37.1,6,36z M42,36c0,1.1-0.9,2-2,2h-6.5V10H40c1.1,0,2,0.9,2,2V36z"
		})
	);

	const colIcon2575 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M14.5,38H8c-1.1,0-2-0.9-2-2V12 c0-1.1,0.9-2,2-2h6.5V38z M42,36c0,1.1-0.9,2-2,2H15.5V10H40c1.1,0,2,0.9,2,2V36z"
		})
	);

	const colIcon2020202020 = el('svg', {
		width: 48,
		height: 48,
		viewBox: '0 0 48 48'
	},
		el('path', {
			fillRule: "evenodd",
			clipRule = "evenodd",
			d: "M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M20.4,10h6.7v28h-6.7V10z M19.4,38 h-5.7V10h5.7V38z M28.1,10h6.2v28h-6.2V10z M6,36V12c0-1.1,0.9-2,2-2h4.7v28H8C6.9,38,6,37.1,6,36z M42,36c0,1.1-0.9,2-2,2h-4.7V10 H40c1.1,0,2,0.9,2,2V36z"
		})
	);

	/**
	 *
	 * Colonne e Inner Content
	 *
	 */

	wp.blocks.unregisterBlockVariation('core/columns', 'one-column-full');
	wp.blocks.unregisterBlockVariation('core/columns', 'two-columns-equal');
	wp.blocks.unregisterBlockVariation('core/columns', 'three-columns-equal');
	wp.blocks.unregisterBlockVariation('core/columns', 'two-columns-one-third-two-thirds');
	wp.blocks.unregisterBlockVariation('core/columns', 'two-columns-two-thirds-one-third');
	wp.blocks.unregisterBlockVariation('core/columns', 'three-columns-wider-center');

	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-100',
		title: '100',
		icon: colIcon100,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12' }],
		],
	},
	);
	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-50-50',
		title: '50 / 50',
		icon: colIcon5050,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12 md:col-span-6' }],
			['core/column', { className: 'col-span-12 md:col-span-6' }],
		],
	},
	);
	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-33-33-33',
		title: '33 / 33 / 33',
		icon: colIcon333333,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12 md:col-span-4' }],
			['core/column', { className: 'col-span-12 md:col-span-4' }],
			['core/column', { className: 'col-span-12 md:col-span-4' }],
		],
	},
	);
	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-25-25-25-25',
		title: '25 / 25 / 25 / 25',
		icon: colIcon25252525,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12 md:col-span-3' }],
			['core/column', { className: 'col-span-12 md:col-span-3' }],
			['core/column', { className: 'col-span-12 md:col-span-3' }],
			['core/column', { className: 'col-span-12 md:col-span-3' }],
		],
	},
	);
	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-30-70',
		title: '30 / 70',
		icon: colIcon3070,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12 md:col-span-4' }],
			['core/column', { className: 'col-span-12 md:col-span-8' }],
		],
	},
	);
	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-70-30',
		title: '70 / 30',
		icon: colIcon7030,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12 md:col-span-8' }],
			['core/column', { className: 'col-span-12 md:col-span-4' }],
		],
	},
	);
	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-75-25',
		title: '75 / 25',
		icon: colIcon7525,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12 md:col-span-9' }],
			['core/column', { className: 'col-span-12 md:col-span-3' }],
		],
	},
	);
	wp.blocks.registerBlockVariation(
		'core/columns', {
		name: 'canva-col-25-75',
		title: '25 / 75',
		icon: colIcon2575,
		// isDefault: true,
		scope: ['block'],
		innerBlocks: [
			['core/column', { className: 'col-span-12 md:col-span-3' }],
			['core/column', { className: 'col-span-12 md:col-span-9' }],
		],
	},
	);

});
