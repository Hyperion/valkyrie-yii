$(document).ready(function() {
	Lobby.loadPaymentInfo();
    Lobby.loadSecurityInfo();
	Lobby.loadGameAccounts();
	Lobby.bindListLinks();
	Lobby.updateListLinks();
	Lobby.localizeTime();
});

var Lobby = {
    /*
     * Sends e-mail verification to server, shows confirmation box
     */
    sendEmailVerification: function(url) {
        $.ajax({
            type: "POST",
            url: url,
			beforeSend: function() {
                $("#email-sent-loading").hide();
				$("#email-sent-wait").show();
			},
            success: function() {
                $("#email-sent-wait").fadeOut(250, function() {
					$("#email-sent-success").fadeIn(250);
				});
            },
            error: function() {
                $("#email-sent-wait").fadeOut(250, function() {
					$("#email-sent-error").fadeIn(250);
				});
            }
        });
    },

    closeGameList: function(node, target) {
        target = $('#'+ target);
        node = $(node);

		target.slideUp(0);
		node.removeClass('opened').addClass('closed');

        return false;
    },

    toggleGameList: function(node, target) {
		var targetElement = $('#' + target),
       		nodeElement = $(node);

        if (targetElement.is(':visible')) {
			Cookie.create('bam.' + target,'closed',{ expires: 336 });
            (!Core.isIE(6) && !Core.isIE(7)) ? targetElement.slideUp() : targetElement.toggle();
            nodeElement.removeClass('opened').addClass('closed');
        } else {
			Cookie.erase('bam.' + target);
            (!Core.isIE(6) && !Core.isIE(7)) ? targetElement.slideDown() : targetElement.toggle();
            nodeElement.removeClass('closed').addClass('opened');
        }

        return false;
    },

    bindListLinks: function() {
        $("#games-list ul li a").unbind('click').bind({
			'click': function(e) {
				if (!$(this).hasClass('info'))
					e.stopPropagation();
			}
        });
        $("#games-list ul li").unbind('click').bind({
			'click': function() {
				if (!$(this).hasClass('info')) {
					Lobby.createDashboardLink(this);
				}
			}
        });

		$('.games-title').bind({
			'click': function() {
				return Lobby.toggleGameList(this, $(this).attr('rel'));
			}
		});
    },

	createDashboardLink: function(target) {
		if ($(target).find('a').attr('href') !== undefined && $(target).find('a').attr('href') !== '') {
			document.location.href = $(target).find('a').attr('href');
		}
	},

	updateListLinks: function() {
		if (Cookie.read('bam.game-list-s2')) {
			Lobby.closeGameList($('.games-title[rel="game-list-s2"]'), 'game-list-s2');
		}
		if (Cookie.read('bam.game-list-wow')) {
			Lobby.closeGameList($('.games-title[rel="game-list-wow"]'), 'game-list-wow');
		}
		if (Cookie.read('bam.game-list-classic')) {
			Lobby.closeGameList($('.games-title[rel="game-list-classic"]'), 'game-list-classic');
		}
	},

    loadPaymentInfo: function() {
		var unloaded = $('#lobby-account .payment-box.unloaded');

		if (!unloaded.length) {
			return false;
		}

		var length = unloaded.length;
		var i = length - 1;

		if (i >= 0) { do {
			Lobby.getPaymentDetails($(unloaded[i]));
		} while (i--);}
    },

    loadSecurityInfo : function() {
        var unloaded = $('#lobby-account .security-box.unloaded');

		if (!unloaded.length) {
			return false;
		}

		var length = unloaded.length;
		var i = length - 1;

		if (i >= 0) { do {
			Lobby.getSecurityDetails($(unloaded[i]));
		} while (i--);}
    },

    lightLoadGameAccounts: function() {
		var unloaded = $('#games-list ul li.unloaded');
		var length = unloaded.length;
		var i = length - 1;

		if (i >= 0) { do {
			$(unloaded[i]).removeClass('disabled');
		} while (i--);}
    },

    loadGameAccounts: function() {
		var unloaded = $('#games-list ul li.unloaded');
		var length = unloaded.length;
		var i = length - 1;
		if (i >= 0) { do {
			var account = $(unloaded[i]).attr("id").split('::')[0],
				region = $(unloaded[i]).attr("id").split('::')[1];
			Lobby.getAccountDetails($(unloaded[i]), account, region);
		} while (i--);}
    },

    getSecurityDetails: function(div) {
         $.ajax({
			timeout: 60000,
            url: Core.staticUrl + '/data/phone-secure-status.html?_=' + new Date().getTime(),
			beforeSend: function() {
				$(div).removeClass('unloaded').addClass('loading');
			},
            success: function(msg) {
                if (msg.callInNumber !== undefined) {
                    if (msg.status === 'pending') {
						console.log('ok');
                        $('#ps-user-number').html(msg.phoneNumber);
                        $('#ps-enroll-number').html(SecurityStrings.PENDING.part1 + ' ' + msg.callInNumber + ' ' + SecurityStrings.PENDING.part2);
                        $(this).removeClass('loading').removeClass('disabled');
                        $('#ps-edit').html(SecurityStrings.EDIT.cancel);
						$('#ps-edit').parent('span.edit').addClass('edit-block');
						$('#manage-security').remove();
                        $('#ps-status').show();
                    } else if (msg.status === 'active') {
                        $('#ps-user-number').html(msg.phoneNumber);
						$('#ps-enroll-number').remove();
                        $(this).removeClass('loading').removeClass('disabled');
                        $('#ps-edit').html(SecurityStrings.EDIT.remove);
						$('#manage-security').remove();
                        $('#ps-status').show();
                    }
                    $(div).animate({
                        opacity: 1
                    }, 250, function() {
                        $(this).removeClass('loading').removeClass('disabled');
                    });
                } else { // No Battle.net Dial-in Authenticator
					$(div).animate({
						opacity: 1
					}, 250, function() {
						$(this).removeClass('loading').removeClass('disabled');
					});
				}
            },
            error: function() {
				$(div).removeClass('loading').addClass('unavailable').animate({
					opacity: 1
				}, 250, function() {
					$(this).removeClass('disabled').addClass('unavailable');
				});
				$(div).html('<h4 class="subcategory">' + SecurityStrings.ERROR.title + '</h4><p>' + SecurityStrings.ERROR.desc + '</p>');
            }
		});
    },

    getPaymentDetails: function(div) {
        $.ajax({
			timeout: 60000,
            url: Core.staticUrl + '/data/payment-details.html?_=' + new Date().getTime(),
			beforeSend: function() {
				$(div).removeClass('unloaded').addClass('loading');
			},
            success: function(msg) {
				if (msg !== '') {
					var paymentInfo = '';
					if (msg.status === 'GOOD') {
						if (msg.paymentType === 'CREDIT_CARD') {
							paymentInfo = '<h4 class="subcategory">' + PaymentStrings.GOOD.CREDIT_CARD.title + '</h4><p>';
							if (msg.label !== '') {
								paymentInfo +=  msg.label + ' ';
							} else {
								paymentInfo += PaymentStrings.GOOD.CREDIT_CARD.label;
							}
							paymentInfo += '(' + PaymentStrings.GOOD.CREDIT_CARD.details.replace('PAYMENTSUBTYPE',msg.paymentSubType).replace('XXX',msg.number) + ') <span class="edit">[<a href="' + Core.staticUrl + '/management/edit-payment-method.html?id=' + msg.id + '">' + PaymentStrings.GOOD.CREDIT_CARD.button + '</a>]</span> ';
							paymentInfo += ' <span class="help-note" onmouseover="Tooltip.show(this, \'' + PaymentStrings.GOOD.desc + '\');"><img height="16" width="16" src="' + Core.staticUrl + '/images/icons/tooltip-help.gif" alt="?" /></span></p>';
						} else if (msg.paymentType === 'DIRECT_DEBIT') {
							paymentInfo = '<h4 class="subcategory">' + PaymentStrings.GOOD.DIRECT_DEBIT.title + '</h4><p>';
							if (msg.label !== '') {
								paymentInfo +=  msg.label + ' (' + PaymentStrings.GOOD.DIRECT_DEBIT.label + ')';
							} else {
								paymentInfo += PaymentStrings.GOOD.DIRECT_DEBIT.label;
							}
							paymentInfo += ' <span class="edit">[<a href="' + Core.staticUrl + '/management/edit-payment-method.html?id=' + msg.id + '">' + PaymentStrings.GOOD.DIRECT_DEBIT.button + '</a>]</span>';
							paymentInfo += ' <span class="help-note" onmouseover="Tooltip.show(this, \'' + PaymentStrings.GOOD.desc + '\');"><img height="16" width="16" src="' + Core.staticUrl + '/images/icons/tooltip-help.gif" alt="?" /></span></p>';
						}
						$(div).removeClass('loading').animate({
							opacity: 1
						}, 250, function() {
							$(this).removeClass('disabled');
							$(div).html(paymentInfo);
						});
					} else {
						paymentInfo = '<p><em>' + PaymentStrings.NONE.desc + '</em>';
						paymentInfo += '<br /><em><a href="' + Core.staticUrl + '/management/wallet.html">' + PaymentStrings.NONE.button + '</a></em></p>';
						$(div).removeClass('loading').removeClass('disabled');
						$(div).html(paymentInfo);
					}
				} else {
					$(div).removeClass('loading').addClass('unavailable').animate({
						opacity: 1
					}, 250, function() {
						$(this).removeClass('disabled');
					});
					$(div).html('<h4 class="subcategory">' + PaymentStrings.ERROR.title + '</h4><p>' + PaymentStrings.ERROR.desc + '</p>');
				}
			},
            error: function() {
				$(div).removeClass('loading').addClass('unavailable').animate({
					opacity: 1
				}, 250, function() {
					$(this).removeClass('disabled').addClass('unavailable');
				});
				$(div).html('<h4 class="subcategory">' + PaymentStrings.ERROR.title + '</h4><p>' + PaymentStrings.ERROR.desc + '</p>');
            }
		});
	},

    getAccountDetails: function(li, account, region) {
        $.ajax({
			timeout: 60000,
            url: Core.staticUrl + '/data/wow-license-details.html?accountName=' + account + '&region=' + region + '&_=' + new Date().getTime(),
			beforeSend: function() {
				$(li).removeClass('unloaded').addClass('loading');
			},
            success: function(msg) {
				if (msg !== '' && msg.status !== 'ERROR') {
					var icon = '';
					var boxLevel = 0;
					var boxID = '';
					if (msg.gameRegion!="CN" && msg.trial && msg.trialDaysLeft === 0 && msg.boxLevel > 0) {
						boxLevel = msg.boxLevel - 1;
						if (boxLevel > 0) {
							boxID = 'WOWX' + boxLevel;
						} else {
							boxID = 'WOWC';
						}
					} else {
						boxID = msg.gameId;
					}
					if (msg.gameId === 'WOW_UNKNOWN') {
						$(li).removeClass('loading').addClass('unavailable');
					} else {
						$(li).removeClass('loading').animate({
							opacity: 1
						}, 250, function() {
							$(this).removeClass('disabled');
						});
					}
					if (Promotion.enabled && msg.boxLevel < MaxBoxLevel[msg.gameId]) {
						$(li).addClass('promotion-target');
					}
					$(li).unbind('click').bind({
						'click': function() {
							Lobby.createDashboardLink(this);
						}
					});
					$(li).find('img').attr('src', '/account/local-common/images/game-icons/' + boxID.toLowerCase() + '-32.png');
					if (msg.gameId !== 'WOW_UNKNOWN') {
						$(li).find('a').text(GameId[boxID][0]);
					}
					if (msg.gameRegion !== region && msg.gameRegion !== 'NA') {
						$(li).find('.account-region').html(GameRegions[msg.gameRegion]);
					}
					if (msg.trial || msg.trialDaysLeft > 0) {
						var tip = '',
							label = ' <span class="account-edition">(' + IconTag['trial'] + ')</span>';
						if (msg.trialDaysLeft <= 0 && msg.trialMinutesLeft <= 0) {
							icon = '<span class="flag upgrade" onmouseover="Tooltip.show(this, \'' + IconTag['trialExpired'] + '\');"></span>';
						} else {
							if (msg.trialDaysLeft === 1) {
								tip = IconTag['trialSingular'];
							} else if (msg.trialMinutesLeft > 0){
								tip = IconTag['trialPluralMinutes'].replace("XXX", msg.trialMinutesLeft);

							} else {
								tip = IconTag['trialPlural'].replace("XXX", msg.trialDaysLeft);
							}
							icon = '<span class="flag trial" data-tooltip="'+ tip +'"></span>';
						}
					} else if (msg.boxLevel < MaxBoxLevel[msg.gameId]) {
						icon = '<span class="flag upgrade" data-tooltip="'+ IconTag['upgrade'] +'"></span>';
					}
					$(li).children('.game-icon').append(icon);
					$(li).find('.account-id').append(label);
				} else {
					$(li).removeClass('loading').addClass('unavailable').unbind().bind({
						'mouseover': function() {
							Tooltip.show(this, Maintenance.ERROR, {'location': 'mouse'});
						},
						'click': function() {
							return false;
						}
					}).find('a').attr('href', '#').css('cursor', 'default').unbind().bind({
						'click': function() {
							return false;
						}
					});
				}
            },
            error: function() {
				$(li).removeClass('loading').addClass('unavailable').unbind().bind({
					'mouseover': function() {
						Tooltip.show(this, Maintenance.ERROR, {'location': 'mouse'});
					},
					'click': function() {
						return false;
					}
				}).find('a').attr('href', '#').css('cursor', 'default').unbind().bind({
					'click': function() {
						return false;
					}
				});
            }
        });
    },
	localizeTime: function() {
		var timeHolders = $(".time-localization");
		if (!timeHolders.length) {
			return false;
		}
		var format = 'dd-MM-yyyy HH:mm',
			locale = (Core.buildRegion === 'eu' && Core.locale === 'en-us') ? 'en-gb' : Core.locale;
		switch (locale) {
			default:
			case 'cs-cz':
			case 'de-de':
			case 'pl-pl':
				format = 'dd.MM.yyyy HH:mm';
				break;
			case 'en-us':
				format = 'MM/dd/yyyy hh:mm a';
				break;
			case 'en-gb':
			case 'es-es':
			case 'es-mx':
			case 'fr-fr':
			case 'pt-br':
			case 'it-it':
			case 'ru-ru':
				format = 'dd/MM/yyyy HH:mm';
				break;
			case 'en-sg':
				format = 'dd/MM/yyyy hh:mm a';
				break;
			case 'ja-ja':
			case 'ko-kr':
				format = 'yyyy/MM/dd HH:mm';
				break;
			case 'zh-cn':
				format = 'yyyy年MM月dd日 HH:mm';
				break;
			case 'zh-tw':
				format = 'yyyy-MM-dd HH:mm';
				break;
		}
		timeHolders.each(function() {
			var el = $(this);
			var formated = Core.formatDatetime(format, el.text());
			el.text(formated ? formated : el.text());
		});
	}

};

function openAddTrial() {
		$("#freeWow").slideDown(1000);
}

$(document).ready(function (){
	openAddTrial();
});
