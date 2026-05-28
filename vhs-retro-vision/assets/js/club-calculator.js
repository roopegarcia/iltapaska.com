(function () {
	const calculators = document.querySelectorAll('[data-club-calculator]');

	calculators.forEach((calculator) => {
		const target = Number(calculator.dataset.target || 454);
		const squatInput = calculator.querySelector('[data-squat-input]');
		const benchInput = calculator.querySelector('[data-bench-input]');
		const squatValue = calculator.querySelector('[data-squat-value]');
		const benchValue = calculator.querySelector('[data-bench-value]');
		const deadliftValue = calculator.querySelector('[data-deadlift-value]');
		const totalValue = calculator.querySelector('[data-total-value]');
		const overWarning = calculator.querySelector('[data-over-warning]');

		if (!squatInput || !benchInput) {
			return;
		}

		const update = function () {
			const squat = Math.round(Number(squatInput.value || 0));
			const bench = Math.round(Number(benchInput.value || 0));
			const baseTotal = squat + bench;
			const remaining = target - baseTotal;
			const deadlift = remaining > 0 ? remaining : 0;
			const total = baseTotal + deadlift;

			squatValue.textContent = String(squat);
			benchValue.textContent = String(bench);
			deadliftValue.textContent = String(Math.round(deadlift));
			totalValue.textContent = String(Math.round(total));

			if (remaining < 0) {
				overWarning.hidden = false;
			} else {
				overWarning.hidden = true;
			}
		};

		squatInput.addEventListener('input', update);
		benchInput.addEventListener('input', update);
		update();
	});
})();
