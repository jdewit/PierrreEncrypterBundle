<?php

namespace Pierrre\EncrypterBundle\Tests\Form\Transformer;

use Pierrre\EncrypterBundle\Form\EncrypterTransformer;

class EncrypterTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldEncryptOnlyDuringReverseTransform()
    {
        $input = 'text';
        $encryptedInput = '<p>text</p>';

        $encrypter = $this->getMockBuilder('encrypter')
            ->disableOriginalConstructor()
            ->getMock();

        $encrypter->expects($this->once())
            ->method('encrypt')
            ->with($input)
            ->will($this->returnValue($encryptedInput));

        $transformer = new EncrypterTransformer($encrypter);

        $this->assertEquals($encryptedInput, $transformer->reverseTransform($input));
        $this->assertEquals($encryptedInput, $transformer->transform($encryptedInput));
    }
}
