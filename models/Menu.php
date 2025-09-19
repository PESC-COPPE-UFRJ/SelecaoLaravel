<?php

class Menu extends Eloquent
{

	protected $table = 'menus';

	public function submenus()
	{
		return $this->hasMany('Menu', 'parent_id', 'id')
					->where('parent_id', '>', 0)
					->orderBy('ordem', 'ASC');
	}

	public static function MontarMenu($perfil)
	{
		if(Auth::check())
		{
			// $perfis  = Auth::user()->perfis->load(array('menus' => function($query)
			// {
			// 	$query->Where('parent_id', '=', NULL)
			// 		  ->orWhere('parent_id', '=', 0)
			// 		  ->Where('publicado', '=', 1)
			// 		  ->orderBy('ordem', 'ASC');
			// }));

			//$perfis  = Auth::user()->perfis->load('menus');

			$menus = array();
			$submenus = array();

			$perfil = Perfil::find($perfil);

			// foreach($perfis as $perfil)
			// {
				foreach($perfil->menus as $menu)
				{
					if(is_numeric($menu->parent_id) && $menu->parent_id > 0 && array_key_exists($menu->parent_id, $menus))
					{
						// $menus[$menu->parent_id][$menu->id] = $menu;
						if($menu->publicado == 1)
						{
							$submenus[$menu->id] = $menu->toArray();
						}
					}
					else
					{
						if($menu->publicado == 1)
						{
							$menus[$menu->id] = $menu->toArray();
						}
					}
				}

			//}

						//debug($submenus);

			foreach($submenus as $submenu)
			{
				if(array_key_exists($submenu['parent_id'], $menus))
				{
					if(!isset($menus[$submenu['parent_id']]['subs']))
					{
						$menus[$submenu['parent_id']]['subs'] = array();
					}

					$menus[$submenu['parent_id']]['subs'][$submenu['id']] = $submenu;
				}
			}

			unset($submenus);

		}

		//debug($menus);

		if(!empty($menus))
		{
			return $menus;
		}
		else
		{
			return false;
		}

	}

}