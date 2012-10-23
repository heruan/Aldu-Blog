<?php
/**
 * Aldu\Blog\Models\Article
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

class Article extends Core\Locale\Localized
{
  protected static $configuration = array(__CLASS__ => array(
    'datasource' => array(
      'options' => array('sort' => array('updated' => 1)),
    ),
    'extensions' => array(
      'localized' => array(
        'attributes' => array(
          'title' => true,
          'summary' => true,
          'content' => true
        )
      )
    )
  ));

  protected static $relations = array(
    'belongs' => array(
      'Aldu\Auth\Models\User' => array(
        'author' => array(
          'type' => 'boolean'
        )
      )
    )
  );

  protected static $attributes = array(
    'summary' => array(
      'type' => 'textarea'
    ),
    'content' => array(
      'type' => 'textarea'
    )
  );
  public $title;
  public $summary;
  public $content;
}
