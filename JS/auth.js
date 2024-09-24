if (window.location.pathname.includes('../HTML/admin.html')) {
    // Ação ao enviar o formulário
    document.getElementById('auth-form').addEventListener('submit', function(event) {
        event.preventDefault(); 

        const inputCode = document.getElementById('auth-code').value;

        fetch('db.json')
            .then(response => response.json())
            .then(data => {
                const correctCode = data.authCode;

                if (inputCode === correctCode) {
                    // Salva a autenticação no LocalStorage
                    localStorage.setItem('isAuthenticated', 'true');
                    
                    // Redireciona para a página pós login
                    window.location.href = "../HTML/admin.html"; 
                } else {
                    document.getElementById('error-msg').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Erro ao carregar o código de autenticação:', error);
            }
        );
    });
}
