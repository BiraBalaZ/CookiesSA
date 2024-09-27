function isAuth(){
    const isAuthenticated = localStorage.getItem('isAuthenticated');
        if (isAuthenticated != "true") {
            // Se não estiver autenticado, redireciona para a página de autenticação
            window.location.href = "login.html";
        }else{
            startLogoutTimer();
        }
}
function logoutUser() {
    alert('Sessão expirada. Você será redirecionado para a página de login.');
    localStorage.removeItem('isAuthenticated'); // Exemplo de remover o estado de login
    window.location.href = 'login.html'; // Redireciona para a página de login
}
function startLogoutTimer() {
    // 600.000 ms = 10 minutos
    logoutTimer = setTimeout(logoutUser, 600000);
}
function resetLogoutTimer() {
    clearTimeout(logoutTimer);
    startLogoutTimer(); // Reinicia o timer
}

if (window.location.pathname.includes('/HTML/login.html')) {
    // Ação ao enviar o formulário
    document.getElementById('auth-form').addEventListener('submit', function(event) {
        event.preventDefault(); 
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        fetch('../JS/db.json')
            .then(response => response.json())
            .then(data => {
                const user = data.login;
                console.log(user);
                if (username === user.usuario && password === user.senha) {
                    // Salva a autenticação no LocalStorage
                    localStorage.setItem('isAuthenticated', 'true');
                    
                    // Redireciona para a página pós login
                    window.location.href = "../PHP/admin_page.php"; 
                } else {
                    alert('Usuario ou senha incorretos')
                    // document.getElementById('error-msg').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Erro ao carregar o código de autenticação:', error);
            }
        );
    });
}


if (window.location.pathname.includes('/HTML/admin.html')) {
    window.onload = isAuth;
}
// Reseta o tempo de login caso a pessoa volte a atividade no site
window.addEventListener('mousemove', resetLogoutTimer);
window.addEventListener('keydown', resetLogoutTimer);