const sidebar = document.getElementById('sidebar');
const toggle = document.getElementById('sidebarToggle');
const backdrop = document.getElementById('sidebarBackdrop');

const closeSidebar = () => {
    sidebar?.classList.remove('show');
    backdrop?.classList.remove('show');
};

toggle?.addEventListener('click', () => {
    sidebar?.classList.toggle('show');
    backdrop?.classList.toggle('show');
});

backdrop?.addEventListener('click', closeSidebar);

const monthlyCanvas = document.getElementById('monthlyChart');
if (monthlyCanvas && window.Chart) {
    new window.Chart(monthlyCanvas, {
        type: 'bar',
        data: {
            labels: JSON.parse(monthlyCanvas.dataset.labels || '[]'),
            datasets: [
                {
                    label: 'Entrees',
                    data: JSON.parse(monthlyCanvas.dataset.entrees || '[]'),
                    backgroundColor: '#BBDEFB',
                    borderColor: '#64B5F6',
                    borderWidth: 1,
                },
                {
                    label: 'Sorties',
                    data: JSON.parse(monthlyCanvas.dataset.sorties || '[]'),
                    backgroundColor: '#F8BBD0',
                    borderColor: '#F06292',
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } },
        },
    });
}

const categoryCanvas = document.getElementById('categoryChart');
if (categoryCanvas && window.Chart) {
    new window.Chart(categoryCanvas, {
        type: 'doughnut',
        data: {
            labels: JSON.parse(categoryCanvas.dataset.labels || '[]'),
            datasets: [{
                data: JSON.parse(categoryCanvas.dataset.values || '[]'),
                backgroundColor: ['#F8BBD0', '#BBDEFB', '#FFFFFF', '#90CAF9', '#F48FB1', '#E3F2FD'],
                borderColor: '#ffffff',
                borderWidth: 2,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        },
    });
}
