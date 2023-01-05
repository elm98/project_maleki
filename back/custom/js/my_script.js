$(document).ready(function () {
	$(this).on('click','.tick',function () {
		var ch = $(this).closest('div.checkbox').find('input[type="checkbox"]');
		ch.prop('checked',!ch.prop('checked'));
	});
});

function loading(id) {
	block = (typeof id !== 'undefined' && id!=="" ) ?  id : '#main-app-content';
	$(block).block({
		message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
		timeout: 5000, //unblock after 2 seconds
		overlayCSS: {
			backgroundColor: '#fff',
			opacity: 0.8,
			cursor: 'منتظر بمانید...'
		},
		css: {
			border: 0,
			padding: 0,
			backgroundColor: 'transparent'
		}
	});
}

function unloading(id) {
	block = (typeof id !== 'undefined' && id!=="" ) ?  id : '#main-app-content';
	$(block).unblock();
}


