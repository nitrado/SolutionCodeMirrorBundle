<?php

namespace Solution\CodeMirrorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CodeMirrorType extends AbstractType
{
    /**
     * @var array
     */
    protected $parameters;

    public function __construct($defaultsParameters)
    {
        $this->parameters = $defaultsParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['parameters'] = array_merge($this->parameters, $options['parameters']);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       $resolver->setDefaults(
           array(
               'parameters' => $this->parameters
           )
       );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
        ? 'Symfony\Component\Form\Extension\Core\Type\TextareaType'
        : 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'code_mirror';
    }
}
