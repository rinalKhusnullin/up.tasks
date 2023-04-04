window.addEventListener('load', function () {
    tabs = document.querySelector('.panel-tabs').querySelectorAll('a');
    tabs.forEach(element => {
        element.addEventListener('click', function () {
            active_tab = document.querySelector('.panel-tabs').querySelector('.is-active');
            active_table = document.getElementById(active_tab.innerHTML);

            table = document.getElementById(element.innerHTML);

            if (!element.classList.contains('is-active')) {
                table.classList.remove('hidden');
                element.classList.add('is-active');
                active_table.classList.add('hidden');
                active_tab.classList.remove('is-active');
            }
        })
    });
})