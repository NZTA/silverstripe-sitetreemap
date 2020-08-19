<?php

namespace NZTA\Sitemap\Pages;

use SilverStripe\CMS\Model\SiteTree;

class SiteTreemapPage extends \Page {

    private static $singular_name = 'SiteTreemap Page';
    private static $plural_name = 'SiteTreemap Pages';
    private static $description = 'Displays a sitemap with all pages marked for display in the sitemap.';

    private static $table_name = 'SiteTreemapPage';

    private static $icon  = 'innoweb/silverstripe-sitemap: client/images/treeicons/sitemap.gif';
	
	private static $excluded_pagetypes = [];

    private static $defaults = [
        'ShowInMenus'   => false,
        'ShowInSearch'  => false,
        'ShowInSitemap' => false,
        'Priority'      => '1.0',
    ];

    public function SitemapRootItems()
    {
        if (class_exists('Symbiote\Multisites\Multisites')) {
            $parent = $this->SiteID;
        } else {
            $parent = 0;
        }
        $filter = [
            'ParentID'       =>  $parent,
            'ShowInSitemap'  =>  1,
        ];
        if (count(self::config()->get('excluded_pagetypes'))) {
            $filter['ClassName:not'] = self::config()->get('excluded_pagetypes');
        }
        $items = SiteTree::get()->filter($filter);
        return $items;
    }

}
