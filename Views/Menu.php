<?php
/**
 * Aldu\Blog\Views\Menu
 *
 * AlduPHP(tm) : The Aldu Network PHP Framework (http://aldu.net/php)
 * Copyright 2010-2012, Aldu Network (http://aldu.net)
 *
 * Licensed under Creative Commons Attribution-ShareAlike 3.0 Unported license (CC BY-SA 3.0)
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Giovanni Lovato <heruan@aldu.net>
 * @copyright     Copyright 2010-2012, Aldu Network (http://aldu.net)
 * @link          http://aldu.net/php AlduPHP(tm) Project
 * @package       Aldu\Blog\Views
 * @uses          Aldu\Core
 * @uses          Aldu\Core\View\Helper
 * @since         AlduPHP(tm) v1.0.0
 * @license       Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 */

namespace Aldu\Blog\Views;
use Aldu\Blog;
use Aldu\Core;
use Aldu\Core\View\Helper;

class Menu extends Core\View
{
  public static $configuration = array(
    'table' => array(
      'columns' => array(
        'name' => 'Menu',
        'title' => 'Title',
        'uri' => 'Link'
      )
    ),
    'form' => array(
      'fields' => array(
        'uri',
        'title',
        'name',
        'locale'
      )
    )
  );

  public static function block($block, $element = null)
  {
    $Menu = new Blog\Controllers\Menu();
    return $Menu->view->build($block->name);
  }

  public function build($name, $parent = null)
  {
    $this->router->openContext($name);
    $Cache = Core\Cache::instance();
    $cache = implode('::', array(
      get_class($this->model),
      __METHOD__,
      $this->router->basePath,
      md5(serialize(func_get_args())),
      md5(serialize($this->request->aro))
    ));
    if (ALDU_CACHE_FAILURE === ($ul = $Cache->fetch($cache))) {
      $ul = new Helper\HTML('ul');
      foreach ($this->model->read(array(
        'name' => $name,
        'parent' => $parent
      )) as $menu) {
        if (!$menu->authorized($this->request->aro, 'read')) {
          continue;
        }
        $li = $ul->li();
        foreach (explode(' ', $menu->class) as $class) {
          $li->addClass($class);
        }
        $anchor = $li->a($menu->title);
        if (preg_match('/^(http|javascript)/', $menu->uri)) {
          $anchor->href = $menu->uri;
        }
        else {
          $anchor->href = $this->router->basePrefix . $menu->uri;
        }
        if (($menu->uri === $this->router->path)
          || ($menu->isAncestorOf($this->model->first(array(
            'uri' => $this->router->path
          ))))) {
          $menu->expand = true;
          $li->addClass('active');
        }
        if ($menu->expand) {
          if (($child = $this->build($name, $menu)) && $child->node('li')->count()) {
            $li->append($child);
          }
        }
      }
      $Cache->store($cache, $ul);
    }
    $this->router->closeContext($name);
    return $ul;
  }

  public function sitemap($name)
  {
    $R = Core\Router::instance();
    $dom = new Helper\DOM\Document('xml');
    $xml = $dom->create('urlset', array(
      'xmlns' => "http://www.sitemaps.org/schemas/sitemap/0.9"
    ));
    $this->router->openContext($name);
    foreach ($this->model->read(array(
      'name' => $name
    )) as $menu) {
      if (preg_match('/^http/', $menu->uri))
        continue;
      $url = $xml->append('url');
      $url->loc($this->router->fullBasePrefix . $menu->uri);
    }
    $this->router->closeContext($name);
    $this->response->type('text/xml');
    $this->response->body($xml);
  }
}
