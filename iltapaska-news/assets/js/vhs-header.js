(function () {
	'use strict';

	function pad(n) {
		return String(n).padStart(2, '0');
	}

	function tick() {
		var el = document.getElementById('vhs-header-clock');
		if (!el) {
			return;
		}
		var d = new Date();
		var dateStr =
			pad(d.getMonth() + 1) +
			'/' +
			pad(d.getDate()) +
			'/' +
			d.getFullYear();
		var timeStr =
			pad(d.getHours()) +
			':' +
			pad(d.getMinutes()) +
			':' +
			pad(d.getSeconds());
		el.innerHTML =
			'<div>' +
			dateStr +
			'</div><div>' +
			timeStr +
			'</div>';
	}

	tick();
	setInterval(tick, 1000);
})();
