const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");

// Mostrar menu lateral
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

// Fechar menu lateral
closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

// Alternar entre dark e light mode
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');

    // Alternar classe 'active' nos ícones
    const lightIcon = themeToggler.querySelector('span:nth-child(1)');
    const darkIcon = themeToggler.querySelector('span:nth-child(2)');
    lightIcon.classList.toggle('active');
    darkIcon.classList.toggle('active');
});

// Verificar o tema inicial (opcional: pode salvar no localStorage)
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme-variables');
    themeToggler.querySelector('span:nth-child(1)').classList.remove('active');
    themeToggler.querySelector('span:nth-child(2)').classList.add('active');
} else {
    document.body.classList.remove('dark-theme-variables');
    themeToggler.querySelector('span:nth-child(1)').classList.add('active');
    themeToggler.querySelector('span:nth-child(2)').classList.remove('active');
}

// Salvar preferência do tema (opcional)
themeToggler.addEventListener('click', () => {
    if (document.body.classList.contains('dark-theme-variables')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
});
// prencher os campos da tabela
/* Orders.forEach(order => {
    const tr = document.createElement('tr');
    const trContent = '
        <td>${order.productName}</td>;
    '
})
*/
