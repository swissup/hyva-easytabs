<?php
namespace Swissup\HyvaEasytabs\Observer;

use Magento\Framework\App\ViewInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Hyva\Theme\Service\CurrentTheme;

class CatalogControllerProductInitAfter implements ObserverInterface
{
    private ViewInterface $view;
    private CurrentTheme $currentThemeService;

    public function __construct(
        ViewInterface $view,
        CurrentTheme $currentThemeService
    ) {
        $this->view = $view;
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
        $product = $observer->getEvent()->getProduct();
        $controller = $observer->getEvent()->getControllerAction();
        if ($product
            && $controller instanceof \Swissup\Easytabs\Controller\Index\Index
            && $this->currentThemeService->isHyva()
        ) {
            $this->view->getLayout()->getUpdate()->addHandle('catalog_product_view');
        }
    }
}
