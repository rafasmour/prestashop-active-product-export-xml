<?php

use ActiveProductExportXML\Service\ProductXMLService;
class ActiveProductExportXMLDownloadModuleFrontController extends ModuleFrontController
{
    public function initContent() {
        parent::initContent();
        $content =  $this->exportXML();
        header('Content-Type', 'text/xml');
        header("Content-disposition: attachment; filename=\"product.xml\"");

        echo $content;
        exit;
    }
    public function exportXML(): string {
        $productAsXML = new ProductXMLService();
        return $productAsXML->getActiveProductsAsXML();
    }
}
