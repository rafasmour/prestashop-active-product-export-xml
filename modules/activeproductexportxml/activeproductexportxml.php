<?php
/**
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Activeproductexportxml extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'activeproductexportxml';
        $this->tab = 'export';
        $this->version = '1.0.0';
        $this->author = 'Rafail Mourouzidis';
        $this->need_instance = 1;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Export Active Products as xml');
        $this->description = $this->l('Exports active products\' basic information as an XML file');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }
    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayFooterAfter');
    }

    public function uninstall()
    {
        return parent::uninstall() &&
            $this->unregisterHook('displayFooterAfter');
    }
    public function exportActiveProductsXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products></products>');
        // get basic info of active products
        $sql = 'SELECT p.id_product, p.price, p.id_category_default, p.reference, m.name AS brand
                FROM '._DB_PREFIX_.'product p
                LEFT JOIN '._DB_PREFIX_.'manufacturer m ON (p.id_manufacturer = m.id_manufacturer)
                WHERE p.active = 1';
        $products = Db::getInstance()->executeS($sql);
        var_dump($products[0]);

        foreach ($products as $product) {
            $productNode = $xml->addChild('product');
            $productNode->addChild('id', $product['id_product']);
            $productNode->addChild('price', $product['price']);

            $sqlImg = 'SELECT id_image FROM '._DB_PREFIX_.'image 
                       WHERE id_product = '.(int)$product['id_product'].' 
                       ORDER BY cover DESC, position ASC LIMIT 1';
            $img = Db::getInstance()->executeS($sqlImg);
            var_dump($img);
            if ($img) {
                $link = new Link();
                $imgUrl = $this->context->link->getImageLink($product.link_rewrite, Product::getCover($product.id), 'home_default');
                var_dump($imgUrl);
            } else {
                $productNode->addChild('main_image', '');
            }
            $productNode->addChild('brand', $product['brand']);
            $productNode->addChild('product_code', $product['reference']);
        }
        return $xml->asXML();
    }
    public function hookDisplayFooterAfter($params)
    {
        $xml = $this->exportActiveProductsXML();
        var_dump($xml);
        return;
    }
}
