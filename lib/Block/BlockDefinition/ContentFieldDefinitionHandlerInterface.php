<?php

namespace Netgen\BlockManager\Ez\Block\BlockDefinition;

use Netgen\BlockManager\Block\BlockDefinition\BlockDefinitionHandlerInterface;
use Netgen\BlockManager\API\Values\Page\Block;

interface ContentFieldDefinitionHandlerInterface extends BlockDefinitionHandlerInterface
{
    /**
     * Returns the identifier of the eZ Publish content field to use.
     *
     * @param \Netgen\BlockManager\API\Values\Page\Block $block
     *
     * @return string
     */
    public function getFieldIdentifier(Block $block);
}