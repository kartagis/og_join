<?php

namespace Drupal\og_join\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormstateInterface;

/**
 * Provides a OgJoin block
 * 
 * @Block (
 *  id = "og_join_block",
 *  admin_label = @Translation("OgJoin"),
 *  category = @Translation("OgJoin")
 * )
 */
class OgJoinBlock extends BlockBase {

    /**
     * {@inheritDoc}
     */
    public function build() {
        $form = \Drupal::formBuilder()->getForm('\Drupal\og_join\Form\OgJoinForm');
        return [
            '#markup' => \Drupal::service('renderer')->render($form)
        ];
    }
}