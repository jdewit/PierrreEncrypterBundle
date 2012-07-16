<?php

namespace Pierrre\EncrypterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilder;

class EncryptedTextType extends AbstractType
{
    private $encrypterTransformer;

    public function __construct(DataTransformerInterface $encrypterTransformer)
    {
        $this->encrypterTransformer = $encrypterTransformer;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->appendClientTransformer($this->encrypterTransformer);
    }

    public function getParent(array $options)
    {
        return 'textarea';
    }

    public function getName()
    {
        return 'encrypted_text';
    }
}
