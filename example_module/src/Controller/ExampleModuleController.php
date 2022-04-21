<?php
/**
 * @file
 * Contains \Drupal\test_twig\Controller\TestTwigController.
 */
 
namespace Drupal\example_module\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class ExampleModuleController extends ControllerBase {
  public function build() {
    $moduleVar = (object) [
      'cache_tag_css_tarot_module' => $this->getCacheTagFile($file = '/css/example-module-css-override.css'),
    ];

    return [
      '#theme' => 'example_module', // connect example_module.module key name Using Twig template
      '#moduleVar' => $moduleVar, // using {{moduleVar.key}} in twig
      // '#assets' => $this->t('Test Value'),
      // '#markup' => 'Welcome to our Website.' // using markup
    ];
 
  }

  private $module_name;

  public function __construct()
  {
    $class = get_called_class(); // or $class = static::class;
    $arr_class = explode("\\", $class);
    $this->module_name = $arr_class[1];
  }

  public function getCacheTagFile($file = null){
    // return string file time edit as cache query string
    $module_handler = \Drupal::service('module_handler');
    $module_path = $module_handler->getModule($this->module_name)->getPath();
    $cacheTag =  filemtime($module_path.$file);
    return $cacheTag;
  }
}

