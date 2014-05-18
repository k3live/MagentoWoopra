<?php
/**
 * Woopra Module for Magento
 *
 * @package     Woopra_Analytics
 * @author      K3Live for Woopra
 * @copyright   Copyright (c) 2013 Woopra (http://www.woopra.com/)
 * @license     Open Software License (OSL 3.0)
 */

class Woopra_Analytics_Block_Script extends Mage_Core_Block_Template
{
    /*
     * Constructor method
     *
     * @access public
     * @param null
     * @return null
     */
    public function _construct()
    {
        parent::_construct();

        // Decide whether the Woopra Module has been activated
        $website_id = Mage::helper('woopra')->getApiKey();
        if(Mage::helper('woopra')->getEnabled() == true) {
            $this->setTemplate('woopra/script.phtml');
        }
    }

    /*
     * Helper method to get data to show in Woopra
     *
     * @access public
     * @param string $key
     * @return string
     */
    public function getSetting($key = null)
    {
        static $data;
        if(empty($data)) {
            $data = array(
                'enabled' => Mage::helper('woopra')->getEnabled(),
                'test' => Mage::helper('woopra')->getTest(),
                'visitor_timeout' => Mage::helper('woopra')->getVistorTimeout(),
                'track_url_parameters' => Mage::helper('woopra')->getTrackUrlParameters(),
                'hostname' => Mage::helper('woopra')->getHostname(),
                'subdomain' => Mage::helper('woopra')->getSubdomain(),
                'tracking_cookie_expiration' => Mage::helper('woopra')->getTrackingCookieExpiration(),
                'tracking_cookie_name' => Mage::helper('woopra')->getTrackingCookieName(),
                'tracking_cookie_domain' => Mage::helper('woopra')->getTrackingCookieDomain(),
                'tracking_cookie_path' => Mage::helper('woopra')->getTrackingCookiePath(),
                'ping' => Mage::helper('woopra')->getPing(),
                'ping_interval' => Mage::helper('woopra')->getPingInterval(),
                'download_tracking' => Mage::helper('woopra')->getDownloadTracking(),
                'download_tracking_pause' => Mage::helper('woopra')->getDownloadTrackingPause(),
                'outgoing_tracking' => Mage::helper('woopra')->getOutgoingTracking(),
                'outgoing_tracking_pause' => Mage::helper('woopra')->getOutgoingTrackingPause(),
                'url' => $_SERVER['HTTP_HOST']
            );

            // Add customer records
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            if(!empty($customer)) {
                //Customer Name
                if ($customer->getName() != ' ' && Mage::helper('woopra')->getCustomerName() != NULL) {
                    $data['customer_name'] = $customer->getName();
                }
                //Customer Email
                if (Mage::helper('woopra')->getCustomerEmail() != NULL) {
                    $data['customer_email'] = $customer->getEmail();
                }

                //Customer Address Array
                $address = $customer->getDefaultBillingAddress();
                if(!empty($address)) {
                    $address = $customer->getDefaultShippingAddress();
                }
                if(!empty($address)) {
                    //Customer Company
                    if (Mage::helper('woopra')->getCustomerCompany() != NULL) {
                        $data['customer_company'] = $address->getCompany();
                    }
                    //Customer Location
                    if (Mage::helper('woopra')->getCustomerLocation() != NULL) {
                        $data['customer_location'] = $address->getCity() . ', ' . $address->getRegion() . ' (' . $address->getCountryId() . ')';
                    }
                    //Customer Phone
                    if (Mage::helper('woopra')->getCustomerPhone() != NULL) {
                        $data['customer_phone'] = $address->getTelephone();
                    }
                }

                //Customer Group
                if (Mage::helper('woopra')->getCustomerGroup() != NULL) {
                    $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                    $group = Mage::getModel('customer/group')->load($groupId);
                    $data['customer_group'] = $group->getCode();
                }

                //Customer Account Creation Date
                if (Mage::helper('woopra')->getCustomerCreateDate() != NULL) {
                    $date = Mage::app()->getLocale()->storeDate(
                        $customer->getStoreId(),
                        $customer->getCreatedAtTimestamp(),
                        true
                        );
                    if(strtotime($date) != Mage::app()->getLocale()->storeTimeStamp()) {
                        $data['customer_create_date'] = Mage::helper('core')->formatDate($date, Mage_Core_Model_Locale::FORMAT_TYPE_SHORT, true);
                    }
                }

                //Customer Lifetime Array
                $customerTotals = Mage::getResourceModel('sales/sale_collection')
                    ->setOrderStateFilter(Mage_Sales_Model_Order::STATE_CANCELED, true)
                    ->setCustomerFilter($customer)
                    ->load()
                    ->getTotals();
                //Customer Lifetime Sales Count
                if (Mage::helper('woopra')->getCustomerLifetimeSales() != NULL && $group != 'NOT LOGGED IN') {
                    $data['customer_lifetime_sales'] = round($customerTotals->getLifetime(), 2);
                }
                //Customer Lifetime Orders
                if (Mage::helper('woopra')->getCustomerNumberOrders() != NULL && $group != 'NOT LOGGED IN') {
                    $data['customer_number_orders'] = $customerTotals->getNumOrders();
                }

                //Customer Wishlist Array
                $wishList = Mage::getSingleton('wishlist/wishlist')->loadByCustomer($customer);
                $wishListItemCollection = $wishList->getItemCollection();
                $wishlistItems = 0;
                $wishListTotal = 0;
                foreach ($wishListItemCollection as $item) {
                    $product = $item->getProduct();
                    $wishlistItems = $wishlistItems + 1;
                    $wishListTotal = $wishListTotal + $product->getPrice();
                }
                //Wishlist Items Count
                if (Mage::helper('woopra')->getCustomerWishlistItems() != NULL) {
                    $data['customer_wishlist_items'] = $wishlistItems;
                }
                //Wishlist Total
                if (Mage::helper('woopra')->getCustomerWishlistTotal() != NULL) {
                    $data['customer_wishlist_total'] = $wishListTotal;
                }
            }

            //Cart Items Count
            if (Mage::helper('woopra')->getCustomerCartItems() != NULL) {
                $data['customer_cart_items'] = Mage::helper('checkout/cart')->getCart()->getItemsCount();
            }
            //Cart Total
            if (Mage::helper('woopra')->getCustomerCartTotal() != NULL) {
                $data['customer_cart_total'] = round(Mage::getSingleton('checkout/session')->getQuote()->getBaseSubtotal(), 2);
            }
            //Current Catagory
            $currentCategory = Mage::registry('current_category');
            if(!empty($currentCategory)) {
                $data['category'] = $currentCategory->getName();
            }
            //Current Product
            $currentProduct = Mage::registry('current_product');
            if(!empty($currentProduct)) {
                $data['product_sku'] = $currentProduct->getSku();
                $data['product_price'] = strip_tags(Mage::app()->getStore()->formatPrice($currentProduct->getPrice()));
            }

            //Newsletter changes
            if (Mage::helper('woopra')->getNewsletterSubscribed() != NULL) {
                $data['woopra_subscriber_changed'] = Mage::getSingleton('core/session')->getData('woopra_subscriber_changed', true);
                $data['woopra_subscriber_status'] = Mage::getSingleton('core/session')->getData('woopra_subscriber_status', true);
                $data['woopra_subscriber_email'] = Mage::getSingleton('core/session')->getData('woopra_subscriber_email', true);
                //Mage::log($data['woopra_subscriber_changed'] ." | ". $data['woopra_subscriber_status'] ." | ". $data['woopra_subscriber_email'], null, 'woopra.log');
            }

            //Contacts Form
            if (Mage::helper('woopra')->getContactFormSent() != NULL) {
                $data['woopra_contacts_index_post'] = Mage::getSingleton('core/session')->getData('woopra_contacts_index_post', true);
                $data['woopra_contacts_name'] = Mage::getSingleton('core/session')->getData('woopra_contacts_name', true);
                $data['woopra_contacts_email'] = Mage::getSingleton('core/session')->getData('woopra_contacts_email', true);
                $data['woopra_contacts_telephone'] = Mage::getSingleton('core/session')->getData('woopra_contacts_telephone', true);
                $data['woopra_contacts_comment'] = Mage::getSingleton('core/session')->getData('woopra_contacts_comment', true);
            }

            //Cart/Wishlist/Compare Add/Remove
            $data['woopra_cart_wishlist_trigger'] = Mage::getSingleton('core/session')->getData('woopra_cart_wishlist_trigger', true);
            $data['woopra_cart_wishlist_status'] = Mage::getSingleton('core/session')->getData('woopra_cart_wishlist_status', true);
            $data['woopra_cart_wishlist_name'] = Mage::getSingleton('core/session')->getData('woopra_cart_wishlist_name', true);
            $data['woopra_cart_wishlist_sku'] = Mage::getSingleton('core/session')->getData('woopra_cart_wishlist_sku', true);
            $data['woopra_cart_wishlist_price'] = Mage::getSingleton('core/session')->getData('woopra_cart_wishlist_price', true);

            //Site Search
            if (Mage::helper('woopra')->getCatalogSearch() != NULL) {
                $data['woopra_search_name'] = Mage::helper('woopra')->getCatalogSearch();
                $data['woopra_search_trigger'] = Mage::getSingleton('core/session')->getData('woopra_search_trigger', true);
                $data['woopra_search_keywords'] = Mage::getSingleton('core/session')->getData('woopra_search_keywords', true);
            }

            //Create Account
            if (Mage::helper('woopra')->getCustomerCreateAccount() != NULL) {
                $data['woopra_create_account_trigger'] = Mage::getSingleton('core/session')->getData('woopra_create_account_trigger', true);
            }

            //Create Account Success
            if (Mage::helper('woopra')->getCustomerCreateAccountSuccess() != NULL) {
                $data['woopra_create_account_success_trigger'] = Mage::getSingleton('core/session')->getData('woopra_create_account_success_trigger', true);
            }

            //Checkout Trigger
            if (Mage::helper('woopra')->getCheckoutBillingAddress() != NULL) {
                $data['woopra_checkout_trigger'] = Mage::getSingleton('core/session')->getData('woopra_checkout_trigger', true);
            }

            //Checkout Success
            if (Mage::helper('woopra')->getCheckoutSuccess() != NULL) {
                $data['woopra_checkout_payment_method'] = Mage::getSingleton('core/session')->getData('woopra_checkout_payment_method', true);
                $data['woopra_checkout_payment_cc_type'] = Mage::getSingleton('core/session')->getData('woopra_checkout_payment_cc_type', true);
                $data['woopra_checkout_success_trigger'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_trigger', true);
                $data['woopra_checkout_success_coupon_code'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_coupon_code', true);
                $data['woopra_checkout_success_discount_amount'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_discount_amount', true);
                $data['woopra_checkout_success_order_id'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_order_id', true);
                $data['woopra_checkout_success_order_subtotal'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_order_subtotal', true);
                $data['woopra_checkout_success_order_total'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_order_total', true);
                $data['woopra_checkout_success_order_weight'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_order_weight', true);
                $data['woopra_checkout_success_shipping_amount'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_shipping_amount', true);
                $data['woopra_checkout_success_shipping_description'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_shipping_description', true);
                $data['woopra_checkout_success_total_items_ordered'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_total_items_ordered', true);
                $data['woopra_checkout_success_profit'] = Mage::getSingleton('core/session')->getData('woopra_checkout_success_profit', true);
            }

            //CMS No Route
            if (Mage::helper('woopra')->getCmsNoRoute() != NULL) {
                $data['woopra_cms_noroute_trigger'] = Mage::getSingleton('core/session')->getData('woopra_cms_noroute_trigger', true);
                $data['woopra_cms_noroute_path'] = Mage::getSingleton('core/session')->getData('woopra_cms_noroute_path', true);
                $data['woopra_cms_noroute_url'] = Mage::helper('core/url')->getCurrentUrl();
            }

            //Coupon Code
            if (Mage::helper('woopra')->getCouponCodeAdded() != NULL) {
                $data['woopra_coupon_code_trigger'] = Mage::getSingleton('core/session')->getData('woopra_coupon_code_trigger', true);
                $data['woopra_coupon_code_status'] = Mage::getSingleton('core/session')->getData('woopra_coupon_code_status', true);
                $data['woopra_coupon_code'] = Mage::getSingleton('core/session')->getData('woopra_coupon_code', true);
                $data['woopra_coupon_code_validity'] = Mage::getSingleton('core/session')->getData('woopra_coupon_code_validity', true);
                $data['woopra_coupon_code_active'] = Mage::getSingleton('core/session')->getData('woopra_coupon_code_active', true);
                $data['woopra_coupon_code_name'] = Mage::getSingleton('core/session')->getData('woopra_coupon_code_name', true);
            }

            //Login / Logout Trigger
            if (Mage::helper('woopra')->getCustomerLogin() != NULL) {
                $data['woopra_login_logout_trigger'] = Mage::getSingleton('core/session')->getData('woopra_login_logout_trigger', true);
                $data['woopra_login_logout_status'] = Mage::getSingleton('core/session')->getData('woopra_login_logout_status', true);
            }

            //Forgot Password
            if (Mage::helper('woopra')->getForgotPassword() != NULL) {
                $data['woopra_forgot_password_trigger'] = Mage::getSingleton('core/session')->getData('woopra_forgot_password_trigger', true);
                $data['woopra_forgot_password_email'] = Mage::getSingleton('core/session')->getData('woopra_forgot_password_email', true);
            }

            //Changed Password
            if (Mage::helper('woopra')->getChangedPassword() != NULL) {
                $data['woopra_password_changed_trigger'] = Mage::getSingleton('core/session')->getData('woopra_password_changed_trigger', true);
            }

            //Product Tag Added
            if (Mage::helper('woopra')->getProductTagAdded() != NULL) {
                $data['woopra_product_tag_added_trigger'] = Mage::getSingleton('core/session')->getData('woopra_product_tag_added_trigger', true);
                $data['woopra_product_tag_name'] = Mage::getSingleton('core/session')->getData('woopra_product_tag_name', true);
            }

            //Poll Vote
            if (Mage::helper('woopra')->getPollVote() != NULL) {
                $data['woopra_poll_vote_trigger'] = Mage::getSingleton('core/session')->getData('woopra_poll_vote_trigger', true);
                $data['woopra_poll_vote_title'] = Mage::getSingleton('core/session')->getData('woopra_poll_vote_title', true);
                $data['woopra_poll_vote_answer'] = Mage::getSingleton('core/session')->getData('woopra_poll_vote_answer', true);
            }

            //Product Review Posted
            if (Mage::helper('woopra')->getProductReviewRead() != NULL && Mage::getSingleton('core/session')->getData('woopra_product_review_trigger') == 1) {
                $data['woopra_cart_wishlist_status'] = 'product_review_posted';
                $data['woopra_product_review_trigger'] = Mage::getSingleton('core/session')->getData('woopra_product_review_trigger', true);
                $data['woopra_product_review_nickname'] = Mage::getSingleton('core/session')->getData('woopra_product_review_nickname', true);
                $data['woopra_product_review_title'] = Mage::getSingleton('core/session')->getData('woopra_product_review_title', true);
                $data['woopra_product_review_detail'] = Mage::getSingleton('core/session')->getData('woopra_product_review_detail', true);
            }

            //Estimate Post
            if (Mage::helper('woopra')->getEstimatePost() != NULL && Mage::getSingleton('core/session')->getData('woopra_estimate_post_trigger') == 1) {
                $data['woopra_estimate_post_trigger'] = Mage::getSingleton('core/session')->getData('woopra_estimate_post_trigger', true);
                $data['woopra_estimate_post_country'] = Mage::getSingleton('core/session')->getData('woopra_estimate_post_country', true);
                $data['woopra_estimate_post_state'] = Mage::getSingleton('core/session')->getData('woopra_estimate_post_state', true);
                $data['woopra_estimate_post_zip'] = Mage::getSingleton('core/session')->getData('woopra_estimate_post_zip', true);
            }
        }

        if(isset($data[$key])) {
            return $data[$key];
        } else {
            return null;
        }
    }
}
