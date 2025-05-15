// Add active class to current page link
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();
        const links = document.querySelectorAll('.sidebar ul li a');
        
        links.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
        
        // Mobile toggle functionality
        const sidebar = document.querySelector('.sidebar');
        if (window.innerWidth <= 768) {
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && e.target.className !== 'sidebar-toggle') {
                    sidebar.classList.remove('active');
                }
            });
        }
    });