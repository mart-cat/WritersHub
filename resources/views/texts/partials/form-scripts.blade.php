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

    document.getElementById('edit_docx').addEventListener('click', function () {
        document.getElementById('text_container').style.display = 'block';
        this.style.display = 'none';
        document.getElementById('content').setAttribute('required', 'true');
    });

    function switchTab(tab) {
        const headerTab = document.getElementById('form-header');
        const chaptersTab = document.getElementById('form-chapters');
        const tabHeaderBtn = document.getElementById('tab-header');
        const tabChaptersBtn = document.getElementById('tab-chapters');

        if (tab === 'header') {
            headerTab.style.display = 'block';
            chaptersTab.style.display = 'none';
            tabHeaderBtn.classList.add('active');
            tabChaptersBtn.classList.remove('active');
        } else {
            headerTab.style.display = 'none';
            chaptersTab.style.display = 'block';
            tabHeaderBtn.classList.remove('active');
            tabChaptersBtn.classList.add('active');
        }
    }
</script>
