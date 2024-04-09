import { loginUser, visitAdminPage } from '@wordpress/e2e-test-utils';

describe( 'plugin active', () => {
	it( 'verifies the plugin is active', async () => {
		await loginUser();
		await visitAdminPage( 'plugins.php' );

		const pluginSlug = 'beastfeedbacks';
		const activePlugin = await page.$x(
			'//tr[contains(@class, "active") and contains(@data-slug, "' +
				pluginSlug +
				'")]'
		);

		expect( activePlugin?.length ).toBe( 1 );
	} );
} );
