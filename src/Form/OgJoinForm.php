<?php

namespace Drupal\og_join\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\node\NodeInterface;
use Drupal\user\UserInterface;
use Drupal\og\Og;
use Drupal\og\ManageMembership;

class OgJoinForm extends ConfigFormBase {

    /**
     * {@inheritDoc}
     */
    public function getFormId() {
        return 'og_join_form';
    }
    
    /**
     * {@inheritDoc}
     */
    public function getEditableConfigNames() {
        return ['og_join.settings'];
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm($form, $form_state, NodeInterface $node = NULL) {
        $id = explode('/', $_SERVER['REQUEST_URI']);
        $entity = \Drupal\node\Entity\Node::load(end($id));
        $title = $entity->getTitle();
        $user = \Drupal::currentUser()->getDisplayName();
        $form['q'] = [
            '#type' => 'markup',
            '#markup' => $this->t('Hi %user, click the button if you would like to join this group called %title', ['%user' => $user, '%title' => $title]),
        ];
        $form['s'] = [
            '#type' => 'submit',
            '#value' => $this->t('Yes'),
        ];
        return $form;
    }

    /**
     * {@inheritDoc}
     */
    public function validateForm(&$form, $form_state) {
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
        $id = explode('/', $_SERVER['REQUEST_URI']);
        $entity = \Drupal\node\Entity\Node::load(end($id));
        if (Og::isMember($entity, $user)) {
            \Drupal::messenger()->addError($this->t('You have already subscribed to %group'), ['%group' => $entity->getTitle()]);
            return;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function submitForm(&$form, $form_state){
        $id = explode('/', $_SERVER['REQUEST_URI']);
        $entity = \Drupal\node\Entity\Node::load(end($id));
        $title = $entity->getTitle();
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
        $membership = Og::createMembership($entity, $user);
        $membership->save();
        \Drupal::messenger()->addMessage($this->t('You have been subscribed to the group %title', ['%title' => $title]));
    }
}