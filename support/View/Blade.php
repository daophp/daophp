<?php

namespace Swift\View;

use Jenssegers\Blade\Blade as BladeView;
use Swift\Contracts\View;

/**
 * Class Blade
 * @package Swift\View
 */
class Blade implements View
{
    /**
     * @param $template
     * @param $vars
     * @param string $app
     * @return mixed
     */
    public static function render($template, $vars, $app = null)
    {
        static $blade;

        $app_name = $app == null ? request()->app : $app;
        if ($app_name === '') {
            $viewPaths = config('view.paths');
        } else {
            $viewPaths = app_path($app_name . '/Views');
        }

        $cachePath = runtime_path('views' . ($app_name ? DIRECTORY_SEPARATOR . $app_name : ''));
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        $blade[$app_name] = isset($blade[$app_name]) ? $blade[$app_name] : new BladeView($viewPaths, $cachePath);

        return $blade[$app_name]->render($template, $vars);
    }
}
