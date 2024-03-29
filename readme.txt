=== Autonomos ===
Contributors: j.conti
Tags: autonomos, woocommerce, irpf, autónomos, equivalence surcharge, Equivalence, equivalencia,  recargo de equivalencia, recargo,  recargo por equivalencia
Requires at least: 4.0
Tested up to: 6.3
Stable tag: 2.0.0
WC requires at least: 7.2
WC tested up to: 8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Autonomos makes viable the use of WooCommerce by Spanish autonomos, and add tools for help them.

== Description ==

= Free version =

Autonomos is a plugin developed thinking in spanish Autonomos.

What can you do with Autonomos?

* Autonomos add the ability to substract the IRPF to Self Employed & Companies in the WooCommerce Checkout.
* Autonomos add the CIF / NIF / NIE field to the checkout page.
* Autonomos Add the ability to add product quantity to shop page & archive so buyers can add product quantity from Shop Page & Archive Page.
* Autonomos Add Equivalence Surcharge.

= Premium version =

* Compatible with Subscriptions WooCommerce extension.
* Compatible with WooCommerce Rest API so any externar software can access to all data.
* Comptible with PDF Invoices & Packing Slips for WooCommerce
* Compatible with [FacturaScripts](https://facturascripts.com/) Automatically create users and invoices in FacturaScripts from purchases in WooCommerce.

More information of Premium version [here](https://redsys.joseconti.com/product/woocommerce-autonomos-premium/)

== Installation ==


1. Upload `autonomos` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to WooCommerce > Settings > Autonomos and configure it.

== Frequently Asked Questions ==


== Screenshots ==

1. Autonomos Settings in WooCommerce
2. Checkout with user selector CIF / NIF / NIE and IRPF
3. Admin Order with IRPF
4. Quantity in Shop Page


== Changelog ==

= 2.0.0 =

* NEW: Compatibility with HPOS.
* NEW: Declared compatibility with WordPress 6.3.
* NEW: Declared compatibility with WooCommerce 8.0

= 1.4.2 =

* FIXED: Fixed an error saving IRPF


= 1.4.1 =

* FIXED: Fixed an error with DNI

= 1.4.0 =

* NEW: The DNI field at the Checkout is now mandatory if user type is freelance or enterprise.

= 1.3.0 =

* Added Equivalence Surcharge

= 1.2.0 =

* Added an option for redirect directly to checkout when a user add a product ( the shopping cart is skipped ).
* Added an option for add product quantity to shop page & archive so buyers can add product quantity from Shop Page & Archive Page
* Now, the % IRPF only has 50px in the admin settings.

= 1.1.0.2 =

* Unintentionally removed a return that caused a fatal error in the checkout.

= 1.1.0.1 =

* Fixed a directory name that caused that Subscription template not to load (premium version).

= 1.1.0 =

* Added compatibility with Subscriptions WooCommerce plugin (premium version).
* CIF / NIF / NIE fields now are shown in the users profile in WordPress administration.

= 1.0.2 =

* Now, IRPF is shown in the emails send by WooCommerce, in My Account and WooCommerce Orders list
* Added the field CIF / NIF / NIE in the checkout.
* Checkout fields rearranged in the checkout page.

= 1.0.1 =

* Fixed the calculation in the checkout due to a bug in WooCommerce

= 1.0 =

* First public release.



== Upgrade Notice ==