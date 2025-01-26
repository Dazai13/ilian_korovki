document.addEventListener('DOMContentLoaded', () => {
    const loginWindow = document.getElementById('login');
    const registerWindow = document.getElementById('reg');

    const toRegister = document.getElementById('to-register');
    const toLogin = document.getElementById('to-login');

    toRegister.addEventListener('click', (e) => {
        e.preventDefault();
        loginWindow.classList.add('hidden');
        registerWindow.classList.remove('hidden');
    });

    toLogin.addEventListener('click', (e) => {
        e.preventDefault(); 
        registerWindow.classList.add('hidden');
        loginWindow.classList.remove('hidden');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#contactForm');

    if (!form) {
        console.error('Форма не найдена!');
        return;
    }


    form.addEventListener('submit', async function (e) {
        console.log('Submit обработчик вызван!');
        e.preventDefault();

        console.log('Отправка формы началась.');

        const formData = new FormData(form);

        formData.forEach((value, key) => {
            console.log(key, value);
        });

        try {

            const response = await fetch('/backend/send_message.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();
            console.log('Результат ответа:', result);

            if (result.status === 'success') {
                console.log('Сообщение об успехе:', result.message);
                window.location.href = '/index.php';
            } else {
                console.log('Ошибка от сервера:', result.message);
            }
        } catch (error) {

            console.error('Ошибка в процессе отправки:', error);
        }

        return false; 
    });
});
