 document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-group input');
            
            // Add floating label effect
            inputs.forEach(input => {
                if(input.value) {
                    moveLabel(input);
                }
                
                input.addEventListener('focus', function() {
                    this.parentNode.querySelector('label').style.color = 'var(--neon-blue)';
                    this.parentNode.querySelector('label').style.textShadow = '0 0 5px var(--neon-blue)';
                });
                
                input.addEventListener('blur', function() {
                    if(!this.value) {
                        const label = this.parentNode.querySelector('label');
                        label.style.color = 'rgba(255,255,255,0.6)';
                        label.style.textShadow = 'none';
                    }
                });
            });
            
            function moveLabel(input) {
                const label = input.nextElementSibling;
                label.style.top = '-10px';
                label.style.fontSize = '12px';
                label.style.background = 'var(--dark-bg)';
                label.style.padding = '0 5px';
                label.style.color = 'var(--neon-blue)';
                label.style.textShadow = '0 0 5px var(--neon-blue)';
            }
            
            // Add random neon particles for effect
            createParticles();
        });
        
        function createParticles() {
            const colors = ['#0ff0fc', '#ff2ced', '#9600ff', '#00ff7f'];
            const container = document.body;
            
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.style.position = 'absolute';
                particle.style.width = Math.random() * 3 + 1 + 'px';
                particle.style.height = particle.style.width;
                particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                particle.style.borderRadius = '50%';
                particle.style.opacity = '0.5';
                particle.style.boxShadow = `0 0 ${Math.random() * 10 + 5}px currentColor`;
                particle.style.top = Math.random() * 100 + 'vh';
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.zIndex = '-1';
                particle.style.animation = `float ${Math.random() * 10 + 10}s linear infinite`;
                
                document.body.appendChild(particle);
                
                // Animate particles
                setInterval(() => {
                    particle.style.top = Math.random() * 100 + 'vh';
                    particle.style.left = Math.random() * 100 + 'vw';
                }, Math.random() * 10000 + 10000);
            }
        }