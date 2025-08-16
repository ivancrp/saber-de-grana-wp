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

    // Efeito de scroll para sidebar
    const sidebarContainer = document.querySelector('.latest-posts-sidebar');
    const sidebarElements = document.querySelectorAll('.sidebar-element');
    
    if (sidebarContainer && sidebarElements.length > 0) {
        let lastScrollY = window.scrollY;
        let ticking = false;
        let lastScrollDirection = '';
        
        function updateSidebarScroll() {
            const currentScrollY = window.scrollY;
            const scrollDirection = currentScrollY > lastScrollY ? 'down' : 'up';
            const scrollDistance = Math.abs(currentScrollY - lastScrollY);
            
            // Aplicar efeito baseado na direção do scroll
            if (scrollDistance > 3) { // Threshold maior para reduzir mudanças frequentes
                // Só aplicar se a direção mudou para evitar piscar
                if (scrollDirection !== lastScrollDirection) {
                    // Remover classes anteriores
                    sidebarContainer.classList.remove('scroll-up', 'scroll-down');
                    
                    // Adicionar nova classe
                    sidebarContainer.classList.add(`scroll-${scrollDirection}`);
                    
                    // Aplicar efeito nos elementos individuais com delay maior
                    sidebarElements.forEach((element, index) => {
                        // Remover classes anteriores
                        element.classList.remove('fade-in', 'fade-out');
                        
                        // Aplicar nova classe com delay maior
                        setTimeout(() => {
                            if (scrollDirection === 'down') {
                                element.classList.add('fade-out');
                            } else {
                                element.classList.add('fade-in');
                            }
                        }, index * 50); // Delay maior para transição mais suave
                    });
                    
                    lastScrollDirection = scrollDirection;
                }
            }
            
            lastScrollY = currentScrollY;
            ticking = false;
        }
        
        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateSidebarScroll);
                ticking = true;
            }
        }
        
        // Adicionar evento de scroll
        window.addEventListener('scroll', requestTick, { passive: true });
        
        // Inicializar estado - garantir que todos os elementos estejam visíveis
        sidebarElements.forEach(element => {
            element.classList.add('fade-in');
        });
        
        // Limpar classes de scroll após um tempo para resetar o estado
        setTimeout(() => {
            sidebarContainer.classList.remove('scroll-up', 'scroll-down');
            lastScrollDirection = '';
        }, 1000); // Tempo maior para reset
        
        // Verificar se há conteúdo suficiente para scroll
        const documentHeight = document.documentElement.scrollHeight;
        const windowHeight = window.innerHeight;
        
        if (documentHeight <= windowHeight) {
            // Se não há scroll suficiente, desabilitar o efeito
            sidebarContainer.style.position = 'static';
        }
        
        // Adicionar evento de redimensionamento para reativar o efeito se necessário
        window.addEventListener('resize', () => {
            const newDocumentHeight = document.documentElement.scrollHeight;
            const newWindowHeight = window.innerHeight;
            
            if (newDocumentHeight > newWindowHeight) {
                sidebarContainer.style.position = 'sticky';
            } else {
                sidebarContainer.style.position = 'static';
            }
        });
    }
});

// Máscara de moeda e número para a calculadora de ponto de equilíbrio
function aplicarMascaraMoeda(input) {
    input.addEventListener('input', function(e) {
        let v = input.value.replace(/\D/g, '');
        v = (v/100).toFixed(2) + '';
        v = v.replace('.', ',');
        v = v.replace(/(\d)(\d{3},)/g, '$1.$2');
        input.value = v.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1');
    });
    input.addEventListener('blur', function() {
        if (input.value && !input.value.includes(',')) {
            input.value = input.value + ',00';
        }
    });
}
function aplicarMascaraInteiro(input) {
    input.addEventListener('input', function(e) {
        input.value = input.value.replace(/\D/g, '');
    });
}
function removerMascaraMoeda(valor) {
    if (!valor) return 0;
    return parseFloat(valor.replace(/\./g, '').replace(',', '.'));
}
function pontoEquilibrioInit() {
    // Máscaras
    const camposMoeda = [
        document.getElementById('peq-cft'),
        document.getElementById('peq-cvu'),
        document.getElementById('peq-pvu'),
        document.getElementById('peq-custoMensal')
    ];
    camposMoeda.forEach(function(input) {
        if (input) aplicarMascaraMoeda(input);
    });
    const vendasInput = document.getElementById('peq-vendas');
    if (vendasInput) aplicarMascaraInteiro(vendasInput);

    const form = document.getElementById('ponto-equilibrio-form');
    const btn = document.getElementById('peq-calcular');
    const resultado = document.getElementById('peq-resultado');
    if (!form || !btn) return;

    // Botão Limpar
    const btnLimpar = document.getElementById('peq-limpar');
    if (btnLimpar) {
        btnLimpar.addEventListener('click', function() {
            form.reset();
            camposMoeda.forEach(function(input) { if (input) input.value = ''; });
            if (vendasInput) vendasInput.value = '';
            resultado.classList.add('hidden');
        });
    }

    btn.addEventListener('click', function () {
        const cft = removerMascaraMoeda(document.getElementById('peq-cft').value);
        const cvu = removerMascaraMoeda(document.getElementById('peq-cvu').value);
        const pvu = removerMascaraMoeda(document.getElementById('peq-pvu').value);

        if (isNaN(cft) || isNaN(cvu) || isNaN(pvu)) {
            alert('Preencha os campos obrigatórios corretamente.');
            return;
        }

        const mcu = pvu - cvu;
        if (mcu <= 0) {
            alert('Erro: A Margem de Contribuição (PVU - CVU) deve ser maior que zero.');
            return;
        }

        const peq = cft / mcu;
        const pef = peq * pvu;

        document.getElementById('peq-mcu').innerText = mcu.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        document.getElementById('peq-peq').innerText = Math.ceil(peq);
        document.getElementById('peq-pef').innerText = pef.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        resultado.classList.remove('hidden');
        resultado.scrollIntoView({ behavior: 'smooth' });
    });
}
document.addEventListener('DOMContentLoaded', pontoEquilibrioInit);