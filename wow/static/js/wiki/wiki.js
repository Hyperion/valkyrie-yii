
$(function() {
	Wiki.initialize();
});

var Wiki = {

	/**
	 * Related content object instances.
	 */
	related: {},

	/**
	 * URL of the page we are on.
	 */
	pageUrl: '',

	/**
	 * Currently active related tab.
	 */
	tab: '',

	/**
	 * Hash tag query params.
	 */
	query: {},

	/**
	 * Auto load the appropriate related tab.
	 *
	 * @constructor
	 */
	initialize: function() {
		var tabs = $('#related-tabs'),
			hash = Core.getHash();
			
		if (tabs.length <= 0)
			return;

		tabs.find('a').click(function() {
			return Wiki.loadRelated(this);
		});

		// Load comments tab
		if (hash && /^c-([0-9]+)$/.test(hash)) {
			Wiki.loadRelated($('#tab-comments'));

			if (!Core.isIE()) {
				Filter.reset();
				Core.scrollTo('#related-tabs');
			}

		// Else determine which tab
		} else {
			Filter.initialize(function(query) {
				Wiki.query = query;

				if (query.tab) {
					$('#tab-'+ query.tab).click();

					if (!Core.isIE())
						Core.scrollTo('#related-tabs');
				} else {
					tabs.find('a:first').click();
				}
			});
		}
	},

	/**
	 * Load related content pages. Save a cache of the content.
	 *
	 * @param node
	 * @param reload
	 * @return bool
	 */
	loadRelated: function(node, reload) {
		node = $(node);

		// Generate url key
		var key = node.data('key'),
			wrapper = $('#related-content');

		$('#related-tabs a').removeClass('tab-active');
		
		node.addClass('tab-active');
		wrapper.find('.related-content').hide();

		// Set filter
		if (Wiki.tab != '') {
			Filter.addParam('tab', key);
			Filter.addParam('page', '');
			Filter.applyQuery();
		}

		// Check cache
		if (Wiki.related[key] && !reload) {
			$('#related-'+ key).show();
			wrapper.removeClass('loading');

			Wiki.tab = key;
			Wiki.query = {};
			
			return false;
		}

		$.ajax({
			type: 'GET',
			url: Wiki.pageUrl + key,
			dataType: 'html',
			global: false,
			cache: (key != 'comments'),
			beforeSend: function() {
				wrapper.addClass('loading')
			},
			success: function(data) {
				if (data) {
					Wiki.tab = key;
					wrapper.removeClass('loading').append(data);
					Wiki.query = {};
					
					Core.fixTableHeaders('#related-'+ key);

					if (Core.isIE(6))
						$('#related-'+ key +' .png-fix').pngFix();
				}
			}
		});

		return false;
	},

	/**
	 * Callback for posting a comment, will reload the tab.
	 */
	postComment: function() {
		var tab = $('#tab-comments'),
			count = tab.find('em'),
			no = parseInt(count.html());

		if (!no || no <= 0)
			no = 0;

		count.html(no + 1);
			
		delete Wiki.related.comments;
		Wiki.loadRelated(tab, true);
	}

}

var WikiDirectory = {

	/**
	 * Current selected expansion.
	 */
	expansion: 0,

	/**
	 * Initialize the selected expansion.
	 *
	 * @param id
	 */
	initialize: function(id) {
		WikiDirectory.expansion = id;

		Filter.initialize(function(query) {
			if (query.expansion) {
				if (query.expansion > 3 || query.expansion < 0) {
					query.expansion = 0;
				}
				
				WikiDirectory.view($('#nav-'+ query.expansion), query.expansion);
			}
		});
	},

	/**
	 * Select an expansion.
	 *
	 * @param node
	 * @param id
	 */
	view: function(node, id) {
		node = $(node);
		node.parent().parent().find('a').removeClass('nav-active');
		node.addClass('nav-active');

		$('body')
			.removeClass('expansion-'+ WikiDirectory.expansion)
			.addClass('expansion-'+ id);

		$('#wiki')
			.find('.groups .group').hide().end()
			.find('#expansion-'+ id).show().end();

		Filter.addParam('expansion', id.toString());
		Filter.applyQuery();
		
		WikiDirectory.expansion = id;
	}

}

var WikiRelated = Class.extend({
	object: null,
	table: null,
	page: null,

	/**
	 * Initialize table and events.
	 *
	 * @param page
	 * @param config
	 */
	init: function(page, config) {
		this.page = page;
		this.object = $('#related-'+ page);

		if (this.object.find('table').length) {
			this.table = new Table(this.object, config);

			if (Wiki.tab == page && Wiki.query.page)
				this.table.paginate(Wiki.query.page);
		}

		// Advanced toggle
		this.object.find('.advanced-toggle').click($.proxy(this.toggleAdvanced, this));
		
		if (!this.table)
			return;

		// Setup filters
		var filters = this.object.find('.filters');

		if (filters.length) {
			Filter.bindInputs(filters, $.proxy(this.filter, this));

			filters
				.find('.filter-tabs a').click($.proxy(this.filterTabs, this)).end()
				//.find('.filter-class').change($.proxy(this.hideNonEquipment, this)).end()
				.find('.filter-name').bind('focus blur', this.inputBehavior);
		}
	},

	/**
	 * Run the filters no the table.
	 *
	 * @param data
	 */
	filter: function(data) {
		if (data.filter == 'column')
			this.table.filter('column', data.column, data.value);
		else
			this.table.filter(data.filter, data.name, data.value);
	},

	/**
	 * Filter down the table based on the selected tab.
	 *
	 * @param e
	 */
	filterTabs: function(e) {
		var node = $(e.currentTarget || e.target);

		this.object.find('.filter-tabs a').removeClass('tab-active');
		node.addClass('tab-active');

		this.table.filter(node.data('filter'), node.data('column'), node.data('value'), 'contains');
	},

	/**
	 * Auto select the hide non-equippable checkbox.
	 */
	hideNonEquipment: function() {
		var select = this.object.find('.filter-class'),
			equip = this.object.find('.filter-isEquippable'),
			value = select.val();

		if (equip.length && (equip.is(':checked') && value == '' || !equip.is(':checked') && value != '')) {
			equip.click();
			this.table.filter('class', 'isEquippable', 'is-equipment');
		}
	},

	/**
	 * Default behavior for input fields.
	 */
	inputBehavior: function() {
		if (this.value == this.title) {
			this.value = '';
			$(this).addClass('focus');

		} else if ($.trim(this.value) == '') {
			this.value = this.title;
			$(this).removeClass('focus');
		}
	}, 

	/**
	 * Open or close the advanced filters.
	 *
	 * @param e
	 */
	toggleAdvanced: function(e) {
		var node = $(e.currentTarget || e.target);

		if (node.hasClass('opened')) {
			node.removeClass('opened');
			this.object.find('.advanced-filters').hide();

		} else {
			node.addClass('opened');
			this.object.find('.advanced-filters').show();
		}
	}

});