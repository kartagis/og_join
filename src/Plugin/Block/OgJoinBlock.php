<?php

namespace Drupal\example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'ExampleFormBlock' block.
 *
 * @Block(
 *  id = "oj_join_block",
 *  admin_label = @Translation("OgJoin"),
 * )
 */
class ExampleFormBlock extends BlockBase implements ContainerFactoryPluginInterface {
  protected $formBuilder;

  /**
   * @param array $configuration
   * @param [type] $plugin_id
   * @param [type] $plugin_definition
   * @param FormBuilderInterface $formBuilder
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilderInterface $formBuilder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $formBuilder;
  }

  /**
   * @param ContainerInterface $container
   * @param array $configuration
   * @param [type] $plugin_id
   * @param [type] $plugin_definition
   * @return void
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder')
    );
  }

  /**
   * @return void
   */
  public function build() {
    $form = $this->formBuilder->getForm('\Drupal\og_join\Form\OgJoinForm');
    return $form;
  }
}