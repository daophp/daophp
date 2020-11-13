<?php

namespace Swift\Translation;

use Swift\Contracts\Bootstrap;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;
use Workerman\Worker;

/**
 * Class TranslationProvider
 * @package Swift\Translation
 * @method static string trans(?string $id, array $parameters = [], string $domain = null, string $locale = null)
 * @method static void setLocale(string $locale)
 * @method static string getLocale()
 */
class TranslationProvider implements Bootstrap
{
    /**
     * @var array
     */
    protected static $_translator = [];

    /**
     * @param Worker $worker
     * @return void
     */
    public static function start($worker)
    {
        if (!class_exists('\Symfony\Component\Translation\Translator')) {
            return;
        }
        $config = config('translation', []);
        static::$_translator = $translator = new Translator($config['locale']);
        $translator->addLoader('php', new PhpFileLoader());
        $translator->setFallbackLocales($config['fallback_locale']);
        if (!$translations_path = realpath($config['path'])) {
            return;
        }
        foreach (glob($translations_path . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*.php') as $file) {
            $domain = basename($file, '.php');
            $dir_name = pathinfo($file, PATHINFO_DIRNAME);
            $locale = substr(strrchr($dir_name, DIRECTORY_SEPARATOR), 1);
            if ($domain && $locale) {
                $translator->addResource('php', $file, $locale, $domain);
            }
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return static::$_translator->{$name}(... $arguments);
    }
}
