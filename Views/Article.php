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
use Aldu\Core\View\Helper\HTML;

class Article extends Core\View
{
  protected static $configuration = array(
    __CLASS__ => array(
      'table' => array(
        'columns' => array(
          'title', 'created', 'updated'
        )
      ),
      'form' => array(
        'fields' => array(
          'title',
          'summary' => array(
            'type' => 'textarea', 'attributes' => array(
              'data-editor' => 'ckeditor'
            )
          ),
          'content' => array(
            'type' => 'textarea', 'attributes' => array(
              'data-editor' => 'ckeditor'
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
            'fieldset' => array(
              'attributes' => array(
                'class' => 'collapsed'
              )
            ),
            'type' => 'checkbox',
            'relation' => array(
              'acl' => array(
                'type' => 'select',
                'options' => array(
                  'options' => array(
                    'read' => 'read', 'edit' => 'edit', 'delete' => 'delete'
                  ),
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

  public function listview($articles = array())
  {
    $ul = new HTML('ul.aldu-core-view-listview');
    $ul->data('role', 'listview');
    foreach ($articles as $article) {
      $li = $ul->li();
      $a = $li->a(array(
        'href' => $article->url()
      ));
      $a->h3($article->title);
      $a->append($article->summary);
      $a->append('p.ui-li-aside', $article->created->format(ALDU_DATETIME_FORMAT));
    }
    return $ul;
  }

  public function read($model, $options = array())
  {
    $options = array_merge(array(
      'render' => $this->render
    ), $options);
    extract($options);
    parent::read($model, $options);
    switch ($render) {
    case 'pdf':
      $pdf = Utility\Shell::exec('pandoc -t pdf', $model->content);
      $this->response->type('pdf');
      return $this->response->body($pdf);
    case 'page':
    default:
      $page = new Helper\HTML\Page();
      $page->theme();
      $page->title($model->title);
      $article = new Helper\HTML('article.aldu-blog-views-article');
      $article->append('section.aldu-blog-views-article-summary')->append($model->summary);
      $article->append('section.aldu-blog-views-article-content')->append($model->content);
      $page->compose($article);
      return $this->response->body($page);
    }
  }
}
