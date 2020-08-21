<?php

namespace NZTA\Sitemap\Extensions;

use NZTA\Sitemap\Pages\SiteTreemapPage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\Forms\CheckboxField;

class SitemapSiteTreeExtension extends SiteTreeExtension {

    private static $db = [
        'ShowInSitemap' => 'Boolean'
    ];

    private static $defaults = [
        'ShowInSitemap' => true,
    ];

    public function updateSettingsFields(&$fields)
    {
        if (!in_array($this->owner->ClassName, SiteTreemapPage::config()->get('excluded_pagetypes'))) {
            $fields->addFieldToTab(
                'Root.Settings',
                CheckboxField::create(
                    'ShowInSitemap',
                    _t('SitemapDecorator.SHOWINSITEMAP', 'Show in sitemap?')
                ),
                'ShowInSearch'
            );
        }
    }

    public function SitemapChildren()
    {
        $filter = [
            'ShowInSitemap' => '1',
        ];
        if (count(SiteTreemapPage::config()->get('excluded_pagetypes'))) {
            $filter['ClassName:not'] = SiteTreemapPage::config()->get('excluded_pagetypes');
        }
        $children = $this->owner->AllChildren()->filter($filter);
        return $children;
    }

    public function SitemapCacheKey()
    {
        $fragments = [
            $this->owner->ID,
            SiteTree::get()->max('LastEdited'),
            SiteTree::get()->count()
        ];
        return implode('-_-', $fragments);
    }

}

