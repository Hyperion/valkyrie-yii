$(document).ready(function() {
	AddGame.initialize();
});

/**
 * Add game form.
 *
 * @copyright   2010, Blizzard Entertainment, Inc.
 * @class       AddGame
 * @example
 *
 *      AddGame.initialize();
 *
 */
var AddGame = {
	form: '',
	requiredAccountName: {},
	requiredAccountPass: {},
	submitButton: {},
	initialize: function() {
		AddGame.form = '#add-game';
		AddGame.requiredAccountName = $(AddGame.form + ' #gameAcountName');
		AddGame.requiredAccountPass = $(AddGame.form + ' #gameAcountPass');
		AddGame.submitButton = $('#add-game-submit');

		if (!AddGame.form.length) {
			return false;
		}

		$(AddGame.form + ' .required input').bind({
			'keyup': function() {
				if (AddGame.requiredAccountName.val().length >= 1 && AddGame.requiredAccountPass.val().length >= 1) {
					setTimeout(function() {
						UI.wakeButton(AddGame.submitButton);
					}, 250);
				} else {
					UI.freezeButton(AddGame.submitButton);
				}
			},
			'blur': function() {
				if (AddGame.requiredAccountName.val().length >= 1 && AddGame.requiredAccountPass.val().length >= 1) {
					UI.wakeButton(AddGame.submitButton);
				} else {
					UI.freezeButton(AddGame.submitButton);
				}
			}
		});
	}
};
