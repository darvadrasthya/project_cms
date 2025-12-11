<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuModel extends CI_Model
{
	private $table = 'MENUS';
	private $table_items = 'MENU_ITEMS';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get menu by ID
	 */
	public function get_by_id($menu_id)
	{
		$this->db->select('MENUS.*, U1.username as created_by_name, U2.username as updated_by_name');
		$this->db->from($this->table);
		$this->db->join('USERS U1', 'MENUS.created_by = U1.user_id', 'left');
		$this->db->join('USERS U2', 'MENUS.updated_by = U2.user_id', 'left');
		$this->db->where('MENUS.menu_id', $menu_id);
		return $this->db->get()->row_array();
	}

	/**
	 * Get all menus
	 */
	public function get_all()
	{
		$this->db->select('MENUS.*, U1.username as created_by_name, 
                          COUNT(MENU_ITEMS.item_id) as item_count');
		$this->db->from($this->table);
		$this->db->join('USERS U1', 'MENUS.created_by = U1.user_id', 'left');
		$this->db->join('MENU_ITEMS', 'MENUS.menu_id = MENU_ITEMS.menu_id', 'left');
		$this->db->group_by('MENUS.menu_id');
		$this->db->order_by('MENUS.created_at', 'DESC');
		return $this->db->get()->result_array();
	}

	/**
	 * Create new menu
	 */
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update menu
	 */
	public function update($menu_id, $data)
	{
		$this->db->where('menu_id', $menu_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete menu
	 */
	public function delete($menu_id)
	{
		return $this->db->delete($this->table, ['menu_id' => $menu_id]);
	}

	// ==================== MENU ITEMS ====================

	/**
	 * Get menu item by ID
	 */
	public function get_item_by_id($item_id)
	{
		return $this->db->get_where($this->table_items, ['item_id' => $item_id])->row_array();
	}

	/**
	 * Get menu items (alias for get_menu_items)
	 */
	public function get_items($menu_id, $parent_id = null)
	{
		return $this->get_menu_items($menu_id, $parent_id);
	}

	/**
	 * Get menu items
	 */
	public function get_menu_items($menu_id, $parent_id = null)
	{
		$this->db->where('menu_id', $menu_id);

		if ($parent_id === null) {
			$this->db->where('parent_id IS NULL');
		} else {
			$this->db->where('parent_id', $parent_id);
		}

		$this->db->order_by('sort_order', 'ASC');
		return $this->db->get($this->table_items)->result_array();
	}

	/**
	 * Get menu items tree
	 */
	public function get_menu_tree($menu_id)
	{
		$items = $this->db->where('menu_id', $menu_id)
			->order_by('sort_order', 'ASC')
			->get($this->table_items)
			->result_array();

		return $this->build_tree($items);
	}

	/**
	 * Build tree structure
	 */
	private function build_tree($items, $parent_id = null)
	{
		$branch = [];

		foreach ($items as $item) {
			if ($item['parent_id'] == $parent_id) {
				$children = $this->build_tree($items, $item['item_id']);

				if ($children) {
					$item['children'] = $children;
				}

				$branch[] = $item;
			}
		}

		return $branch;
	}

	/**
	 * Create menu item
	 */
	public function create_item($data)
	{
		$this->db->insert($this->table_items, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update menu item
	 */
	public function update_item($item_id, $data)
	{
		$this->db->where('item_id', $item_id);
		return $this->db->update($this->table_items, $data);
	}

	/**
	 * Delete menu item
	 */
	public function delete_item($item_id)
	{
		return $this->db->delete($this->table_items, ['item_id' => $item_id]);
	}

	/**
	 * Update sort order
	 */
	public function update_sort_order($items)
	{
		foreach ($items as $order => $item_id) {
			$this->update_item($item_id, ['sort_order' => $order]);
		}
		return true;
	}

	/**
	 * Get max sort order
	 */
	public function get_max_sort_order($menu_id, $parent_id = null)
	{
		$this->db->select_max('sort_order');
		$this->db->where('menu_id', $menu_id);

		if ($parent_id === null) {
			$this->db->where('parent_id IS NULL');
		} else {
			$this->db->where('parent_id', $parent_id);
		}

		$result = $this->db->get($this->table_items)->row_array();
		return $result['sort_order'] ? $result['sort_order'] : 0;
	}

	/**
	 * Get menu by position (e.g., 'header', 'footer', 'sidebar')
	 */
	public function get_by_position($position)
	{
		// Try 'position' column first, then 'menu_location'
		$menu = $this->db->get_where($this->table, ['menu_location' => $position])->row_array();
		if (!$menu) {
			$menu = $this->db->get_where($this->table, ['menu_location' => $position])->row_array();
		}
		return $menu;
	}

	/**
	 * Get menu tree by position
	 */
	public function get_menu_tree_by_position($position)
	{
		$menu = $this->get_by_position($position);
		if (!$menu) {
			return [];
		}
		return $this->get_menu_tree($menu['menu_id']);
	}

	/**
	 * Get all active menu items for a menu (flat list)
	 */
	public function get_active_items($menu_id)
	{
		return $this->db->where('menu_id', $menu_id)
			->where('is_active', 1)
			->order_by('sort_order', 'ASC')
			->get($this->table_items)
			->result_array();
	}
}
