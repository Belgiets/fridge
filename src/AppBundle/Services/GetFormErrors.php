<?php
namespace AppBundle\Services;

/**
 * Class GetFormErrors
 *
 * To get ajax submitted forms errors
 *
 * @package AppBundle\Service
 */
class GetFormErrors
{
    /**
     * @param $errors array
     * @param $child object
     */
    public function getFieldErrorMessage(&$errors, $child) {
        foreach ($child->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
    }

    /**
     * @param $form \Symfony\Component\Form\Form
     * @return array
     */
    public function getAllErrors($form) {
        $errors = [];

        //global errors
        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        //fields errors
        if ($form->count() > 0) {
            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    self::getFieldErrorMessage($errors, $child);
                }
            }
        }

        return $errors;
    }
}