/**
 * PortalNilai-SMP3 JavaScript Application Scripts
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Password Visibility Toggle
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target') || 'loginPassword';
            const input = document.getElementById(targetId);
            if (input) {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('bi-eye', !isPassword);
                    icon.classList.toggle('bi-eye-slash', isPassword);
                }
            }
        });
    });

    // 2. Demo Login Helper (Quick fill test credentials)
    const demoButtons = document.querySelectorAll('.btn-demo-fill');
    demoButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const role = this.getAttribute('data-role');
            const username = this.getAttribute('data-username');
            const password = this.getAttribute('data-password');

            // Find closest form or modal form
            const form = this.closest('form') || document.querySelector('#formLoginModal') || document.querySelector('#formLogin');
            if (form) {
                const roleSelect = form.querySelector('[name="role"]');
                const usernameInput = form.querySelector('[name="username"]');
                const passwordInput = form.querySelector('[name="password"]');

                if (roleSelect) roleSelect.value = role;
                if (usernameInput) usernameInput.value = username;
                if (passwordInput) passwordInput.value = password;

                // Visual flash effect on inputs
                [usernameInput, passwordInput].forEach(el => {
                    if (el) {
                        el.classList.add('is-valid');
                        setTimeout(() => el.classList.remove('is-valid'), 1500);
                    }
                });
            }
        });
    });

    // 3. Auto dismiss bootstrap alerts after 6 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 6000);
    });

    // 4. Quick print trigger
    const printBtns = document.querySelectorAll('.btn-trigger-print');
    printBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            window.print();
        });
    });
});
