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
  protected static $configuration = array(
    __CLASS__ => array(
      'table' => array(
        'columns' => array('title', 'created', 'updated')
       ),
      'form' => array(
        'fields' => array(
          'title',
          'summary' => array(
            'type' => 'textarea',
            'attributes' => array(
              'data-editor' => true
            )
          ),
          'content' => array(
            'type' => 'textarea',
            'attributes' => array(
              'data-editor' => true
            )
          ),
          'locale',
          'acl'
        ),
        'has' => array(
          'terms' => array(
            'model' => 'Aldu\Blog\Models\Term',
            'type' => 'select',
            'attributes' => array(
              'multiple' => true
            )
          )
        ),
        'belongs' => array(
          'groups' => array(
            'model' => 'Aldu\Auth\Models\Group',
            'fieldset' => true,
            'type' => 'checkbox',
            'relation' => array(
              'acl' => array(
                'type' => 'select',
                'options' => array(
                  'options' => array('read' => 'read', 'edit' => 'edit', 'delete' => 'delete'),
                  'attributes' => array(
                    'multiple' => true
                  )
                )
              )
            )
          )
        )
      )
    )
  );

  public function read($article)
  {
    parent::read($article);
    switch ($this->render) {
    case 'page':
    default:
      $page = new Helper\HTML\Page();
      $page->theme();
      $page->title($article->title);
      $content = new Helper\HTML('article.aldu-blog-views-article', $article->content);
      $page->compose($content);
      return $this->response->body($page);
    }
  }
}
