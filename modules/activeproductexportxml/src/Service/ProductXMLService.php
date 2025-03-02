<?php

namespace Activeproductexportxml\Service;

use SimpleXMLElement;

class ProductXMLService
{
    public function getCoverLink($productId): string {
        $coverId = \Product::getCover($productId);
        $coverId = $coverId['id_image'];
        $link = \Context::getContext()->link;
        $coverLink = $link->getImageLink($coverId, $productId);

        return $coverLink;
    }
    public function getActiveProductsAsXML() : string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products></products>');
        // get basic info of active products
        $lang = \Context::getContext()->language->id;
        $products = \ProductCore::getProducts($lang, 0, 0, 'id_product', 'ASC', false, true);
        foreach ($products as $product) {
            $productNode = $xml->addChild('product');
            $productNode->addChild('id', $product['id_product']);
            $productNode->addChild('name', $product['name']);
            $productNode->addChild('price', $product['price']);
            $imgLink = $this->getCoverLink($product['id_product']) ?? '';
            $productNode->addChild('image_link', $imgLink);
            $productNode->addChild('brand', $product['manufacturer_name']);
            $productNode->addChild('product_code', $product['reference']);
        }
        return $xml->asXML();
    }
}