<?php

namespace Pierrre\EncrypterBundle\Tests\Form\Transformer;

use Pierrre\EncrypterBundle\Form\EncrypterTransformer;

class EncrypterTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldEncryptAndDecryptOnTransform()
    {
        $input = 'text';

        $encrypter = $this->getMockBuilder('encrypter')
            ->disableOriginalConstructor()
            ->getMock();

        $encrypter->expects($this->once())
            ->method('encrypt')
            ->with($input)
            ->will($this->returnValue($encryptedInput));

        $transformer = new EncrypterTransformer($encrypter);

        $encryptedInput = $transformer->reverseTransform($input);

        $this->assertNotEquals($input, $encryptedInput);
        $this->assertEquals($input, $transformer->transform($encryptedInput));
    }
}
