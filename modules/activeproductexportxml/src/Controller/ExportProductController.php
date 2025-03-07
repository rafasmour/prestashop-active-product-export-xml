<?php

namespace ActiveProductExportXML\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Doctrine\Common\Cache\CacheProvider;
use Symfony\Component\HttpFoundation\Response;
class ExportProductController extends FrameworkBundleAdminController
{

    public function exportXMLAction(): Response
    {
        $productXMLService = $this->get('rafasmour.activeproductexportxml.export_product_xml');
        $resp = new Response();
        $resp->headers->set('Content-Type', 'text/xml');
        $resp->headers->set('Content-Disposition', 'attachment; filename="products.xml"');
        $resp->setContent($productXMLService->getActiveProductsAsXML());
        return $resp;
    }
}