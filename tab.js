document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.feature-menu .action-button');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const feature = button.getAttribute('data-feature');
            const section = document.getElementById(feature);

            if (section) {
                section.classList.toggle('active');
            } else {
                // Динамически загружаем контент из файла
                fetch(`${feature}.php`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        const newSection = document.createElement('div');
                        newSection.id = feature;
                        newSection.classList.add('feature-section', 'active');
                        newSection.innerHTML = data;
                        document.querySelector('.content').appendChild(newSection);
                    })
                    .catch(error => console.error('Error loading feature:', error));
            }
        });
    });
});