<?php

namespace Pierrre\EncrypterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

class EncryptedTextType extends AbstractType
{
    private $encrypterTransformer;

    public function __construct(DataTransformerInterface $encrypterTransformer)
    {
        $this->encrypterTransformer = $encrypterTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->appendClientTransformer($this->encrypterTransformer);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'encryptedText';
    }
}
