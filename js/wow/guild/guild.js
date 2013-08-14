
$(function() {
	Guild.initialize();
});

var Guild = {

	/**
	 * Initialize dropdown and binds.
	 */
	initialize: function() {
		var dd = $('#roster-view');

		if (dd.length) {
			dd.show().dropdown({
				callback: Guild.changeView
			});

			// Setup filters
			Filter.initialize(function(params) {
				if (params.view)
					Roster.changeView(null, params.view);
			});
		}
		
		// Setup tooltips
		Tooltip.bind('#roster .img');
	},

	/**
	 * Change the table view.
	 *
	 * @param dropdown
	 * @param value
	 */
	changeView: function(dropdown, value) {
		var path = location.pathname.replace('/professions', '');

		if (value == 'professions')
			Core.goTo(path +'/professions');

		else if (value == 'guildActivity')
			Core.goTo(path +'?view=guildActivity&sort=lifetime&dir=d');

		else
			Core.goTo(path +'?view=achievementPoints&sort=achievements&dir=a');

		$('#filter-view').val(value);
	},

	/**
	 * Refresh the page without the query.
	 */
	reset: function() {
		location.href = location.pathname;
	},

	/**
	 * Setup the dropdown.
	 *
	 * @param id
	 */
	initDropdown: function(id) {
		$('#' + id + ' .current').click(function () {
			Toggle.open(this, "active", $(this).next())
		});
	},

	/**
	 * Filter down the results.
	 *
	 * @param parentElement
	 * @param tag
	 * @param filterString
	 * @param exclude
	 */
	filter: function (parentElement, tag, filterString, exclude) {
		var $list = $(parentElement),
			$filteredResult;

		if(filterString == 'all') {
			$filteredResult  = $list.find(tag);
		} else if (filterString == 'locked') {
			$filteredResult  = $list.find("." + filterString)
		} else {
			$filteredResult  = $list.find(tag).not(".locked")
		}

		$list.fadeOut(100, function () {
			$list.find(tag).hide();
			$filteredResult.not(".no-results").show();
			$list.fadeIn(800);
		})
	}
	
};