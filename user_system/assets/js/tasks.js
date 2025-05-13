document.addEventListener('DOMContentLoaded', function() {
    // التبديل بين طرق العرض
    document.getElementById('listView').addEventListener('click', function() {
        document.querySelector('.tasks-list').classList.add('list-view');
        document.querySelector('.tasks-list').classList.remove('grid-view');
        this.classList.add('active');
        document.getElementById('gridView').classList.remove('active');
    });

    document.getElementById('gridView').addEventListener('click', function() {
        document.querySelector('.tasks-list').classList.add('grid-view');
        document.querySelector('.tasks-list').classList.remove('list-view');
        this.classList.add('active');
        document.getElementById('listView').classList.remove('active');
    });

    // تبديل تفاصيل المهمة
    function toggleTaskDetails(element) {
        const details = element.nextElementSibling;
        details.style.display = details.style.display === 'none' ? 'block' : 'none';
        const icon = element.querySelector('i');
        icon.classList.toggle('fa-chevron-up');
        icon.classList.toggle('fa-chevron-down');
    }

    window.toggleTaskDetails = toggleTaskDetails;

    // تصفية المهام
    document.getElementById('filterStatus').addEventListener('change', function() {
        const status = this.value;
        document.querySelectorAll('.task-item').forEach(task => {
            if (status === 'all' || task.dataset.status === status) {
                task.style.display = 'block';
            } else {
                task.style.display = 'none';
            }
        });
    });

    // البحث في المهام
    document.getElementById('taskSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.task-item').forEach(task => {
            const title = task.querySelector('.task-title').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                task.style.display = 'block';
            } else {
                task.style.display = 'none';
            }
        });
    });

    // تحميل المهام من localStorage للوضع الضيف
    if (localStorage.getItem('guest_tasks')) {
        const guestTasks = JSON.parse(localStorage.getItem('guest_tasks'));
        // عرض المهام أو تحديث القائمة
    }

    // إدارة المهام (إضافة/تعديل/حذف)
    // ... (الكود الأصلي لإدارة المهام)
});