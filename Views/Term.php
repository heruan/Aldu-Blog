<?php
/**
 * Aldu\Blog\Views\Term
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

class Term extends Core\View
{
  protected static $configuration = array(
    __CLASS__ => array(
      'form' => array(
        'fields' => array(
          'parent',
          'title',
          'description',
          'locale',
          'name'
        )
      )
    )
  );
}
