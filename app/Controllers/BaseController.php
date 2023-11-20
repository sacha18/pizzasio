<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
     /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $router;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;

    /**
     * Security
     * if $acl is true, a logged user is required
     * $dmz : name of method did not require auth
     *
     * @var bool
     */
    protected $acl = true;

    /**
     * @var string
     */
    protected $acl_dmz;

    /**
     * Page Title
     *
     * $title : title on the paghe
     * $title_prefix : automaticaly prefix added
     */
    protected $title = 'Home';

    protected $title_prefix = 'PIZZASIO';

    /**
     * Menu Management
     */
    protected $menus;

    protected $breadcrumb = [];
    protected $menu       = 'accueil';
    protected $mainmenu;

    /**
     * Messaging
     * messages : list of message to display
     * toastr : use js toaster to display messages
     */
    protected $messages = [];

    protected $toastr = true;

    protected function menus()
    {
        if (! $this->menus) {
            $this->menus = yaml_parse_file(APPPATH . 'Menus/main.yaml');
        }

        return $this->menus;
    }

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->router  = service('router');
        /* @phpstan-ignore-next-line */
        if (! $request->isCLI()) {
            if ($this->acl && ! ($this->router->methodName() === $this->acl_dmz)) {
                /** @var User $user */
                $user = session()->get('user');
                if ($user === null) {
                    $this->redirect('/Login?backto=' . $_SERVER['REQUEST_URI']);

                    exit(); /** @phpstan-ignore-line */
                }
                //$this->session->user = model('UserModel')->find($user->id);
                if (! $user->getActive()) {
                    $this->session = null;
                    $this->redirect('/Login?backto=' . $_SERVER['REQUEST_URI']);

                    exit(); /** @phpstan-ignore-line */
                }
            }

            if (session()->has('messages')) {
                $this->messages = session()->get('messages');
                session()->remove('messages');
            }
        }
        // $this->current_tabmenus = $this->router->methodName();
        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * Redirection
     * redirect to the page, every path component can be passed as au parameters
     * ex: $this->redirect('controller','methoid','param1', 'param2')
     *  => /controller/method/param1/param2
     */
    public function redirect()
    {
        $url = implode('/', func_get_args());
        if (substr($url, 0, 4) !== 'http' && substr($url, 0, 1) !== '/') {
            $url = '/' . $url;
        }
        header("Location: {$url}");
        if (count($this->messages) > 0) {
            session()->set('messages', $this->messages);
        }

        exit; /** @phpstan-ignore-line */
    }

    /**
     * View
     * Efficient view system
     *
     * @param string|null $vue
     * @param array|null  $datas
     */
    public function view($vue = null, $datas = [])
    {
        $connected = isset($this->session->user);

        return view(
            'templates/head',
            [
                'show_menu'  => $connected,
                'mainmenu'   => $this->mainmenu,
                'breadcrumb' => $this->breadcrumb,
                'localmenu'  => $this->menu,
                'user'       => ($this->session->user ?? null),
                'menus'      => $this->menus(),
                'title'      => sprintf(
                    '%s : %s',
                    $this->title,
                    $this->title_prefix
                )]
        )
            . (($vue !== null) ? view($vue, $datas) : '')
            . view('templates/footer', ['messages' => $this->messages]);
    }

    /**
     * Handle Ajax actions and call action method
     */
    public function getAjax()
    {
        if (($action = $this->request->getPostGet('action')) !== null) {
            $func = 'ajaxAction' . $action;

            if (method_exists($this, $func)) {
                return call_user_func([$this, $func]);
            }  log_message('debug', 'Action non reconnue :' . $action);
        }

        return $this->ajax_error('Method not found', 405);
    }

    public function postAjax()
    {
        return $this->getAjax();
    }

    /**
     * Handle Ajax actions and call action method
     *
     * @param mixed      $datas
     * @param mixed|null $statusCode
     */
    protected function json($datas, $statusCode = Response::HTTP_OK)
    {
        $response = response();

        $response->setStatusCode($statusCode);
        $response->setBody(json_encode($datas));
        $response->setHeader('Content-Type', 'application/json');
        $response->noCache();

        // Sends the output to the browser
        // This is typically handled by the framework
        $response->send();

        // if ($http != null) {
        //   http_response_code((int) $http);
        // }

        // header('Content-type: application/json');
        // return $this->output->setResponseFormat('json')->respond($datas);
        // echo json_encode($datas);
        if (($err = json_last_error()) !== null) {
            // echo json_last_error_msg();
            // print_r($datas); print_r
        }

        return null;
    }

    /**
     * return ajax error
     *
     * @param mixed|null $msg
     * @param mixed      $err
     */
    protected function ajax_error($msg = null, $err = 400)
    {
        log_message('error', $msg);
        $this->json(['status' => 'error', 'msg' => $msg], $err);
    }

    public function success($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-success', 'toast' => 'success'];
    }

    public function message($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-info', 'toast' => 'info'];
    }

    public function warning($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-warning', 'toast' => 'warning'];
    }

    public function error($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-danger', 'toast' => 'error'];
    }

    protected function addBreadcrumb($text, $url, $info = '')
    {
        if ($this->breadcrumb === null) {
            $this->breadcrumb = [];
        }
        $this->breadcrumb[] = [
            'text' => $text,
            'url'  => (is_array($url) ? '/' . implode('/', $url) : $url),
            'info' => $info,
        ];
    }
}
