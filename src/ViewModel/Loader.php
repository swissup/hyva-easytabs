<?php
namespace Hyva\SwissupEasytabs\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface;

class Loader implements ArgumentInterface
{
    private LayoutInterface $layout;
    private string $loaderHtml = '';

    public function __construct(
        LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    public function getHtml(): string
    {
        if ($this->loaderHtml === '') {
            $loader = $this->getLoader();
            $this->loaderHtml = str_replace(
                [ ' fixed ', ' style="left'     ],
                [ ' ',       ' style-off="left' ],
                $loader->toHtml()
            );
        }

        return $this->loaderHtml;
    }

    private function getLoader(): Template
    {
        $allBlocks = $this->layout->getAllBlocks();
        $loaders = array_filter($allBlocks, function ($block) {
            return $block instanceof Template && $block->getTemplate() === 'Hyva_Theme::ui/loading.phtml';
        });
        if (empty($loaders)) {
            $loaders[] = $this->layout->createBlock(Template::class)
                ->setTemplate('Hyva_Theme::ui/loading.phtml');
        }
        return reset($loaders);
    }
}
