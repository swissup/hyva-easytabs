<?php
namespace Hyva\SwissupEasytabs\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Hyva\Theme\Service\CurrentTheme;

class ProductReviewPrepareLayoutAfter implements ObserverInterface
{
    private CurrentTheme $currentThemeService;

    public function __construct(
        CurrentTheme $currentThemeService
    ) {
        $this->currentThemeService = $currentThemeService;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (!$this->currentThemeService->isHyva()) {
            return;
        }
        $block = $observer->getEvent()->getBlock();
        $layout = $observer->getEvent()->getLayout();
        $listBlockName = 'easytab.product.review_list';
        $reviewList = $layout->createBlock(
            \Magento\Review\Block\Product\View::class,
            $listBlockName,
            [
                'data' => [
                    'template' => 'Magento_Review::product/view/list.phtml',
                    'hide_title' => true,

                ]
            ]
        );
        $block->setChild('review_list', $reviewList);
        $pager = $layout->createBlock(
            \Magento\Theme\Block\Html\Pager::class,
            'easytab.product.review_list.toolbar',
            [
                'data' => [
                    'pagination_url_anchor' => 'customer-review-list',
                ]
            ]
        );
        $reviewList->setChild('review_list.toolbar', $pager);
        $textBlock = $layout->createBlock(
            \Magento\Framework\View\Element\Text::class,
            'easytab.product.review_styles',
            [
                'data' => [
                    'text' => <<<HTML
                        <style>
                            .product.data.items #customer-review-list > :first-child { display: none; }
                            .product.data.items [id^="tab-label-"] .counter::before { content: '('; }
                            .product.data.items [id^="tab-label-"] .counter::after { content: ')'; }
                        </style>
                    HTML
                ]
            ]
        );
        $block->setChild('review_styles', $textBlock);
        $layout->reorderChild($block->getNameInLayout(), $listBlockName, 0, false);
    }
}
