function StoreCheckoutBillingAddressPage(id)
{
	this.container = document.getElementById('billing_address_form');
	this.list = document.getElementsByName('billing_address_list');
	this.list_new = document.getElementById('billing_address_list_new');

	StoreCheckoutBillingAddressPage.superclass.constructor.call(this, id);
}

YAHOO.lang.extend(StoreCheckoutBillingAddressPage, StoreCheckoutAddressPage, {

getFieldNames: function()
{
	return [
		'billing_address_fullname',
		'billing_address_phone',
		'billing_address_company',
		'billing_address_line1',
		'billing_address_line2',
		'billing_address_city',
		'billing_address_provstate_flydown',
		'billing_address_provstate_entry',
		'billing_address_postalcode',
		'billing_address_country'
	];
}

});
