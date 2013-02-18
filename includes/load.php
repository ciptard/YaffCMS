<?php

/**
 * The YaffCMS class.
 *
 * @version 0.1
 */
class Yaff {

	/**
	 * Constructor.
	 *
	 * Gathers URL and retrieves .md file accordingly. Parses through to the
	 * Markdown class and includes the relevant page template.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		global $y;
		if (isset($y['base_url']) && $y['base_url']) {
			$this->apply_default_settings();

			if ($_SERVER['REQUEST_URI'] != $_SERVER['PHP_SELF'])
				$url = trim(preg_replace('/' . str_replace('/', '\/', str_replace('index.php', '', $_SERVER['PHP_SELF'])) . '/', '', $_SERVER['REQUEST_URI'], 1), '/');

			$file = ($url ? strtolower(PAGES_DIR . $url) : PAGES_DIR . 'index');

			is_dir($file) ? $file = PAGES_DIR . $url . '/index.md' : $file .= '.md';

			if (file_exists($file)) {
				$y['page_content'] = file_get_contents($file);
			} else {
				$y['page_content'] = file_get_contents(PAGES_DIR . '404.md');
				header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
			}

			$this->get_page_meta();
			$y['page_content'] = preg_replace('/<!--[\s\S]*?-->/', '', $y['page_content']);
			$this->extract_vars();
			$y['page_content'] = Markdown($y['page_content']);

			include(THEMES_DIR . $y['theme'] . '/' . $y['page_template'] . '.php');
		} else {
			die('\'base_url\' value does not exist. Please add the desired URL of your installation in \'settings.php\'');
		}
	}
	
	/**
	 * Retrieves the meta information from a .md page file and adds the fields
	 * to the global $y array.
	 *
	 * @since 0.1
	 */
	public function get_page_meta() {
		global $y;
		$meta = array(
			'page_title'	=> 'Page Title',
			'page_template'	=> 'Page Template'
		);
		$defaults = array(
			'page_title'	=> $y['site_title'],
			'page_template'	=> 'default'
		);
	 	foreach ($meta as $field => $value) {
			if (preg_match('/^[ \t\/*#@]*' . preg_quote($value, '/') . ':(.*)$/mi', $y['page_content'], $match) && $match[1]) {
				$y[$field] = trim(preg_replace('/\s*(?:\*\/|\?>).*/', '', $match[1]));
			} else {
				$y[$field] = $defaults[$field];
			}
		}
	}

	/**
	 * Extracts variables from a .md page file. If the user types %hello%,
	 * this will look in $y[hello] to find the required value (settings.php).
	 *
	 * @since 0.1
	 */
	public function extract_vars() {
		global $y;
		foreach ($y as $field => $value) {
			if ($field != 'page_content')
				$y['page_content'] = str_replace('%' . $field . '%', $value, $y['page_content']);
		}
	}

	/**
	 * Ensures that the 3 required options (site_title, base_url and theme) are
	 * never left blank by adding default values if this is the case.
	 *
	 * @since 0.1
	 */
	public function apply_default_settings() {
		global $y;
		$defaults = array(
			'site_title'	=> 'YaffCMS',
			'theme'			=> 'default',
		);
		foreach ($defaults as $field => $value) {
			if (!array_key_exists($field, $y)) {
				$y[$field] = $value;
			}
		}
		$y['theme_url'] = $y['base_url'] . 'themes/' . $y['theme'];
	}
	
}

?>