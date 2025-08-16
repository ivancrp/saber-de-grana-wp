/**
 * Popup Exit Intent - Saber de Grana
 * Funcionalidades modernas e responsivas
 */

(function() {
    'use strict';

    // Configurações
    const CONFIG = {
        maxShows: window.exitIntentConfig?.maxShows || 1,
        cookieDuration: window.exitIntentConfig?.cookieDuration || 1,
        ajaxUrl: window.exitIntentConfig?.ajaxUrl || '/wp-admin/admin-ajax.php',
        isAdmin: window.exitIntentConfig?.isAdmin || false
    };

    // Estado da aplicação
    let state = {
        exitIntentShown: false,
        mouseLeaveCount: 0,
        isInitialized: false
    };

    // Elementos DOM
    let elements = {
        popup: null,
        form: null,
        closeBtn: null,
        messageDiv: null,
        testPanel: null
    };

    /**
     * Inicializa a popup
     */
    function init() {
        if (state.isInitialized) return;
        
        // Verificar se já foi mostrada
        if (getCookie('exit_intent_shown') && !CONFIG.isAdmin) {
            return;
        }

        // Configurar elementos
        setupElements();
        
        // Adicionar event listeners
        setupEventListeners();
        
        // Adicionar painel de teste para admins
        if (CONFIG.isAdmin) {
            addTestPanel();
        }

        state.isInitialized = true;
    }

    /**
     * Configura os elementos DOM
     */
    function setupElements() {
        elements.popup = document.getElementById('exit-intent-popup');
        elements.form = document.getElementById('exit-intent-form');
        elements.closeBtn = document.querySelector('.exit-intent-close');
        elements.messageDiv = document.getElementById('exit-intent-message');
    }

    /**
     * Configura os event listeners
     */
    function setupEventListeners() {
        // Detectar exit intent
        document.addEventListener('mouseleave', handleMouseLeave);
        document.addEventListener('mouseout', handleMouseOut);
        
        // Fechar popup
        if (elements.closeBtn) {
            elements.closeBtn.addEventListener('click', closePopup);
        }
        
        // Fechar com ESC
        document.addEventListener('keydown', handleKeydown);
        
        // Processar formulário
        if (elements.form) {
            setupFormValidation();
            elements.form.addEventListener('submit', handleFormSubmit);
        }
    }

    /**
     * Manipula o evento mouseleave
     */
    function handleMouseLeave(e) {
        if (e.clientY <= 0 && !state.exitIntentShown && state.mouseLeaveCount < CONFIG.maxShows) {
            state.mouseLeaveCount++;
            showPopup();
        }
    }

    /**
     * Manipula o evento mouseout
     */
    function handleMouseOut(e) {
        if (e.relatedTarget === null && !state.exitIntentShown && state.mouseLeaveCount < CONFIG.maxShows) {
            state.mouseLeaveCount++;
            showPopup();
        }
    }

    /**
     * Manipula eventos de teclado
     */
    function handleKeydown(e) {
        if (e.key === 'Escape') {
            closePopup();
        }
        
        // Atalhos para admins
        if (CONFIG.isAdmin) {
            if (e.ctrlKey && e.shiftKey && e.key === 'P') {
                e.preventDefault();
                showPopup();
            }
            if (e.ctrlKey && e.shiftKey && e.key === 'R') {
                e.preventDefault();
                resetState();
            }
        }
    }

    /**
     * Mostra a popup
     */
    function showPopup() {
        if (state.exitIntentShown || !elements.popup) return;
        
        state.exitIntentShown = true;
        elements.popup.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Definir cookie para não mostrar novamente (exceto para admins)
        if (!CONFIG.isAdmin) {
            setCookie('exit_intent_shown', 'true', CONFIG.cookieDuration);
        }
        
        // Focar no primeiro campo
        const firstInput = elements.popup.querySelector('input');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 300);
        }
    }

    /**
     * Fecha a popup
     */
    function closePopup() {
        if (!elements.popup) return;
        
        elements.popup.classList.remove('show');
        document.body.style.overflow = '';
        
        // Limpar formulário e mensagens
        if (elements.form) {
            elements.form.reset();
            clearFormErrors();
        }
        if (elements.messageDiv) {
            elements.messageDiv.style.display = 'none';
        }
    }

    /**
     * Configura validação do formulário
     */
    function setupFormValidation() {
        const inputs = elements.form.querySelectorAll('input[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearFieldError);
        });
    }

    /**
     * Valida um campo individual
     */
    function validateField() {
        const input = this;
        const value = input.value.trim();
        const type = input.type;
        let isValid = true;
        let errorMessage = '';
        
        // Remover mensagem de erro anterior
        clearFieldError.call(input);
        
        // Validações específicas
        if (type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Por favor, insira um e-mail válido.';
            }
        } else if (type === 'text') {
            if (value.length < 2) {
                isValid = false;
                errorMessage = 'Por favor, insira seu nome completo.';
            }
        }
        
        // Validação geral de campo obrigatório
        if (!value) {
            isValid = false;
            errorMessage = 'Este campo é obrigatório.';
        }
        
        if (!isValid) {
            showFieldError(input, errorMessage);
        }
        
        return isValid;
    }

    /**
     * Mostra erro no campo
     */
    function showFieldError(input, message) {
        input.classList.add('error');
        
        // Criar elemento de erro se não existir
        let errorElement = input.parentNode.querySelector('.field-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'field-error';
            errorElement.style.cssText = 'color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; font-weight: 500;';
            input.parentNode.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    /**
     * Limpa erro do campo
     */
    function clearFieldError() {
        const input = this;
        input.classList.remove('error');
        
        const errorElement = input.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    /**
     * Limpa todos os erros do formulário
     */
    function clearFormErrors() {
        const inputs = elements.form.querySelectorAll('input');
        inputs.forEach(input => {
            clearFieldError.call(input);
        });
    }

    /**
     * Manipula o envio do formulário
     */
    async function handleFormSubmit(e) {
        e.preventDefault();
        
        // Validar todos os campos
        const inputs = elements.form.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!validateField.call(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            return;
        }
        
        const submitBtn = elements.form.querySelector('button[type="submit"]');
        const formData = new FormData(elements.form);
        
        try {
            // Desabilitar botão e mostrar loading
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            
            // Limpar mensagens anteriores
            if (elements.messageDiv) {
                elements.messageDiv.style.display = 'none';
                elements.messageDiv.className = 'message';
            }
            
            // Adicionar action para o AJAX
            formData.append('action', 'exit_intent_submit');
            
            // Enviar requisição
            const response = await fetch(CONFIG.ajaxUrl, {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            
            const data = await response.json();
            
            if (data.success) {
                showMessage(data.message, 'success');
                elements.form.reset();
                
                // Fechar popup após 3 segundos
                setTimeout(() => {
                    closePopup();
                }, 3000);
            } else {
                showMessage(data.message, 'error');
            }
            
        } catch (error) {
            console.error('Erro no formulário:', error);
            showMessage('Erro ao enviar. Tente novamente.', 'error');
        } finally {
            // Reabilitar botão
            submitBtn.disabled = false;
            submitBtn.classList.remove('loading');
        }
    }

    /**
     * Mostra mensagem
     */
    function showMessage(message, type) {
        if (!elements.messageDiv) return;
        
        elements.messageDiv.textContent = message;
        elements.messageDiv.className = `message ${type}`;
        elements.messageDiv.style.display = 'block';
    }

    /**
     * Adiciona painel de teste para administradores
     */
    function addTestPanel() {
        const testPanel = document.createElement('div');
        testPanel.className = 'admin-test-panel';
        testPanel.innerHTML = `
            <div class="panel-header">
                🧪 Painel de Teste
            </div>
            <div class="panel-buttons">
                <button id="test-popup-btn">
                    ▶️ Testar Popup
                </button>
                <button id="reset-popup-btn" class="reset">
                    🔄 Resetar Estado
                </button>
            </div>
            <div class="shortcuts">
                Ctrl+Shift+P | Ctrl+Shift+R
            </div>
        `;
        
        document.body.appendChild(testPanel);
        elements.testPanel = testPanel;
        
        // Event listeners dos botões
        document.getElementById('test-popup-btn').addEventListener('click', showPopup);
        document.getElementById('reset-popup-btn').addEventListener('click', resetState);
    }

    /**
     * Reseta o estado da popup
     */
    function resetState() {
        state.exitIntentShown = false;
        state.mouseLeaveCount = 0;
        setCookie('exit_intent_shown', '', -1); // Remove o cookie
        
        // Feedback visual
        const resetBtn = document.getElementById('reset-popup-btn');
        if (resetBtn) {
            const originalText = resetBtn.innerHTML;
            resetBtn.innerHTML = '✅ Resetado!';
            resetBtn.classList.add('success');
            
            setTimeout(() => {
                resetBtn.innerHTML = originalText;
                resetBtn.classList.remove('success');
            }, 2000);
        }
        
        console.log('Estado da popup resetado! Agora você pode testar novamente.');
    }

    /**
     * Define um cookie
     */
    function setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
    }

    /**
     * Obtém um cookie
     */
    function getCookie(name) {
        const nameEQ = name + '=';
        const ca = document.cookie.split(';');
        
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length, c.length);
            }
        }
        return null;
    }

    // Inicializar quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expor funções para uso global (se necessário)
    window.ExitIntentPopup = {
        show: showPopup,
        close: closePopup,
        reset: resetState
    };

})(); 