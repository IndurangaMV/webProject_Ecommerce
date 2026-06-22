document.addEventListener('DOMContentLoaded', () => {
    
    /* --- Seller Sidebar Tab Switching --- */
    document.querySelectorAll('.sidebar-menu .menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const target = this.getAttribute('data-target');
            if (!target) return;

            e.preventDefault();

            document.querySelectorAll('.sidebar-menu .menu-item').forEach(li => {
                li.classList.remove('active');
            });
            this.classList.add('active');

            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active-content');
            });
            
            const targetSection = document.getElementById(`section-${target}`);
            if (targetSection) {
                targetSection.classList.add('active-content');
            }
        });
    });

    /* --- Password Visibility Toggle Function --- */
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            // Safe traversal: locate the parent container dynamically
            const parentContainer = this.closest('.password-wrapper') || this.parentElement;
            const input = parentContainer.querySelector('input');
            
            if (input && input.type === 'password') {
                input.type = 'text';
                this.classList.replace('fa-regular', 'fa-solid');
            } else if (input) {
                input.type = 'password';
                this.classList.replace('fa-solid', 'fa-regular');
            }
        });
    });

});