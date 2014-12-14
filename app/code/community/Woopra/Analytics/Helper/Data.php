<?php
/**
 * Woopra Module for Magento
 *
 * @package     Woopra_Analytics
 * @author      K3Live for Woopra
 * @copyright   Copyright (c) 2013 Woopra (http://www.woopra.com/)
 * @license     Open Software License (OSL 3.0)
 */

class Woopra_Analytics_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getAppId()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra/app_id');
    }
    public function getSecretKey()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra/secret_key');
    }
    public function getEnabled()
    {
        return (bool)Mage::getStoreConfig('woopra_analytics/woopra/enabled');
    }
    public function getHostname()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra/hostname');
    }
    public function getTest()
    {
        return (bool)Mage::getStoreConfig('woopra_analytics/woopra/test');
    }
    public function getSubdomain()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/subdomain');
    }
    public function getVistorTimeout()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/visitor_timeout');
    }
    public function getTrackUrlParameters()
    {
        return (bool)Mage::getStoreConfig('woopra_analytics/woopra_advanced/track_url_parameters');
    }
    public function getTrackingCookieExpiration()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/tracking_cookie_expiration');
    }
    public function getTrackingCookieName()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/tracking_cookie_name');
    }
    public function getTrackingCookieDomain()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/tracking_cookie_domain');
    }
    public function getTrackingCookiePath()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/tracking_cookie_path');
    }
    public function getPing()
    {
        return (bool)Mage::getStoreConfig('woopra_analytics/woopra_advanced/ping');
    }
    public function getPingInterval()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/ping_interval');
    }
    public function getDownloadTracking()
    {
        return (bool)Mage::getStoreConfig('woopra_analytics/woopra_advanced/download_tracking');
    }
    public function getDownloadTrackingPause()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/download_tracking_pause');
    }
    public function getOutgoingTracking()
    {
        return (bool)Mage::getStoreConfig('woopra_analytics/woopra_advanced/outgoing_tracking');
    }
    public function getOutgoingTrackingPause()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/outgoing_tracking_pause');
    }
    public function getOutgoingIgnoreSubdomain()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/outgoing_ignore_subdomain');
    }
    public function getHideCampaign()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_advanced/hide_campaign');
    }
    public function getCustomerName()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/name');
    }
    public function getCustomerEmail()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/email');
    }
    public function getCustomerCompany()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/company');
    }
    public function getCustomerLocation()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_location');
    }
    public function getCustomerPhone()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_phone');
    }
    public function getCustomerGroup()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_group');
    }
    public function getCustomerLifetimeSales()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_lifetime_sales');
    }
    public function getCustomerNumberOrders()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_number_orders');
    }
    public function getCustomerCreateDate()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_create_date');
    }
    public function getCustomerCartItems()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_cart_items');
    }
    public function getCustomerCartTotal()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_cart_total');
    }
    public function getCustomerWishlistItems()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_wishlist_items');
    }
    public function getCustomerWishlistTotal()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_outputs/customer_wishlist_total');
    }
    public function getCatalogSearch()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/catalog_search');
    }
    public function getChangedPassword()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/changed_password');
    }
    public function getCheckoutBillingAddress()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/checkout_billing_address');
    }
    public function getCheckoutShippingAddress()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/checkout_shipping_address');
    }
    public function getCheckoutShippingMethod()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/checkout_shipping_method');
    }
    public function getCheckoutPaymentMethod()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/checkout_payment_method');
    }
    public function getCheckoutReview()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/checkout_review');
    }
    public function getCheckoutSuccess()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/checkout_success');
    }
    public function getCmsNoRoute()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/cms_no_route');
    }
    public function getContactFormSent()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/contact_form_sent');
    }
    public function getCouponCodeAdded()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/coupon_added');
    }
    public function getCouponCodeRemoved()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/coupon_removed');
    }
    public function getCustomerCreateAccount()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/customer_create_account');
    }
    public function getCustomerCreateAccountSuccess()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/customer_create_account_success');
    }
    public function getCustomerLogin()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/customer_login');
    }
    public function getCustomerLogout()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/customer_logout');
    }
    public function getEstimatePost()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/estimate_post');
    }
    public function getForgotPassword()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/forgot_password');
    }
    public function getNewsletterSubscribed()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/newsletter_subscribed');
    }
    public function getNewsletterUnsubscribed()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/newsletter_unsubscribed');
    }
    public function getPollVote()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/poll_vote');
    }
    public function getProductAddedToCart()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_added_to_cart');
    }
    public function getProductRemovedFromCart()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_removed_from_cart');
    }
    public function getProductAddedToCompare()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_added_to_compare');
    }
    public function getProductRemovedFromCompare()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_removed_from_compare');
    }
    public function getProductAddedToWishlist()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_added_to_wishlist');
    }
    public function getProductRemovedFromWishlist()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_removed_from_wishlist');
    }
    public function getProductPurchased()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_purchased');
    }
    public function getProductTagAdded()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_tag_added');
    }
    public function getProductReviewRead()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_review_read');
    }
    public function getProductReviewPosted()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/product_review_posted');
    }
    public function getProductEmailToFriend()
    {
        return Mage::getStoreConfig('woopra_analytics/woopra_events/sendfriend_product');
    }
}