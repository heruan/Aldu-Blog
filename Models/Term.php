<?php
/**
 * Aldu\Blog\Models\Term
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
 * @package       Aldu\Blog\Models
 * @uses          Aldu\Core
 * @since         AlduPHP(tm) v1.0.0
 * @license       Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 */

namespace Aldu\Blog\Models;
use Aldu\Core;

class Term extends Core\Locale\Localized
{
  protected static $configuration = array(__CLASS__ => array(
    'label' => 'title',
    'extensions' => array(
      'localized' => array(
        'attributes' => array(
          'title' => true, 'description' => true
        )
      )
    )
  ));

  protected static $attributes = array('parent' => array('type' => __CLASS__), 'description' => 'textarea');
  public $name;
  public $parent;
  public $title;
  public $description;
}
