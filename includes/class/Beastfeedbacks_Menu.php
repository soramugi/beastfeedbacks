<?php

class BeastFeedbacks_Menu
{
	public static function init()
	{
		static $instance = false;

		if (!$instance) {
			$instance = new BeastFeedbacks_Menu();
		}

		return $instance;
	}

	protected function __construct()
	{
		add_action('admin_menu', array($this, 'admin_menu'));
	}

	public function admin_menu()
	{
		$slug = 'beastfeedbacks';

		add_menu_page(
			"Beastfeedbacks",
			"Beastfeedbacks",
			'edit_pages',
			$slug,
			array($this, 'render'),
			'dashicons-feedback'
		);
	}

	public function render()
	{
		include BEASTFEEDBACKS_PLUGIN_PATH . 'includes/view/menu.php';
	}
}
