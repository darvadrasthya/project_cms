<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PageModel');
		$this->load->model('MenuModel');
		$this->load->model('SettingModel');
	}

	public function index()
	{
		// Get header menu
		$header_menu = $this->MenuModel->get_menu_tree_by_position('header');
		
		// Get footer menu
		$footer_menu = $this->MenuModel->get_menu_tree_by_position('footer');
		
		// Get site settings
		$site_name = $this->SettingModel->get_value('site_name', 'My Website');
		$site_logo = $this->SettingModel->get_value('site_logo', '');
		$site_description = $this->SettingModel->get_value('site_description', '');
		
		// Get hero settings
		$hero_title = $this->SettingModel->get_value('hero_title', '');
		$hero_subtitle = $this->SettingModel->get_value('hero_subtitle', '');
		$hero_button_text = $this->SettingModel->get_value('hero_button_text', 'Get Started');
		$hero_button_url = $this->SettingModel->get_value('hero_button_url', '');
		
		// Get contact settings
		$contact_email = $this->SettingModel->get_value('contact_email', '');
		$contact_phone = $this->SettingModel->get_value('contact_phone', '');
		$contact_address = $this->SettingModel->get_value('contact_address', '');
		
		// Get published pages
		$pages = $this->PageModel->get_published_pages(9);
		
		// Get featured pages (you can add a 'featured' column to pages table)
		$featured_pages = $this->PageModel->get_published_pages(3);

		$data = [
			'title' => 'Home',
			'meta_title' => $site_name,
			'meta_description' => $site_description,
			'header_menu' => $header_menu,
			'footer_menu' => $footer_menu,
			'site_name' => $site_name,
			'site_logo' => $site_logo,
			'site_description' => $site_description,
			'hero_title' => $hero_title,
			'hero_subtitle' => $hero_subtitle,
			'hero_button_text' => $hero_button_text,
			'hero_button_url' => $hero_button_url,
			'contact_email' => $contact_email,
			'contact_phone' => $contact_phone,
			'contact_address' => $contact_address,
			'pages' => $pages,
			'featured_pages' => $featured_pages
		];
		
		$this->load->view('public/home', $data);
	}

	public function about()
	{
		$data['title'] = 'About Us';
		$this->load->view('about', $data);
	}

	/**
	 * Display public page by slug
	 */
	public function page($slug)
	{
		// Get page by slug
		$page = $this->PageModel->get_by_slug($slug);

		// Check if page exists and is published
		if (!$page || $page['status'] !== 'published') {
			show_404();
			return;
		}

		// Get header menu
		$header_menu = $this->MenuModel->get_menu_tree_by_position('header');
		
		// Get footer menu
		$footer_menu = $this->MenuModel->get_menu_tree_by_position('footer');
		
		// Get site settings
		$site_name = $this->SettingModel->get_value('site_name', 'My Website');
		$site_logo = $this->SettingModel->get_value('site_logo', '');

		$data = [
			'title' => $page['title'],
			'page' => $page,
			'meta_title' => $page['meta_title'] ?? $page['title'],
			'meta_description' => $page['meta_description'] ?? '',
			'header_menu' => $header_menu,
			'footer_menu' => $footer_menu,
			'site_name' => $site_name,
			'site_logo' => $site_logo
		];

		$this->load->view('pages/public_view', $data);
	}
}
