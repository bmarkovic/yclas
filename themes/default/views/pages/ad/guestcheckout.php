<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="well col-xs-12 col-sm-12 col-md-12">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <address>
                <strong><?=Core::config('general.site_name')?></strong>
                <br>
                <?=Core::config('general.base_url')?>
            </address>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 text-right">
            <p>
                <em><?=_e('Date')?>: <?=date(core::config('general.date_format'))?></em>
                <br>
                <em><?=_e('Checkout')?> :# <?=$ad->id_ad?></em>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="text-center">
            <h1><?=_e('Checkout')?></h1>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="text-align: center">#</th>
                    <th><?=_e('Product')?></th>
                    <th class="text-center"><?=_e('Price')?></th>
                </tr>
            </thead>
            <tbody>
                <?if(isset($ad->cf_shipping) AND Valid::price($ad->cf_shipping) AND $ad->cf_shipping > 0):?>
                    <tr>
                        <td class="col-md-1" style="text-align: center"><?=$ad->id_ad?></td>
                        <td class="col-md-9"><?=$ad->title?> <em>(<?=Model_Order::product_desc(Model_Order::PRODUCT_AD_SELL)?>)</em></td>
                        <td class="col-md-2 text-center"><?=i18n::money_format($ad->price, core::config('payment.paypal_currency'))?></td>
                    </tr>
                    <tr>
                        <td class="col-md-1" style="text-align: center"></td>
                        <td class="col-md-9"><?=_e('Shipping')?></td>
                        <td class="col-md-2 text-center"><?=i18n::money_format($ad->cf_shipping, core::config('payment.paypal_currency'))?></td>
                    </tr>
                <?else:?>
                    <tr>
                        <td class="col-md-1" style="text-align: center"><?=$ad->id_ad?></td>
                        <td class="col-md-9"><?=$ad->title?> <em>(<?=Model_Order::product_desc(Model_Order::PRODUCT_AD_SELL)?>)</em></td>
                        <td class="col-md-2 text-center">
                        <?=i18n::format_currency($ad->price, core::config('payment.paypal_currency'))?>
                        </td>
                    </tr>
                <?endif?>
                <tr>
                    <td>   </td>
                    <td class="text-right"><h4><strong><?=_e('Total')?>: </strong></h4></td>
                    <?if(isset($ad->cf_shipping) AND Valid::price($ad->cf_shipping) AND $ad->cf_shipping > 0):?>
                        <td class="text-center text-danger"><h4><strong><?=i18n::money_format($ad->price + $ad->cf_shipping, core::config('payment.paypal_currency'))?></strong></h4></td>
                    <?else:?>
                        <td class="text-center text-danger"><h4><strong><?=i18n::money_format($ad->price, core::config('payment.paypal_currency'))?></strong></h4></td>
                    <?endif?>
                </tr>
            </tbody>
        </table>

        <?if ($ad->price>0):?>

        <?=StripeKO::button_guest_connect($ad)?>
        
        <?if (Core::config('payment.paypal_account')!=''):?>
            <p class="text-right">
                <a class="btn btn-success btn-lg" href="<?=Route::url('default', array('controller'=> 'paypal','action'=>'guestpay' , 'id' => $ad->id_ad))?>">
                    <?=_e('Pay with Paypal')?> <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </p>
        <?endif?>

        <?else:?>
            <ul class="list-inline text-right">
                <li>
                    <a title="<?=__('Click to proceed')?>" class="btn btn-success" href="<?=Route::url('default', array('controller'=> 'ad', 'action'=>'checkoutfree','id'=>$order->id_order))?>">
                        <?=_e('Click to proceed')?>
                    </a>
                </li>
            </ul>
        <?endif?>

    </div>
</div>

<?if (core::config('payment.fraudlabspro')!=''): ?>
<script>
    (function(){
        function s() {
            var e = document.createElement('script');
            e.type = 'text/javascript';
            e.async = true;
            e.src = ('https:' === document.location.protocol ? 'https://' : 'http://') + 'cdn.fraudlabspro.com/s.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(e, s);
        }             
        (window.attachEvent) ? window.attachEvent('onload', s) : window.addEventListener('load', s, false);
    })();
</script>
<?endif?>