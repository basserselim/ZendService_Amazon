<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Service
 */

namespace ZendService\Amazon;

use DOMElement;
use DOMXPath;

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Amazon
 */
class Variations
{
    /**
     * @var int
     */
    public $TotalVariations;

    /**
     * @var array
     */
    public $VariationDimensions;

    /**
     * @var array Of Item
     */
    public $Items;

    /**
     * Parse the given Offer Set Element
     *
     * @param  DOMElement $dom
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('az', 'http://webservices.amazon.com/AWSECommerceService/' . Amazon::getVersion());

        $variationsDimensions = $xpath->query('./az:Variations/az:VariationDimensions/az:VariationDimension/text()', $dom);
        if ($variationsDimensions->length >= 1) {
            foreach ($variationsDimensions as $dimension) {
                $this->VariationDimensions[] = (string)$dimension->data;
            }
        }

        if ($xpath->query('./az:Variations/az:TotalVariations', $dom)->length == 1) {
        }

        $items = $xpath->query('./az:Variations/az:Item', $dom);
        if ($items->length >= 1) {
            foreach ($items as $item) {
                $this->Items[] = new Item($item);
            }
        }
    }
}
