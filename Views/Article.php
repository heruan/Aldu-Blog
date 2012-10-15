<?php
/**
 * Aldu\Blog\Views\Article
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
 * @since         AlduPHP(tm) v1.0.0
 * @license       Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 */

namespace Aldu\Blog\Views;
use Aldu\Core;
use Aldu\Core\View\Helper;

class Article extends Core\View
{
  public function view($article)
  {
    switch ($this->render) {
      case 'page':
      default:
        $page = new Helper\HTML\Page();
        $page->theme();
        $page->title($article->title);
        $page->compose($article->content);
        return $this->response->body($page);
    }
  }
}
