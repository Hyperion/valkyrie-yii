
$(function() {
	Auction.initialize();
});

var Auction = {

	/**
	 * Character information.
	 */
	character: null,

	/**
	 * Current chosen auction house.
	 */
	faction: null,

	/**
	 * The current page you are on.
	 */
	page: 'summary',

	/**
	 * AH status vars.
	 */
	status: {
		hardLogin: false,
		wowRemote: false
	},

	/**
	 * Initialize parts.
	 *
	 * @constructor
	 */
	initialize: function() {
		Auction.loadMoney();
		Auction.pullMail();

		if (Auction.page == 'bids' || Auction.page == 'auctions')
			Auction.initSections();

		Core.fixTableHeaders('.table');
	},

	/**
	 * Open up the bid dialog.
	 *
	 * @param id
	 * @param minBid
	 */
	openBid: function(id, minBid) {
		Auction.openDialog(id, 'bid', function() {
			Auction.bid(id, this);
		});

		var money = Auction.formatMoney(minBid);

		$('#auction-dialog-'+ id +' input[name="gold"]').val(money.gold);
        $('#auction-dialog-'+ id +' input[name="silver"]').val(money.silver);
        $('#auction-dialog-'+ id +' input[name="copper"]').val(money.copper);

		return false;
	},

	/**
	 * Bid on an item.
     *
     * @param id
	 * @param button
	 */
	bid: function(id, button) {
		var gold	= $('#auction-dialog-'+ id +' input[name="gold"]').val();
		var silver	= $('#auction-dialog-'+ id +' input[name="silver"]').val();
		var copper	= $('#auction-dialog-'+ id +' input[name="copper"]').val();

		$.ajax({
            url: 'bid',
            data: {
                auc: id,
                money: Auction.deformatMoney(gold, silver, copper),
				xtoken: Cookie.read('xstoken')
            },
            dataType: 'json',
            type: 'POST',
            success: function(data) {
				if (data.error) {
					Auction.handleError(data, id);

					if (data.error.code == 1002 || data.error.code == 1004) {
						window.setTimeout(function() {
							Auction.closeDialog(id, true, function() {
								Auction.collapse('bids-active');
							});
						}, 3000);
					}

				} else {
					if (Auction.page == 'browse')
						Auction.increment('total-bids');

					if (data.item.buyout) {
                        Auction.toast('won');
                        Auction.wonItemCache[data.item.auctionId] = true;

						if (Auction.page == 'bids') {
							Auction.increment('total-bids-won');
							Auction.decrement('total-bids-active');
						}
                    } else {
                        Auction.toast('bid');
                    }

					Auction.updateMoney(data.item.currentBid, '-');
					
					$('#auction-'+ id)
						.find('.price-bid .icon-gold').html(gold).end()
                    	.find('.price-bid .icon-silver').html(silver).end()
                    	.find('.price-bid .icon-copper').html(copper).end()
						.find('.status').html('').end()
						.find('.options .ah-button').addClass('disabled').removeAttr('onclick').end();

					Auction.closeDialog(id, false, function() {
						Auction.collapse('bids-active');
					});
				}

                // Transaction
                if (data.transactions)
                    Auction.alertTransaction(data.transactions);
			}
		});

		return false;
	},

	/**
	 * Open up the buyout dialog.
	 *
	 * @param id
	 * @param buyout
	 */
	openBuyout: function(id, buyout) {
		Auction.openDialog(id, 'buyout', function() {
			Auction.buyout(id, buyout, this);
		});

		var money = Auction.formatMoney(buyout);
		
		$('#auction-dialog-'+ id +' .icon-gold').html(money.gold.toString());
        $('#auction-dialog-'+ id +' .icon-silver').html(money.silver.toString());
        $('#auction-dialog-'+ id +' .icon-copper').html(money.copper.toString());

		return false;
	},

	/**
	 * Buyout an item.
     *
	 * @param id
	 * @param buyout
	 * @param button
	 */
	buyout: function(id, buyout, button) {
		$.ajax({
			url: 'bid',
			data: {
                auc: id,
                money: buyout,
				xtoken: Cookie.read('xstoken')
            },
			dataType: 'json',
			type: 'POST',
			success: function(data) {
				if (data.error) {
					Auction.handleError(data, id);

					if (data.error.code == 1002 || data.error.code == 1004) {
						window.setTimeout(function() {
							Auction.closeDialog(id, true, function() {
								Auction.collapse('bids-active');
							});
						}, 3000);
					}

				} else {
					Auction.toast('won');
                    Auction.updateMoney(buyout, '-');
					Auction.wonItemCache[data.item.auctionId] = true;

					if (Auction.page == 'browse') {
						Auction.increment('total-bids');
					} else {
						Auction.increment('total-bids-won');
						Auction.decrement('total-bids-active');
					}
					
					Auction.closeDialog(id, true, function() {
						Auction.collapse('bids-active')
					});
				}
			}
		});
		
		return false;
	},

	/**
	 * Open up the cancel dialog.
	 *
	 * @param id
	 */
	openCancel: function(id) {
		Auction.openDialog(id, 'cancel', function() {
			Auction.cancel(id, this);
		});

		return false;
	},

	/**
	 * Send the call to cancel the auction.
     *
     * @param id
	 * @param button
	 */
	cancel: function(id, button) {
		$.ajax({
			url: 'cancel',
			data: {
                auc: id,
				xtoken: Cookie.read('xtoken')
            },
			dataType: 'json',
			type: 'POST',
			success: function(data) {
				if (data.error) {
					Auction.handleError(data, id);

					if (data.error.code == 1002 || data.error.code == 1004) {
						window.setTimeout(function() {
							Auction.closeDialog(id, true, function() {
								Auction.collapse('auctions-active');
							});
						}, 3000);
					}

				} else {
					Auction.toast('cancelled');
					Auction.decrement('total-auctions');

					if (Auction.page == 'auctions') {
						Auction.decrement('total-auctions-active');
						Auction.increment('total-auctions-ended');
					}

					Auction.closeDialog(id, true, function() {
						Auction.collapse('auctions-active');
					});
				}
			}
		});
		
		return false;
	},

	/**
	 * The last ID of the opened dialog box.
	 */
	lastDialog: null,

	/**
     * An key/value object of re-usable dialog messages.
     */
	dialogMsgs: {},

	/**
	 * Open up the action dialog.
	 *
	 * @param id
	 * @param type
	 * @param callback
	 */
	openDialog: function(id, type, callback) {
		if (Auction.lastDialog)
			Auction.closeDialog(Auction.lastDialog);

		var row = $('#auction-'+ id);
		var dialog = $('#template-dialog').clone();
		var action = $('#template-'+ type).clone();

		// Setup row
		row.addClass('selected');
		row.find('.options .ah-button').addClass('locked');

		// Setup action
		action.removeAttr('id');
		action.find('.ui-button').click(callback);

		// Clone dialog
		dialog.attr('id', 'auction-dialog-'+ id).appendTo('body').css({
			top: (row.offset().top - 5),
			left: (row.offset().left - 5)
		});

		dialog.find('.close').click(function() {
			Auction.closeDialog(id);
		});

		dialog.find('.inner').append(action).css('width', row.outerWidth());
		dialog.find('.inner .row').css('height', (row.outerHeight() - 1));

		// Slide down action bar
		action.show();
		row.find('td').css('padding-bottom', (dialog.find('.bar').outerHeight() + 5));

		// Save last id
		Auction.lastDialog = id;
	},

	/**
	 * Remove the dialog and reset the base row.
	 *
	 * @param id
	 * @param remove
	 * @param callback
	 */
	closeDialog: function(id, remove, callback) {
		$('#auction-'+ id)
			.removeClass('selected')
			.find('td')
				.removeAttr('style')
			.end()
			.find('.options .ah-button')
				.removeClass('locked')
			.end();
				
		$('#auction-dialog-'+ id).remove();

		if (remove) {
			$('#auction-'+ id).fadeOut('fast', function() {
				$(this).remove();

				if (Core.isCallback(callback))
					callback();
			});
		}
	},

	/**
	 * Handle a response error by setting certain data and displaying an error message.
	 *
	 * @param data
	 * @param id
	 * @param returnError
	 */
	handleError: function(data, id, returnError) {
		if (data.error.code == 10008) {
            data.transactions.resetMillis = data.transactions.resetMillis || '';

            var date = new Date(data.transactions.resetMillis);
            data.error.message = data.error.message.replace('[time]', date.toUTCString());
        }

		if (data.error.code == 10005 && Auction.status.wowRemote) {
			window.setTimeout(function() {
				Login.openOrRedirect();
			}, 1000);
		}

		if (returnError)
			return data.error.message;

		if (id)
			$('#auction-dialog-'+ id +' .bar').addClass('error').html(data.error.message);
	},

	/**
	 * Collapse the table header if the table is empty.
	 *
	 * @param target
	 */
	collapse: function(target) {
		var panel = $('#'+ target);

		if (panel.length <= 0)
			return;
		
		if (panel.find('tbody tr').length <= 0) {
			panel.find('.table').remove();
			panel.find('.table-bar').addClass('bar-closed bar-disabled').removeAttr('onclick');
			panel.find('.table-bar .toggler span:not(.tip)').html('0');
		}
	},

	/**
	 * The current money total.
	 */
	money: 0,

	/**
	 * Claim money from an auction. Based on mail IDs or auction ID.
	 *
	 * @param id
	 * @param mail_ids
	 * @param callback
	 */
	claimMoney: function(id, mail_ids, callback) {
		var data = {};
		
		if (mail_ids && mail_ids.length > 0)
			data.mailIds = mail_ids.join(',');
        else
            data.auc = id;

		if (!callback) {
			callback = function(data) {
				if (data.error) {
					if (data.error.code == 10005)
						Login.openOrRedirect();
					else if (data.error.code == 10006)
						Auction.toast('subscription');
					else
						Auction.toast('interrupted');
				}

				if (data.claimedMail) {
					Auction.updateMoney(data.claimedMail.moneyObtained, '+');
					Auction.toast('claim');
				
					$('#auction-'+ id).fadeOut('fast', function() {
						$(this).remove();

						if (Auction.page == 'bids') {
							Auction.collapse('bids-lost');
							Auction.decrement('total-bids');
							Auction.decrement('total-bids-lost');
						} else {
							Auction.collapse('auctions-sold');
							Auction.decrement('total-auctions');
							Auction.decrement('total-auctions-lost');
						}
					});
				}
			};
		}

		$.ajax({
			url: 'takeMoney',
			data: data,
			dataType: 'json',
			type: 'POST',
			success: callback
		});
	},

	/**
	 * Claim all money by gathering the mail IDs.
	 *
	 * @param target
	 * @param type
	 * @param button
	 */
	claimAllMoney: function(target, type, button) {
		var panel = $('#'+ target);
		var ids = panel.find('.mail-id');
		var mail = [];

		if (ids.length > 0) {
			for (var i = 0; i < ids.length; ++i) {
				mail[i] = ids[i].value;
			}

			Auction.claimMoney(null, mail, function(data) {
				if (data.error) {
					if (data.error.code == 10005)
						Login.openOrRedirect();
					else if (data.error.code == 10006)
						Auction.toast('subscription');
					else
						Auction.toast('interrupted');
				}
				
				if (data.claimedMail) {
					Auction.updateMoney(data.claimedMail.moneyObtained, '+');
					Auction.toast('claim');
				
					panel.find('tbody tr:not(.pending)').fadeOut('fast', function() {
						$(this).remove();

						if (type == 'bids') {
							Auction.collapse('bids-lost');
							Auction.decrement('total-bids', mail.length);
							Auction.decrement('total-bids-lost', mail.length);
						} else {
							Auction.collapse('auctions-sold');
							Auction.decrement('total-auctions', mail.length);
							Auction.decrement('total-auctions-sold', mail.length);
						}
					});
				}
			});
		}
	},

	/**
	 * Get your current chars total money.
	 */
	loadMoney: function() {
		$.ajax({
			url: 'money',
			dataType: 'json',
			type: 'POST',
			success: function(data) {
				if (data.money) {
				Auction.money = data.money;
				Auction.updateMoney(data.money, false);
				} else {
					$('#money')
						.find('span').hide().end()
						.find('.in-game').show();
				}

				if (data.character) {
					Auction.character = data.character;
					Auction.character.realm = $('.realm-battlegroup .realm').html();
				}

				if (data.AH)
					Auction.faction = data.AH.toLowerCase();
			}
		});
	},

	/**
	 * Update the static money.
     *
	 * @param value
	 * @param mode
	 */
	updateMoney: function(value, mode) {
		if (mode)
			value = (mode == '+') ? Math.round(Auction.money + value) : Math.round(Auction.money - value);

		if (value < 0)
			value = 0;

		var amount = Auction.formatMoney(value);

		$('#money .icon-gold').html(amount.gold.toString());
		$('#money .icon-silver').html(amount.silver.toString());
		$('#money .icon-copper').html(amount.copper.toString());

		Auction.money = value;
	},

	/**
	 * Format a money amount into its 3 parts.
     *
	 * @param amount
	 * @return obj
	 */
	formatMoney: function(amount) {
		var gold = Math.floor(amount / 10000);
		var silver = Math.floor((amount - (gold * 10000)) / 100);
		var copper = Math.floor((amount - (gold * 10000)) - (silver * 100));

		if (!silver) silver = 0;
		if (!copper) copper = 0;
		if (!gold) 	 gold = 0;

		return {
			gold: gold,
			silver: silver,
			copper: copper
		};
	},

	/**
	 * Format 3 parts into a single money value.
     *
	 * @param gold
	 * @param silver
	 * @param copper
	 * @return int
	 */
	deformatMoney: function(gold, silver, copper) {
		gold = Math.round(gold);
		silver = Math.round(silver);
		copper = Math.round(copper);

		var total = (((gold * 100) * 100) + (silver * 100) + (copper * 1));

		if (!total || isNaN(total))
            total = 0;

		return total;
	},

	/**
     * An key/value object of re-usable toast messages.
     */
    toasts: {},

	/**
	 * Pop open the toast.
	 *
	 * @param key
	 * @param timer
	 * @param text
	 */
	toast: function(key, timer, text) {
		if (Auction.toasts[key]) {
			var options = {},
				content = Auction.toasts[key],
				timer = timer || 3000;
			
			options.timer = timer;

			switch (key) {
				case 'bid':
				case 'outbid':
				case 'won':
					options.onClick = function() {
						window.location.href = 'bids';
					};
				break;
				case 'sold':
				case 'cancelled':
				case 'expired':
				case 'created':
				case 'total':
					options.onClick = function() {
						window.location.href = 'auctions';
					};
				break;
			}

			if (text)
				content = Core.msg(content, text);

			Toast.show(content, options);
		}
	},

	/**
     * Transaction data.
     */
    transactions: {
        firstWarning: false,
        secondWarning: false,
        totalLeft: null,
        maxLimit: 200,
        maxBatch: 20
    },

	/**
     * Display remaining transaction data.
     *
     * @param data
     */
    alertTransaction: function(data) {
        var numLeft = Auction.transactions.totalLeft = data.numLeft;
        var first = Auction.transactions.maxBatch;
        var second = Auction.transactions.maxBatch / 2;

        if (numLeft <= 0) {
            Auction.toast('transactionMax', false)

        } else if (numLeft <= 5) {
            Auction.toast('transaction', 5000, numLeft);

        } else if (Auction.transactions.firstWarning == false && numLeft <= first && numLeft >= (second + 1)) {
            Auction.toast('transaction', 5000, numLeft);
            Auction.transactions.firstWarning = true;

        } else if (Auction.transactions.secondWarning == false && numLeft <= second && numLeft >= 6) {
            Auction.toast('transaction', 5000, numLeft);
            Auction.transactions.secondWarning = true;

        }
    },

	/**
	 * Open and close the sections and save their state to a cookie.
	 *
	 * @param object
	 * @param section
	 */
	toggleSection: function(node, section) {
		node = $(node);
		var table = $('#'+ section +' .table');
		var isClosed = node.hasClass('bar-closed');

		// Get info from cookie
		var cookie = Cookie.read('wow.auction.sections');
		var sections = [];

		if (cookie) {
			cookie = Core.trimChar(cookie, ',');
			sections = cookie.split(',');
			var index = $.inArray(section, sections);

			if (isClosed && index >= 0)
				sections.splice(index, 1);
			else
				sections.push(section);
		} else {
			if (!isClosed)
				sections.push(section);
		}

		Cookie.create('wow.auction.sections', sections.join(','));

		// Toggle elements
		table.toggle();
		node.toggleClass('bar-closed');
		
		return false;
	},

	/**
	 * Close the sections if they exist within the cookie.
	 */
	initSections: function() {
		var cookie = Cookie.read('wow.auction.sections');

		if (cookie) {
			cookie = cookie.split(',');

			for (var i = 0; i <= (cookie.length - 1); ++i) {
				var node = $('#'+ cookie[i]);

				node.find('.table-bar').addClass('bar-closed');
				node.find('.table').hide();
			}
		}
	},

	/**
	 * Increase the values for a certain field.
     *
	 * @param id
	 * @param amount
	 */
	increment: function(id, amount) {
		var source = $('#'+ id),
			data = source.html();

		if (!amount) amount = 1;

        if (data) {
            var counter = parseInt(Core.numeric(data)) + amount;
			
            source.html(counter.toString());
        }
	},

	/**
	 * Decrease the values for a certain field.
     *
	 * @param id
	 * @param amount
	 */
	decrement: function(id, amount) {
		var source = $('#'+ id),
			data = source.html();

		if (!amount) amount = 1;
		
        if (data) {
            var counter = parseInt(Core.numeric(data)) - amount;

            if (counter < 0)
				counter = 0;

            source.html(counter.toString());
        }
	},

	/**
	 * Open up the dropdown menus within the table headers.
	 *
	 * @param target
	 * @param node
	 */
	openSubMenu: function(target, node) {
		$('#'+ target).toggle();
		$(node).toggleClass('opened');
	},

	/**
     * Add an entry here when we buyout items.
     * Won Auction alerts are supressed for items in this array.
     */
	wonItemCache: [],

	/**
     * A counter for the most recent mail that has been seen.
	 * Any mail with a larger ID triggers a mail alert.
     */
	checkedMail: 0,
	pullingMail: false,

	/**
     * Periodically pull for new mail notifications.
     */
	pullMail: function() {
		if (!Core.loggedIn || Auction.pullingMail)
			return;

		Auction.pullingMail = true;

		$.ajax({
			url: 'mail',
			data: {
                lastMailId: Auction.checkedMail ? Auction.checkedMail : 0,
				xtoken: Cookie.read('xstoken')
            },
			dataType: 'json',
			type: 'POST',
			success: function(data) {
				if (data.error) {
					Auction.handleError(data);
					return;
				}
				
				Auction.pullingMail = false;

				// Don't show alerts on the first scan of mail (it contains all results)
				var largest = 0,
					doAlert = false;

				if (Auction.checkedMail && Auction.checkedMail > 0) {
					doAlert = true;
					largest = Auction.checkedMail;
				}

				var threshold = largest;

				// Loop the mail
				if (data.mail.newMessages.length > 0) {
					var mail;

					for (var i = 0, l = data.mail.newMessages.length; i < l; ++i) {
						mail = data.mail.newMessages[i];

						if (mail.mailId < threshold)
							continue;
						
						largest = Math.max(largest, mail.mailId);

						if (doAlert) {
							switch (mail.mailType.toLowerCase()) {
								case 'expired':
									Auction.toast('expired');
								break;
								case 'won':
									if (Auction.wonItemCache[mail.auctionId])
										Auction.wonItemCache.splice(mail.auctionId, 1);
									else
										Auction.toast('won');
								break;
								case 'outbid':
									Auction.toast('outbid');
								break;
								case 'sold':
									Auction.toast('sold');
								break;
							}
						}
					}

					Auction.checkedMail = largest;
				}

                // Every 3 minutes
				window.setTimeout(function() {
                    Auction.pullMail();
                }, 180000);
			},
			error: function() {
				Auction.pullingMail = false;
				
				window.setTimeout(function() {
					Auction.pullMail();
				}, 30000);
			}
		});
	}

};