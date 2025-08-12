import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

// Global print handler for User Management
document.addEventListener('livewire:init', () => {
	if (window.__usersPrintListenerAttached) return;
	window.__usersPrintListenerAttached = true;
	if (typeof Livewire === 'undefined') return;

	Livewire.on('print-users', () => {
		const wrap = document.getElementById('users-table-wrapper');
		if (!wrap) { window.print(); return; }

		// Clone content & strip elements not for print
		const clone = wrap.cloneNode(true);
		clone.querySelectorAll('.no-print, nav').forEach(el => el.remove());

		const html = `<!DOCTYPE html><html><head><title>Daftar User</title><meta charset='utf-8'>
			<style>
				*{box-sizing:border-box;}
				body{font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Arial,sans-serif;margin:0;padding:24px;color:#111827;}
				h1{font-size:20px;margin:0 0 16px;font-weight:600;}
				table{width:100%;border-collapse:collapse;font-size:12px;}
				th,td{border:1px solid #e5e7eb;padding:6px 8px;text-align:left;vertical-align:top;}
				th{background:#f3f4f6;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:.05em;}
				@media print { body{padding:8px;} h1{margin-bottom:12px;} }
			</style>
		</head><body><h1>Daftar User</h1>${clone.innerHTML}</body></html>`;

		// Create hidden iframe
		const iframe = document.createElement('iframe');
		iframe.style.position = 'fixed';
		iframe.style.right = '0';
		iframe.style.bottom = '0';
		iframe.style.width = '0';
		iframe.style.height = '0';
		iframe.style.border = '0';
		document.body.appendChild(iframe);

		const doc = iframe.contentDocument || iframe.contentWindow.document;
		doc.open();
		doc.write(html);
		doc.close();

		iframe.onload = () => {
			try {
				iframe.contentWindow.focus();
				iframe.contentWindow.print();
			} finally {
				// Remove iframe after slight delay to allow dialog
				setTimeout(() => iframe.remove(), 2000);
			}
		};
	});

	// Print handler for Kelompok Management
	Livewire.on('print-kelompok', () => {
		const wrap = document.getElementById('kelompok-table-wrapper');
		if (!wrap) { window.print(); return; }

		// Clone content & strip elements not for print
		const clone = wrap.cloneNode(true);
		clone.querySelectorAll('.no-print, nav').forEach(el => el.remove());

		const html = `<!DOCTYPE html><html><head><title>Daftar Kelompok</title><meta charset='utf-8'>
			<style>
				*{box-sizing:border-box;}
				body{font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Arial,sans-serif;margin:0;padding:24px;color:#111827;}
				h1{font-size:20px;margin:0 0 16px;font-weight:600;}
				table{width:100%;border-collapse:collapse;font-size:12px;}
				th,td{border:1px solid #e5e7eb;padding:6px 8px;text-align:left;vertical-align:top;}
				th{background:#f3f4f6;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:.05em;}
				@media print { body{padding:8px;} h1{margin-bottom:12px;} }
			</style>
		</head><body><h1>Daftar Kelompok</h1>${clone.innerHTML}</body></html>`;

		// Create hidden iframe
		const iframe = document.createElement('iframe');
		iframe.style.position = 'fixed';
		iframe.style.right = '0';
		iframe.style.bottom = '0';
		iframe.style.width = '0';
		iframe.style.height = '0';
		iframe.style.border = '0';
		document.body.appendChild(iframe);

		const doc = iframe.contentDocument || iframe.contentWindow.document;
		doc.open();
		doc.write(html);
		doc.close();

		iframe.onload = () => {
			try {
				iframe.contentWindow.focus();
				iframe.contentWindow.print();
			} finally {
				// Remove iframe after slight delay to allow dialog
				setTimeout(() => iframe.remove(), 2000);
			}
		};
	});

	// Print handler for Komoditi Management
	Livewire.on('print-komoditi', () => {
		const wrap = document.getElementById('komoditi-table-wrapper');
		if (!wrap) { window.print(); return; }

		// Clone content & strip elements not for print
		const clone = wrap.cloneNode(true);
		clone.querySelectorAll('.no-print, nav').forEach(el => el.remove());

		const html = `<!DOCTYPE html><html><head><title>Daftar Komoditi</title><meta charset='utf-8'>
			<style>
				*{box-sizing:border-box;}
				body{font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Arial,sans-serif;margin:0;padding:24px;color:#111827;}
				h1{font-size:20px;margin:0 0 16px;font-weight:600;}
				table{width:100%;border-collapse:collapse;font-size:12px;}
				th,td{border:1px solid #e5e7eb;padding:6px 8px;text-align:left;vertical-align:top;}
				th{background:#f3f4f6;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:.05em;}
				@media print { body{padding:8px;} h1{margin-bottom:12px;} }
			</style>
		</head><body><h1>Daftar Komoditi</h1>${clone.innerHTML}</body></html>`;

		// Create hidden iframe
		const iframe = document.createElement('iframe');
		iframe.style.position = 'fixed';
		iframe.style.right = '0';
		iframe.style.bottom = '0';
		iframe.style.width = '0';
		iframe.style.height = '0';
		iframe.style.border = '0';
		document.body.appendChild(iframe);

		const doc = iframe.contentDocument || iframe.contentWindow.document;
		doc.open();
		doc.write(html);
		doc.close();

		iframe.onload = () => {
			try {
				iframe.contentWindow.focus();
				iframe.contentWindow.print();
			} finally {
				// Remove iframe after slight delay to allow dialog
				setTimeout(() => iframe.remove(), 2000);
			}
		};
	});
});

