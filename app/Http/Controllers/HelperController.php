<?php

namespace App\Http\Controllers;

use App\Classes\DynamicModel;
use App\Modules\Admin\Classes\Base;
use Illuminate\Http\Request;

class HelperController extends Controller
{
  /**
   * @var Base
   */
  protected $base;

  /**
   * @var DynamicModel
   */
  private $dynamic;

  /**
   * @var array
   */
  private $request;

  /**
   * @var Request
   */
  private $requests;

  public function __construct(Request $request)
  {
    $this->base     = new Base($request);
    $this->dynamic  = new DynamicModel();
    $this->request  = $request->all();
    $this->requests = $request;
  }

  /**
   * Get Array or single Blog.
   *
   * @param null  $id
   * @param array $options
   * @param array $where
   * @return DynamicModel|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Model
   */
  public function _blog($id = null, $options = [], $where = [['blog.active', 1]])
  {
    if($id) {
      if(!is_numeric($id))
        $where_id = ['blog.translation' => $id];
      else
        $where_id = ['blog.id' => $id];

      $result = $this->dynamic->t('blog')
        ->where(array_merge($where, $where_id))
        ->join(
          'files',

          function($join) {
            $join->type = 'LEFT OUTER';
            $join->on('blog.id', '=', 'files.id_album')
              ->where('files.name_table', '=', 'blogalbum')
              ->where('files.main', '=', 1);
          }
        )
        ->join(
          'users',

          function($join) {
            $join->type = 'LEFT OUTER';
            $join->on('users.id', '=', 'blog.author_id');
          }
        )
        ->join(
          'files AS files_users',

          function($join) {
            $join->type = 'LEFT OUTER';
            $join->on('blog.author_id', '=', 'files_users.id_album')
              ->where('files_users.name_table', '=', 'usersalbum')
              ->where('files_users.main', '=', 1);
          }
        )
        ->select(
          'blog.*',
          'files.file',
          'files.crop',
          'files_users.file AS users_file',
          'files_users.crop AS users_crop',
          'users.name AS author_name'
        )
        ->first();
    } else {
      $query = $this->dynamic->t('blog')
        ->where($where)
        // TODO скорее отвалится когда теги будут с id больше 10
        ->where(
          function($query) use ($options) {
            for($i = 0; $i < count($options['tags'] ?? []); $i++) {
              $query->orwhere('blog.tags', 'like', '%' . ($options['tags'] ?? [])[$i] . '%');
            }
          }
        );

      if(isset($options['not_in']))
        $query = $query
          ->whereNotIn("blog.{$options['not_in'][0]}", $options['not_in'][1]);

      $query = $query
        ->join(
          'files',

          function($join) {
            $join->type = 'LEFT OUTER';
            $join->on('blog.id', '=', 'files.id_album')
              ->where('files.name_table', '=', 'blogalbum')
              ->where('files.main', '=', 1);
          }
        )
        ->join(
          'users',

          function($join) {
            $join->type = 'LEFT OUTER';
            $join->on('users.id', '=', 'blog.author_id');
          }
        )
        ->select('blog.*', 'files.file', 'files.crop', 'users.name AS author_name');

      foreach($options['order_by'] ?? [] as $order_by) {
        $query = $query->orderBy($order_by[0], $order_by[1]);
      }

      if(!isset($options['order_by']))
        $query = $query->orderBy('blog.' . ($options['group'] ?? 'id'), 'DESC');

      $result = $query
        ->groupBy('blog.id')
        ->paginate($options['count_box'] ?? 1);
    }

    return $result;
  }

  /**
   * Services.
   *
   * @return array
   */
  public function _services()
  {
    return $this
      ->dynamic
      ->t('services')
      ->where('services.active', 1)
      ->join(
        'files',

        function($join) {
          $join->type = 'LEFT OUTER';
          $join->on('services.id', '=', 'files.id_album')
            ->where('files.name_table', '=', 'servicesalbum')
            ->where('files.main', '=', 1);
        }
      )
      ->join(
        'files AS collections_files',

        function($join) {
          $join->type = 'LEFT OUTER';
          $join->on('services.id', '=', 'collections_files.id_album')
            ->where('collections_files.name_table', '=', 'servicescollections')
            ->where('collections_files.main', '=', 1);
        }
      )
      ->join(
        'files AS collections_files_2',

        function($join) {
          $join->type = 'LEFT OUTER';
          $join->on('services.id', '=', 'collections_files_2.id_album')
            ->where('collections_files_2.name_table', '=', 'servicescollections')
            ->where('collections_files_2.main', '!=', 1);
        }
      )
      ->select(
        'services.*',
        'files.file',
        'files.crop',
        'collections_files.file AS collections_files',
        'collections_files.crop AS collections_crop',
        'collections_files_2.file AS collections_files_2',
        'collections_files_2.crop AS collections_crop_2'
      )
      ->orderBy('services.sort', 'ASC')
      ->get()
      ->toArray();
  }

  /**
   * Страницы.
   *
   * @param null   $id
   * @param string $view - путь до шаблона
   * @param string $name_table - имя таблицы
   * @param array  $data - массив которй надо передать в шаблон
   * @param bool  $return_data - вернуть объект даты вместо вывода в шаблон
   * @return DynamicModel|\Illuminate\Contracts\View\Factory|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|\Illuminate\View\View|null
   */
  public function _page($id = null, $view = 'page_id', $name_table = 'str', $data = [], $return_data = false)
  {
    if(!$id)
      return $this->_errors_404();

    $Mod     = $this->dynamic;
    $where[] = ["$name_table.active", 1];

    if((int) $id == 0 || strlen($id) > 5) {
      $data['field'] = 'translation';
      $where[]       = ["$name_table.translation", $id];
    } else {
      $where["$name_table.id"] = $id;
    }

    $data['page'] = $Mod->t("$name_table")
      ->where($where)
      ->join(
        'files',

        function($join) use ($name_table) {
          $join->type = 'LEFT OUTER';
          $join->on("$name_table.id", '=', 'files.id_album')
            ->where('files.name_table', '=', "{$name_table}album");
        }
      )
      ->select("$name_table.*", 'files.file', 'files.crop')
      ->first();

    if(empty($data['page'])) {
      return $this->_errors_404();
    }

    $data['meta_c'] = $this->base->getMeta($data, 'page');

    if(!empty($data['page'][0])) {
      $data['files'] = $Mod->t('files')
        ->where(['files.active' => 1])
        ->where(['id_album' => $data['page'][0]['id'], 'name_table' => $name_table])->get();
    } else {
      $data['files'] = [];
    }

    if(!$return_data)
      return $this->base->view_s("{$view}", $data);
    else
      return $data['page'];
  }

  /**
   * errors_404.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function _errors_404()
  {
    return $this->base->view_s("errors.404", []);
  }

  /**
   * Duplicated Data.
   *
   * @return mixed
   */
  public function duplicate_data()
  {
    // Музыка на сайт
    $data['music'] = $this
      ->dynamic
      ->t('files')
      ->where('files.name_table', '=', 'mainmusic')
      ->first();

    // Для футера "Полезное"
    $data['blog_useful'] = $this->_blog(
      null,
      [
        'count_box' => 6,
        'order_by'  => [['blog.useful', 'DESC'], ['blog.id', 'DESC']],
      ],

      [
        ['blog.useful', '=', 1],
        ['blog.active', '=', 1],
      ]
    );

    // Для футера "Услуги"
    $data['services'] = $this->_services();

    return $data;
  }
}

