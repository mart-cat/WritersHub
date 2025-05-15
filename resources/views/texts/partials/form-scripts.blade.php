<script>
    document.getElementById('text_file').addEventListener('change', function () {
        let fileInput = this;
        let file = fileInput.files[0];
        let fileExtension = file.name.split('.').pop().toLowerCase();
        let contentField = document.getElementById('content');
        let textContainer = document.getElementById('text_container');
        let editButton = document.getElementById('edit_docx');

        if (!file) return;

        if (fileExtension === 'txt') {
            let reader = new FileReader();
            reader.onload = function (e) {
                contentField.value = e.target.result;
            };
            reader.readAsText(file);
            textContainer.style.display = 'block';
            editButton.style.display = 'none';
            contentField.removeAttribute('required');
        } else if (fileExtension === 'docx') {
            let formData = new FormData();
            formData.append('text_file', file);

            fetch("{{ route('texts.parseFile') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    contentField.value = data.text;
                    textContainer.style.display = 'none';
                    editButton.style.display = 'block';
                    contentField.removeAttribute('required');
                } else {
                    alert("Ошибка при обработке файла!");
                }
            })
            .catch(error => console.error("Ошибка:", error));
        }
    });

document.addEventListener('DOMContentLoaded', function () {
    const chapterItems = document.querySelectorAll('.chapter-item');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const form = document.getElementById('chapter-form');
    const methodInput = document.getElementById('form-method');
    const chapterIdInput = document.getElementById('chapter_id');

    chapterItems.forEach(item => {
        item.addEventListener('click', () => {
            const chapterId = item.dataset.id;
            const title = item.dataset.title;
            const content = item.dataset.content;

            titleInput.value = title;
            contentInput.value = content;

            form.action = `/сhapter/${chapterId}`;
            methodInput.value = 'PUT';
            chapterIdInput.value = chapterId;
        });
    });
});
</script>
