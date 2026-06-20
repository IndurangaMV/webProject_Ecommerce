document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.sidebar-menu .menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Get target section key
            const target = this.getAttribute('data-target');
            if (!target) return; // Ignore if it's the Log Out item

            // Prevent default anchor link jump behavior
            e.preventDefault();

            // 1. Manage Active Class on Sidebar Rows
            document.querySelectorAll('.sidebar-menu .menu-item').forEach(li => {
                li.classList.remove('active');
            });
            this.classList.add('active');

            // 2. Manage Active Content in Main Container
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active-content');
            });
            
            const targetSection = document.getElementById(`section-${target}`);
            if (targetSection) {
                targetSection.classList.add('active-content');
            }
        });
    });
});
// Toggle password visibility field types
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function() {
        const input = this.parentElement.querySelector('input');
        if (input.type === 'password') {
            input.type = 'text';
            this.classList.replace('fa-regular', 'fa-solid'); // filled eye
        } else {
            input.type = 'password';
            this.classList.replace('fa-solid', 'fa-regular'); // outline eye
        }
    });
});