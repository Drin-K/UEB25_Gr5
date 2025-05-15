   // Mobile menu toggle
        document.getElementById('menu-icon').addEventListener('click', function() {
            document.getElementById('navbar').classList.toggle('active');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            const navbar = document.getElementById('navbar');
            const menuIcon = document.getElementById('menu-icon');
            
            if (!navbar.contains(e.target) && e.target !== menuIcon) {
                navbar.classList.remove('active');
            }
        });