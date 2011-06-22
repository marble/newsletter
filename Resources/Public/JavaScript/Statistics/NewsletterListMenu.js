"use strict";

Ext.ns("Ext.ux.TYPO3.Newsletter.Statistics");

/**
 * @class Ext.ux.TYPO3.Newsletter.Statistics.NewsletterListMenu
 * @namespace Ext.ux.TYPO3.Newsletter.Statistics
 * @extends Ext.form.ComboBox
 *
 * Class for newsletter drop down menu
 *
 * $Id$
 */
Ext.ux.TYPO3.Newsletter.Statistics.NewsletterListMenu = Ext.extend(Ext.form.ComboBox, {

	initComponent: function() {
		
		var config = {
			id: 'newsletterListMenu',
			store: Ext.StoreMgr.get('Tx_Newsletter_Domain_Model_Newsletter'),
			displayField: 'fullTitle',
			valueField: '__identity',
			width: 400,
			mode: 'local',
			forceSelection: true,
			triggerAction: 'all',
			selectOnFocus: true,
			autoSelect: true,
			listeners: {
				'select' : this.onNewsletterSelected
			}
		};
		
		Ext.apply(this, config);
		Ext.ux.TYPO3.Newsletter.Statistics.NewsletterListMenu.superclass.initComponent.call(this);
	},

	/**
	 * When a newsletter is selected, we update the store representing the selected newsletter.
	 * TODO: there probably is a cleaner way to do this wihtout an intermediary store, but I couldn't find how to do yet
	 */
	onNewsletterSelected: function(combo, record, index) {
		var selectedNewsletter = {data: [record.data] };
		var selectedNewsletterStore = Ext.StoreMgr.get('Tx_Newsletter_Domain_Model_SelectedNewsletter');
		selectedNewsletterStore.loadData(selectedNewsletter);
	}
});

Ext.reg('Ext.ux.TYPO3.Newsletter.Statistics.NewsletterListMenu', Ext.ux.TYPO3.Newsletter.Statistics.NewsletterListMenu);