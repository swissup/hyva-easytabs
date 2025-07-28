# magento2-swissup-easytabs

Hyvä Themes Compatibility module for Swissup_Easytabs
 
## Installation

```bash
cd <magento_root>
composer config repositories.swissup composer https://docs.swissuplabs.com/packages/
composer require hyva-themes/magento2-swissup-easytbas
```

## Configure tabs

### Reviews

Unset follow blocks (you can use tab option for it):
 - `product.review.form`;
 - `review_list`.

### Related products

Add tab "Block html". Use follow code for the content:

`{{block class="Magento\Catalog\Block\Product\View" template="Magento_Catalog::product/slider/product-slider.phtml" type="related"}}`

Unset block `related`.

### Upsell

Add tab "Block html". Use follow code for the content:

`{{block class="Magento\Catalog\Block\Product\View" template="Magento_Catalog::product/slider/product-slider.phtml" type="upsell"}}`

Unset block `upsell`.
