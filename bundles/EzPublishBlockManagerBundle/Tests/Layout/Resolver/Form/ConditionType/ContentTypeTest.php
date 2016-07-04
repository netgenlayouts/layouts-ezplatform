<?php

namespace Netgen\Bundle\EzPublishBlockManagerBundle\Tests\Layout\Resolver\Form\ConditionType;

use Netgen\Bundle\EzPublishBlockManagerBundle\Layout\Resolver\Form\ConditionType\Mapper\ContentType as ContentTypeMapper;
use Netgen\Bundle\EzPublishBlockManagerBundle\Layout\Resolver\ConditionType\ContentType;
use Netgen\BlockManager\API\Values\ConditionCreateStruct;
use Netgen\BlockManager\Layout\Resolver\Form\ConditionType;
use Netgen\BlockManager\Tests\TestCase\FormTestCase;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\Core\Repository\Values\ContentType\ContentTypeGroup;
use eZ\Publish\Core\Repository\Values\ContentType\ContentType as EzContentType;

class ContentTypeTest extends FormTestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $contentServiceMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $contentTypeServiceMock;

    /**
     * @var \Netgen\BlockManager\Layout\Resolver\ConditionTypeInterface
     */
    protected $conditionType;

    public function setUp()
    {
        parent::setUp();

        $this->conditionType = new ContentType(
            $this->contentServiceMock,
            $this->contentTypeServiceMock
        );
    }

    /**
     * @return \Symfony\Component\Form\FormTypeInterface
     */
    public function getMainType()
    {
        $this->contentServiceMock = $this->createMock(ContentService::class);
        $this->contentTypeServiceMock = $this->createMock(ContentTypeService::class);

        return new ConditionType(
            array(
                'ez_content_type' => new ContentTypeMapper(
                    $this->contentTypeServiceMock
                ),
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\Layout\Resolver\Form\ConditionType::buildForm
     * @covers \Netgen\BlockManager\Layout\Resolver\Form\ConditionType\Mapper::getOptions
     * @covers \Netgen\BlockManager\Layout\Resolver\Form\ConditionType\Mapper::handleForm
     * @covers \Netgen\Bundle\EzPublishBlockManagerBundle\Layout\Resolver\Form\ConditionType\Mapper\ContentType::__construct
     * @covers \Netgen\Bundle\EzPublishBlockManagerBundle\Layout\Resolver\Form\ConditionType\Mapper\ContentType::getFormType
     * @covers \Netgen\Bundle\EzPublishBlockManagerBundle\Layout\Resolver\Form\ConditionType\Mapper\ContentType::getOptions
     */
    public function testSubmitValidData()
    {
        $this->contentTypeServiceMock
            ->expects($this->at(0))
            ->method('loadContentTypeGroups')
            ->will($this->returnValue(array(new ContentTypeGroup())));

        $this->contentTypeServiceMock
            ->expects($this->at(1))
            ->method('loadContentTypes')
            ->with($this->equalTo(new ContentTypeGroup()))
            ->will(
                $this->returnValue(
                    array(
                        new EzContentType(
                            array(
                                'identifier' => 'article',
                                'names' => array(
                                    'eng-GB' => 'Article',
                                ),
                                'fieldDefinitions' => array(),
                            )
                        ),
                        new EzContentType(
                            array(
                                'identifier' => 'news',
                                'names' => array(
                                    'eng-GB' => 'News',
                                ),
                                'fieldDefinitions' => array(),
                            )
                        ),
                    )
                )
            );

        $submittedData = array(
            'value' => array('article', 'news'),
        );

        $updatedStruct = new ConditionCreateStruct();
        $updatedStruct->value = array('article', 'news');

        $form = $this->factory->create(
            ConditionType::class,
            new ConditionCreateStruct(),
            array('conditionType' => $this->conditionType)
        );

        $valueFormConfig = $form->get('value')->getConfig();
        self::assertInstanceOf(ChoiceType::class, $valueFormConfig->getType()->getInnerType());

        $form->submit($submittedData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($updatedStruct, $form->getData());

        self::assertArrayHasKey('value', $form->createView()->children);
    }
}