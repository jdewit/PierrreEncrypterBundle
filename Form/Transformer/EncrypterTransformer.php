<?php

namespace Pierrre\EncrypterBundle\Form\Transformer;

use Pierrre\EncrypterBundle\Util\Encrypter;
use Symfony\Component\Form\DataTransformerInterface;

class EncrypterTransformer implements DataTransformerInterface
{
    private $encrypter;

    /**
     * Constructor.
     *
     * @param Encrypter $encrypter
     */
    public function __construct(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * @see Symfony\Component\Form\DataTransformerInterface::transform()
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * @see Symfony\Component\Form\DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($value)
    {
        return $this->encrypter->encrypt($value);
    }
}
