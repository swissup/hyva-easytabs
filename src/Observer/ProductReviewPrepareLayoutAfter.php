<?php
namespace Swissup\HyvaEasytabs\Observer;

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
        $layout->reorderChild($block->getNameInLayout(), $listBlockName, 0, false);
    }
}
