<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Tests\Form\Type;

use PHPUnit\Framework\MockObject\MockObject;
use Sonata\AdminBundle\Form\Type\ModelReferenceType;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

final class ModelReferenceTypeTest extends TypeTestCase
{
    /**
     * @var MockObject&ModelManagerInterface<object>
     */
    private $modelManager;

    protected function setUp(): void
    {
        $this->modelManager = $this->createMock(ModelManagerInterface::class);

        parent::setUp();
    }

    public function testSubmitValidData(): void
    {
        $formData = '42';

        $form = $this->factory->create(
            ModelReferenceType::class,
            null,
            [
                'model_manager' => $this->modelManager,
                'class' => 'My\Entity',
            ]
        );
        $this->modelManager->expects(static::once())->method('find')->with('My\Entity', '42');
        $form->submit($formData);
        static::assertTrue($form->isSynchronized());
    }

    /**
     * @phpstan-return array<FormExtensionInterface>
     */
    protected function getExtensions(): array
    {
        return [
            new PreloadedExtension([
                new ModelReferenceType(),
            ], []),
        ];
    }
}
