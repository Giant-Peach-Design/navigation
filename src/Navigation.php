<?php

namespace Giantpeach\Schnapps\Navigation;

class Navigation
{
  public static function registerNav($name)
  {
    register_nav_menus([
      $name => __(ucfirst($name)),
    ]);
  }

  public static function getNavMenuItems($name)
  {
    $menus = get_nav_menu_locations();
    return wp_get_nav_menu_items($menus[$name]);
  }

  public static function getNav($name)
  {
    $nav = self::getNavMenuItems($name);
    $nav = self::buildNav($nav);
    return $nav;
  }

  public static function buildNav($nav)
  {
    $nav = self::buildNavTree($nav);
    return $nav;
  }

  public static function buildNavTree($nav, $parent = 0)
  {
    $tree = [];
    foreach ($nav as $item) {
      if ($item->menu_item_parent == $parent) {
        $children = self::buildNavTree($nav, $item->ID);
        if ($children) {
          $item->children = $children;
        }
        $tree[] = $item;
      }
    }
    return $tree;
  }
}
