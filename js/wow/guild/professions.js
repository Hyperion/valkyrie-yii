
$(function() {
	Professions.initialize();
})

var Professions = {

	/**
	 * Primary table instance.
	 */
	table: null,

	/**
	 * Children table instances.
	 */
	tables: [],

	/**
	 * Initialize all binds and events on page load.
	 *
	 * @constructor
	 */
	initialize: function() {
		$("#professions th .sort-link").each(function() {
			var link = $(this),
				headers = link.parents("tr:first").children("th"),
				index = headers.index(link.parent()),
				method = link.hasClass("numeric") ? 'numeric': 'default';

			link.click(function() {
				$.each(Professions.tables, function() {
					this.sort(index, method);
				});
			});
		});

		// Setup tooltips
		Tooltip.bind('#profession-tables .img');

		// Setup filters
		Filter.bindInputs('#roster-form', Professions.bindFilters);
		Filter.initialize(Professions.applyFilters);
	},

	/**
	 * Apply filters on page load if they exist.
	 *
	 * @param query
	 * @param total
	 */
	applyFilters: function(query, total) {
		var levelFiltered = false,
			columns = [];

		$.each(query, function(key, value) {
			if (key == 'view')
				return true;

			if ((key == 'minSkill' || key == 'maxSkill' || key == 'onlyMaxSkill') && !levelFiltered) {
				levelFiltered = true;

				if (key == 'onlyMaxSkill') {
					columns.push([4, 525, 'exact']);

					$('#filter-onlyMaxSkill')[0].checked = true;
					$('#filter-minSkill, #filter-maxSkill').attr('disabled', 'disabled').val(525);

				} else {
					columns.push([4, [
						query.minSkill || 1,
						query.maxSkill || 525
					], 'range']);
				}

			} else if (key == 'skill') {
				$('#profession-tables .parentTable').hide();
				$('#professions-'+ value).show();

			} else if (key == 'name') {
				columns.push([0, value, 'startsWith']);
			}

			$('#filter-'+ key).val(value);
		});

		$.each(Professions.tables, function() {
			this.filterBatch({
				columns: columns
			});
		});

		Professions.updateTotals((total === 0));
	},

	/**
	 * Apply filter input binds.
	 *
	 * @param options
	 */
	bindFilters: function(options) {
		switch (options.name) {
			case 'name':
				options = Professions.filterName(options);
			break;
			case 'skill':
				options = Professions.filterSkill(options);
			break;
			case 'onlyMaxSkill':
				options = Professions.filterMaxSkill(options);
			break;
			default:
				options = Professions.filterSkillRange(options);
			break;
		}

		Professions.updateTotals();
		Filter.addParam(options.name, options.value);
		Filter.applyQuery();
	},

	/**
	 * Handle the max skill checkbox event.
	 *
	 * @param options
	 * @return obj
	 */
	filterMaxSkill: function(options) {
		if ($('#filter-onlyMaxSkill').is(':checked')) {
			$('#filter-minSkill, #filter-maxSkill').attr('disabled', 'disabled').val(525);
			
		} else {
			$('#filter-minSkill, #filter-maxSkill').each(function() {
				var self = $(this),
					value = !self.data('min') ? self.data('max') : self.data('min');

				self.removeAttr('disabled').val(value);
			});
		}

		$.each(Professions.tables, function() {
			this.filter('column', options.column, ((options.value == 'true') ? '525' : ''), 'exact');
		});

		return options;
	},

	/**
	 * Handles the filtering of player names.
	 *
	 * @params options
	 * @return obj
	 */
	filterName: function(options) {
		$.each(Professions.tables, function() {
			this.filter('column', options.column, options.value, 'startsWith');
		});
		
		return options;
	},

	/**
	 * Handles profession filtering.
	 *
	 * @param options
	 * @return obj
	 */
	filterSkill: function(options) {
		$('#professions-noResults').hide();

		if (options.value == '') {
			$("#profession-tables .parentTable").show();

		} else {
			$('#profession-tables .parentTable').hide();
			$("#professions-"+ options.value).show();
		}

		return options;
	},

	/**
	 * Handles inputs with min and max ranges.
	 *
	 * @param options
	 * @return obj
	 */
	filterSkillRange: function(options) {
		if ((options.value == "") || (options.range.type == 'max' && options.range.max > options.range.base))
			options.range.max = options.value = options.range.base;

		else if ((options.value == "") || (options.range.type == 'min' && options.range.min < options.range.base))
			options.range.min = options.value = options.range.base;

		$('#filter-'+ options.name).val(options.range[options.range.type]);

		$.each(Professions.tables, function() {
			this.filter('column', options.column, [options.range.min, options.range.max], 'range');
		});

		return options;
	},

	/**
	 * Reset the table and filters.
	 */
	reset: function() {
		Professions.table.reset();

		$.each(Professions.tables, function() {
			this.reset();
		})

		$('#profession-tables .parentTable').show();
		$('#filter-minSkill, #filter-maxSkill').removeAttr('disabled');
		$('#filter-onlyMaxSkill')[0].checked = false;

		Professions.updateTotals(true);
		Filter.resetInputs('#roster-form');
		Filter.reset();
	},

	/**
	 * Toggle open/close each row.
	 *
	 * @param sourceRow
	 */
	toggleSection: function (sourceRow) {
		var row = $(sourceRow);

		row.next().toggle().find("tr").not(".no-results").show();
		row.toggleClass("closed")
	},

	/**
	 * Update the totals within the bars each time professions is filtered.
	 *
	 * @param showAll
	 */
	updateTotals: function(showAll) {
		var noResults = true,
			skill = $('#filter-skill').val();

		$('#professions-noResults').hide();

		if (skill !== "") {
			var table = $('#professions-'+ skill);

			table.find('.table-bar .total').html(
				table.find('table tbody tr:visible').not('.no-results').length
			);

		} else {
			$('#profession-tables .parentTable').each(function() {
				var self = $(this),
					length = 0,
					isEmpty = self.find('.table-bar').hasClass('closed');

				self.show()
					.find('table tbody tr').each(function() {
						var tr = $(this);

						if (tr.css('display') != 'none' && !tr.hasClass('no-results'))
							length++;
					})
					.end()
					.find('.table-bar .total').html(length)
					.end();

				if (length > 0)
					noResults = false;
				else if (isEmpty && showAll)
					self.show();
				else
					self.hide();
			});

			if (noResults) {
				$('#professions-noResults').show();
				$('#profession-tables .parentTable').hide();
			}
		}
	}

};