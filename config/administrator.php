<?php

return array(

    /*
     * 后台入口
     *
     * Package URI
     *
     * @type string
     */
    'uri' => 'admin',

    /*
     *  后台专属域名
     *
     *  Domain for routing.
     *
     *  @type string
     */
    'domain' => '',

    /*
     * 应用名称
     *
     * Page title
     *
     * @type string
     */
    'title' => env('APP_NAME', 'Laravel'),

    /*
     * The path to your model config directory
     *
     * @type string
     */
    'model_config_path' => config_path('administrator'),

    /*
     * The path to your settings config directory
     *
     * @type string
     */
    'settings_config_path' => config_path('administrator/settings'),

    /*
     * 后台菜单数组，多维数组渲染结果为多级嵌套菜单
     *
     * The menu structure of the site. For models, you should either supply the name of a model config file or an array of names of model config
     * files. The same applies to settings config files, except you must prepend 'settings.' to the settings config file name. You can also add
     * custom pages by prepending a view path with 'page.'. By providing an array of names, you can group certain models or settings pages
     * together. Each name needs to either have a config file in your model config path, settings config path with the same name, or a path to a
     * fully-qualified Laravel view. So 'users' would require a 'users.php' file in your model config path, 'settings.site' would require a
     * 'site.php' file in your settings config path, and 'page.foo.test' would require a 'test.php' or 'test.blade.php' file in a 'foo' directory
     * inside your view directory.
     *
     * @type array
     *
     * 	array(
     *		'E-Commerce' => array('collections', 'products', 'product_images', 'orders'),
     *		'homepage_sliders',
     *		'users',
     *		'roles',
     *		'colors',
     *		'Settings' => array('settings.site', 'settings.ecommerce', 'settings.social'),
     * 		'Analytics' => array('E-Commerce' => 'page.ecommerce.analytics'),
     *	)
     */
    'menu' => [
        '用户与权限' => [
            'users',
        ],
    ],

    /*
     * 权限控制的回调函数
     *
     * The permission option is the highest-level authentication check that lets you define a closure that should return true if the current user
     * is allowed to view the admin section. Any "falsey" response will send the user back to the 'login_path' defined below.
     *
     * @type closure
     */
    'permission' => function () {
        return Auth::check() && Auth::user()->can('manage_contents');
    },

    /*
     * 是否使用后台主页面
     *
     * This determines if you will have a dashboard (whose view you provide in the dashboard_view option) or a non-dashboard home
     * page (whose menu item you provide in the home_page option)
     *
     * @type bool
     */
    'use_dashboard' => true,

    /*
     * 后台主页视图文件，由 `use_dashboard` 选项决定
     *
     * If you want to create a dashboard view, provide the view string here.
     *
     * @type string
     */
    'dashboard_view' => '',

    /*
     * 后台主页菜单条目，由 `use_dashboard` 选项决定，菜单指的是 `menu` 选项
     *
     * The menu item that should be used as the default landing page of the administrative section
     *
     * @type string
     */
    'home_page' => 'users',

    /*
     * 返回主页按钮链接
     *
     * The route to which the user will be taken when they click the "back to site" button
     *
     * @type string
     */
    'back_to_site_path' => '/',

    /*
     * 权限检测不通过时，重定向到此处
     *
     * The login path is the path where Administrator will send the user if they fail a permission check
     *
     * @type string
     */
    'login_path' => 'login',

    /*
     * The logout path is the path where Administrator will send the user when they click the logout link
     *
     * @type string
     */
    'logout_path' => false,

    /*
     * 允许在登录成功后使用 Session::get('redirect') 将用户重定向到原本想要访问的后台页面
     *
     * This is the key of the return path that is sent with the redirection to your login_action. Session::get('redirect') will hold the return URL.
     *
     * @type string
     */
    'login_redirect_key' => 'redirect',

    /*
     * 控制模型数据列表页默认的显示条目
     *
     * Global default rows per page
     *
     * @type int
     */
    'global_rows_per_page' => 20,

    /*
     * 可选的语言，如果不为空，将会在页面顶部显示『选择语言』按钮
     *
     * An array of available locale strings. This determines which locales are available in the languages menu at the top right of the Administrator
     * interface.
     *
     * @type array
     */
    'locales' => [],

    'custom_routes_file' => app_path('Http/routes/administrator.php'),
);
