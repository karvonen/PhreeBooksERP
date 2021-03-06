<?php
/*
 * PhreeBooks dashboard - Currency Converter using XE
 *
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade Bizuno to newer
 * versions in the future. If you wish to customize Bizuno for your
 * needs please refer to http://www.phreesoft.com for more information.
 *
 * @name       Bizuno ERP
 * @author     Dave Premo, PhreeSoft <support@phreesoft.com>
 * @copyright  2008-2020, PhreeSoft, Inc.
 * @license    http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @version    3.x Last Update: 2020-01-17
 * @filesource /lib/controller/module/phreebooks/dashboards/currency_xe/currency_xe.php
 */

namespace bizuno;

class currency_xe
{
    public $moduleID = 'phreebooks';
    public $methodDir= 'dashboards';
    public $code     = 'currency_xe';
    public $category = 'general_ledger';
    public $noSettings= true;

    function __construct($settings=[])
    {
        $this->security= getUserCache('security', 'j2_mgr', false, 0);
        $defaults      = ['users'=>'-1','roles'=>'-1'];
        $this->settings= array_replace_recursive($defaults, $settings);
        $this->lang    = getMethLang($this->moduleID, $this->methodDir, $this->code);
    }

    public function settingsStructure()
    {
        return [
            'users' => ['label'=>lang('users'), 'position'=>'after','values'=>listUsers(),'attr'=>['type'=>'select','value'=>$this->settings['users'],'size'=>10,'multiple'=>'multiple']],
            'roles' => ['label'=>lang('groups'),'position'=>'after','values'=>listRoles(),'attr'=>['type'=>'select','value'=>$this->settings['roles'],'size'=>10,'multiple'=>'multiple']]];
    }

    public function render()
    {
        $defISO= getDefaultCurrency();
        $ISOs  = getModuleCache('phreebooks', 'currency', 'iso', false, []);
        $cVals = [];
        foreach ($ISOs as $code => $iso) {
            if ($defISO == $code) { continue; }
            $cVals[$code] = $iso['title'];
        }
//      $cVals = ['EUR'=>'Euro', 'ZAR'=>'South Africa Rand'];
        $lang  = substr(getUserCache('profile', 'language', false, 'en_US'), 0, 2);
        $size  = 'compact'; // choices are 'compact' (320 x 300), other option is 'normal' (560 x 310)
        $html  = '<div><div id="xecurrencywidget"></div>
<script>var xeCurrencyWidget = {"domain":"www.bizuno.com","language":"'.$lang.'","size":"'.$size.'"};</script>
<script src="https://www.xe.com/syndication/currencyconverterwidget.js"></script>
</div>';
        if (sizeof($cVals)) {
            $xRate = ['attr'=>['value'=>'']];
            $xSel  = ['values'=>viewKeyDropdown($cVals), 'attr'=>['type'=>'select']];
            $btnUpd= ['attr'=>['type'=>'button','value'=>lang('update')],'events'=>['onClick'=>"jq('#xeForm').submit();"]];
            $js    = "ajaxForm('xeForm');\n";
            $html .= '<form id="xeForm" action="'.BIZUNO_AJAX."&p=phreebooks/currency/setExcRate".'">';
            $html .= "<p>".$this->lang['update_desc']."</p>";
            $html .= "<p>1 $defISO = ".html5('excRate', $xRate).' '.html5('excISO', $xSel).'<br />'.html5('', $btnUpd).'</p></div>';
            $html .= htmlJS($js);
        } else {
            $html .= '<br />'.$this->lang['no_multi_langs'];
        }
        return $html;
    }
}
