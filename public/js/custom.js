var csrfToken = $('meta[name="csrf-token"]').attr('content');
var leaderboardRefreshTimer = null;

/*-------------------------------------------------------------------------*/
// Page Load Functions
/*-------------------------------------------------------------------------*/
$(function() {
	// Quickly inspect a car
	$('.carPassedInspectionToggle').change(function() {
		//console.log('Toggle for contestant ' + $(this).data('id') + ' changed to: ' + $(this).prop('checked'));
		var $mySpinner = $(this).closest('td').find('.spinner');
		$mySpinner.removeClass('hidden');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': csrfToken
			}
		});

		$.ajax({
			type: 'PUT',
			url: '/contestants/' + $(this).data('id') + '/passed-inspection',
			data: {
				car_passed_inspection: $(this).prop('checked')
			},
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$mySpinner.addClass('hidden');
			}
		});
	});

	// Quickly change a car's number
	$('.quickNumberCar').change(function() {
		//console.log('Toggle for contestant ' + $(this).data('id') + ' changed to: ' + $(this).prop('checked'));
		var $mySpinner = $(this).closest('td').find('.spinner');
		$mySpinner.removeClass('hidden');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': csrfToken
			}
		});

		$.ajax({
			type: 'PUT',
			url: '/contestants/' + $(this).data('id') + '/car-number',
			data: {
				car_number: $(this).val()
			},
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$mySpinner.addClass('hidden');
			}
		});
	});

	// Quickly exclude a car
	$('.carExcludedToggle').change(function() {
		//console.log('Toggle for contestant ' + $(this).data('id') + ' changed to: ' + $(this).prop('checked'));
		var $mySpinner = $(this).closest('td').find('.spinner');
		$mySpinner.removeClass('hidden');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': csrfToken
			}
		});

		$.ajax({
			type: 'PUT',
			url: '/contestants/' + $(this).data('id') + '/exclude',
			data: {
				exclude: $(this).prop('checked')
			},
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$mySpinner.addClass('hidden');
			}
		});
	});

	// Try and protect a user from themselves
	$('form input[type="submit"].btn-danger, form button[type="submit"].btn-danger').click(function(e) {
		var self = this;
		e.preventDefault();
		bootbox.confirm({
			message: 'Are you sure you want to delete this?',
			buttons: {
				confirm: {
					label: 'Yes',
					className: 'btn-danger'
				},
				cancel: {
					label: 'No',
					className: 'btn-default'
				}
			},
			callback: function (result) {
				if (result) {
					$(self).closest('form').submit();
				}
			}
		});
	});

	// Autorefresh the leaderboard
	if ( $('#leaderboard') ) {
		refreshLeaderboardData(); // Load the date in case we didn't turn it on by default

		$('.leaderboardAutoRefreshToggle').change(function() {
			//console.log('Toggle for contestant ' + $(this).data('id') + ' changed to: ' + $(this).prop('checked'));
			var $mySpinner = $(this).closest('td').find('.spinner');
			$mySpinner.removeClass('hidden');

			if ( $(this).prop('checked') ) {
				// Refresh every 10 seconds
				leaderboardRefreshTimer = setTimeout(function(){ callRefreshLeaderboardData(); }, 10000);
				console.log('Timer is enabled');
			} else {
				// remove any timers
				clearTimeout(leaderboardRefreshTimer);
				console.log('Timer is cancelled');
			}

			$mySpinner.addClass('hidden');
		}).change();
	}

	// Replace heat data toggle
	$('.replaceHeatToggle').change(function() {
		//console.log('Toggle for contestant ' + $(this).data('id') + ' changed to: ' + $(this).prop('checked'));
		if ( $(this).prop('checked') ) {
			$('.replaceDataAlert').removeClass('hidden');
		} else {
			$('.replaceDataAlert').addClass('hidden');
		}
	});

});

/*-------------------------------------------------------------------------*/
// Ajax Functions
/*-------------------------------------------------------------------------*/
function refreshLeaderboardData() {
	console.log('Updating leaderboard');
	$('#leaderboardSpinner').removeClass('hidden');
	$("#leaderboard").html('');

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': csrfToken
		}
	});

	$.ajax({
		type: 'GET',
		url: '/derby/leader-board-inner',
		success: function (data) {
			//console.log(data);
			//data = JSON.parse(data);
			$("#leaderboard").html(data);
			$('#leaderboardSpinner').addClass('hidden');
		}
	});
}
function callRefreshLeaderboardData() {
	refreshLeaderboardData();

	// Reset the timer
	leaderboardRefreshTimer = setTimeout(function(){ callRefreshLeaderboardData(); }, 10000);
}