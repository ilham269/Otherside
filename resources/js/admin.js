import * as bootstrap from 'bootstrap';
import Chart from 'chart.js/auto';

window.bootstrap = bootstrap;
window.Chart = Chart;

// ─── Sidebar Toggle ───────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    const openSidebar  = () => { sidebar?.classList.add('open'); overlay?.classList.remove('d-none'); };
    const closeSidebar = () => { sidebar?.classList.remove('open'); overlay?.classList.add('d-none'); };

    toggleBtn?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);
});
