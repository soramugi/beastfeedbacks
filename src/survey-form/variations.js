import { __ } from '@wordpress/i18n';

/** @typedef {import('@wordpress/blocks').WPBlockVariation} WPBlockVariation */

/**
 * Template option choices for predefined columns layouts.
 *
 * @type {WPBlockVariation[]}
 */
const variations = [
	{
		name: 'product',
		title: __( 'Product survey', 'beastfeedbacks' ),
		innerBlocks: [
			[
				'core/heading',
				{
					level: 3,
					content: __(
						'Please take part in our product survey.',
						'beastfeedbacks'
					),
				},
			],
			[
				'beastfeedbacks/survey-choice',
				{
					label: __( 'Gender', 'beastfeedbacks' ),
					tagType: 'radio',
					required: true,
					items: [
						__( 'Man', 'beastfeedbacks' ),
						__( 'Woman', 'beastfeedbacks' ),
						__( 'Others', 'beastfeedbacks' ),
					],
				},
			],
			[
				'beastfeedbacks/survey-choice',
				{
					label: __( 'Age', 'beastfeedbacks' ),
					tagType: 'select',
					required: true,
					items: [
						__( 'Under 15 years old', 'beastfeedbacks' ),
						__( '16~20 years old', 'beastfeedbacks' ),
						__( '21~25 years old', 'beastfeedbacks' ),
						__( '26~30 years old', 'beastfeedbacks' ),
						__( '31~39 years old', 'beastfeedbacks' ),
						__( '40~49 years old', 'beastfeedbacks' ),
						__( '50~59 years old', 'beastfeedbacks' ),
						__( 'Over 60 years old', 'beastfeedbacks' ),
					],
				},
			],
			[
				'beastfeedbacks/survey-choice',
				{
					label: __(
						'Please select your occupation',
						'beastfeedbacks'
					),
					tagType: 'select',
					required: true,
					items: [
						__( 'Managers/Officers', 'beastfeedbacks' ),
						__(
							'Company employee (Comprehensive work)',
							'beastfeedbacks'
						),
						__(
							'Company employee (General staff)',
							'beastfeedbacks'
						),
						__(
							'Contract employees/temporary employees',
							'beastfeedbacks'
						),
						__( 'Part-time job', 'beastfeedbacks' ),
						__(
							'Civil servants (excluding teachers)',
							'beastfeedbacks'
						),
						__( 'Faculty', 'beastfeedbacks' ),
						__( 'Medical personnel', 'beastfeedbacks' ),
						__( 'Self-employed/freelance', 'beastfeedbacks' ),
						__( 'Housewife/househusband', 'beastfeedbacks' ),
						__( 'University/graduate students', 'beastfeedbacks' ),
						__(
							'Vocational school/junior college student',
							'beastfeedbacks'
						),
						__( 'High school student', 'beastfeedbacks' ),
						__(
							'Professional profession (certified accountant, lawyer, tax accountant, judicial scrivener)',
							'beastfeedbacks'
						),
						__( 'Unemployed', 'beastfeedbacks' ),
						__( 'Retirement', 'beastfeedbacks' ),
						__( 'Others', 'beastfeedbacks' ),
					],
				},
			],
			[
				'beastfeedbacks/survey-input',
				{
					label: __(
						'What type of personality do you have?',
						'beastfeedbacks'
					),
					tagType: 'text',
					placeholder: __(
						'Examples: angry, short-term or calm, shy',
						'beastfeedbacks'
					),
				},
			],
			[
				'beastfeedbacks/survey-choice',
				{
					label: __(
						'Where did you hear about the product?',
						'beastfeedbacks'
					),
					tagType: 'checkbox',
					items: [
						__( 'Internet advertising', 'beastfeedbacks' ),
						__( 'Home page', 'beastfeedbacks' ),
						__( 'SNS', 'beastfeedbacks' ),
						__( 'Email magazine', 'beastfeedbacks' ),
						__( 'Acquaintance', 'beastfeedbacks' ),
						__( 'Over the counter', 'beastfeedbacks' ),
						__( 'TV and radio advertising', 'beastfeedbacks' ),
						__( 'Others', 'beastfeedbacks' ),
					],
				},
			],
			[
				'beastfeedbacks/survey-input',
				{
					label: __(
						'What makes you decide to buy a product?',
						'beastfeedbacks'
					),
					tagType: 'textarea',
					required: true,
				},
			],
			[
				'beastfeedbacks/survey-input',
				{
					label: __(
						'Is there anything that could be improved about the product?',
						'beastfeedbacks'
					),
					tagType: 'textarea',
					required: true,
				},
			],
			[
				'beastfeedbacks/survey-choice',
				{
					label: __( 'Please rate the product', 'beastfeedbacks' ),
					tagType: 'radio',
					required: true,
					items: [
						__( 'Very satisfied', 'beastfeedbacks' ),
						__( 'Satisfaction', 'beastfeedbacks' ),
						__( 'Usually', 'beastfeedbacks' ),
						__( 'Dissatisfaction', 'beastfeedbacks' ),
						__( 'Very dissatisfied', 'beastfeedbacks' ),
					],
				},
			],
			[
				'beastfeedbacks/survey-input',
				{
					label: __(
						'If you have any final thoughts, please write them down.',
						'beastfeedbacks'
					),
					tagType: 'textarea',
					required: true,
				},
			],
			[
				'core/button',
				{
					text: __( 'Submit', 'beastfeedbacks' ),
					tagName: 'button',
					type: 'submit',
				},
			],
		],
	},
];

export default variations;
