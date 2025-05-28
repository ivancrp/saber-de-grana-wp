/**
 * Main JavaScript file for Saber de Grana theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // Manipulação do menu móvel
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            
            // Alternar o ícone do botão
            const isOpen = !mobileMenu.classList.contains('hidden');
            if (isOpen) {
                mobileMenuToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-white"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
            } else {
                mobileMenuToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-white"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';
            }
        });
    }
    
    // Efeito de scroll no header
    const header = document.querySelector('header#masthead');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
            } else {
                header.classList.remove('shadow-md');
            }
        });
        
        // Verificar a posição inicial da página
        if (window.scrollY > 10) {
            header.classList.add('shadow-md');
        }
    }
    
    // Manipulação do formulário de newsletter
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterResponse = document.getElementById('newsletter-response');
    
    if (newsletterForm && newsletterResponse) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(newsletterForm);
            formData.append('action', 'newsletter_subscribe');
            
            fetch(saberdegranaData.ajaxUrl, {
                method: 'POST',
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                newsletterResponse.innerHTML = data.message;
                newsletterResponse.classList.remove('hidden', 'text-red-600', 'text-green-600');
                
                if (data.success) {
                    newsletterResponse.classList.add('text-green-600');
                    newsletterForm.reset();
                } else {
                    newsletterResponse.classList.add('text-red-600');
                }
            })
            .catch(err => {
                newsletterResponse.innerHTML = 'Ocorreu um erro. Por favor, tente novamente.';
                newsletterResponse.classList.remove('hidden');
                newsletterResponse.classList.add('text-red-600');
            });
        });
    }
    
    // Manipulação do formulário de newsletter compacto
    const newsletterFormCompact = document.getElementById('newsletter-form-compact');
    const newsletterResponseCompact = document.getElementById('newsletter-response-compact');
    
    if (newsletterFormCompact && newsletterResponseCompact) {
        newsletterFormCompact.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(newsletterFormCompact);
            formData.append('action', 'newsletter_subscribe');
            
            fetch(saberdegranaData.ajaxUrl, {
                method: 'POST',
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                newsletterResponseCompact.innerHTML = data.message;
                newsletterResponseCompact.classList.remove('hidden', 'text-red-600', 'text-green-600');
                
                if (data.success) {
                    newsletterResponseCompact.classList.add('text-green-600');
                    newsletterFormCompact.reset();
                } else {
                    newsletterResponseCompact.classList.add('text-red-600');
                }
            })
            .catch(err => {
                newsletterResponseCompact.innerHTML = 'Ocorreu um erro. Por favor, tente novamente.';
                newsletterResponseCompact.classList.remove('hidden');
                newsletterResponseCompact.classList.add('text-red-600');
            });
        });
    }
    
    // Remover script duplicado do footer
    const footerScript = document.querySelector('footer script');
    if (footerScript) {
        footerScript.remove();
    }
    
    // Corrigir problema de padding no elemento page
    const pageElement = document.getElementById('page');
    if (pageElement) {
        // Ajusta o padding-top baseado na altura do cabeçalho
        const headerHeight = header ? header.offsetHeight : 0;
        pageElement.style.paddingTop = headerHeight + 'px';
        
        // Adicionar evento de redimensionamento para ajustar o padding quando a tela for redimensionada
        window.addEventListener('resize', function() {
            const headerHeight = header ? header.offsetHeight : 0;
            pageElement.style.paddingTop = headerHeight + 'px';
        });
    }
    
    // Destacar links do menu atual
    const currentUrl = window.location.href;
    const menuLinks = document.querySelectorAll('.primary-menu a, .mobile-menu a');
    
    menuLinks.forEach(function(link) {
        if (link.href === currentUrl || currentUrl.includes(link.href)) {
            link.classList.add('active');
        }
    });
});