<?php

namespace Pierrre\EncrypterBundle\Form\Transformer;

use Pierrre\EncrypterBundle\Util\EncrypterManager;
use Symfony\Component\Form\DataTransformerInterface;

class EncrypterTransformer implements DataTransformerInterface
{
    private $encrypterManager;
    private $encrypterName;

    /**
     * Constructor.
     *
     * @param Encrypter $encrypter
     */
    public function __construct(EncrypterManager $encrypterManager, $encrypterName)
    {
        $this->encrypterManager = $encrypterManager;
        $this->encrypterName = $encrypterName;
    }

    /**
     * @see Symfony\Component\Form\DataTransformerInterface::transform()
     */
    public function transform($value)
    {
        $encrypter = $this->encrypterManager->get($this->encrypterName);

        return $encrypter->decrypt($value);
    }

    /**
     * @see Symfony\Component\Form\DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($value)
    {
        $encrypter = $this->encrypterManager->get($this->encrypterName);

        return $encrypter->encrypt($value);
    }
}
